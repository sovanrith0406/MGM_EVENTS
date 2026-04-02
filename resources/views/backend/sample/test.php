


// ============================================================
// STEP 2: USER MODEL — app/Models/User.php
// ============================================================

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table      = 'users';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'role_id', 'full_name', 'email', 'password_hash', 'avatar_url', 'is_active',
    ];

    protected $hidden = ['password_hash'];

    // Maps Laravel auth → your password_hash column
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    // Role helpers — matches your actual role_id values
    public function isAdmin(): bool    { return $this->role_id === 1; }
    public function isUser(): bool     { return $this->role_id === 2; }
    public function isSupplier(): bool { return $this->role_id === 3; }

    public function hasRole(int|array $roleId): bool
    {
        return in_array($this->role_id, (array) $roleId);
    }
}


// ============================================================
// STEP 3: ROLE MODEL — app/Models/Role.php
// ============================================================

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table      = 'roles';
    protected $primaryKey = 'role_id';
    public $timestamps    = false;

    protected $fillable = ['role_name'];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'role_id');
    }
}


// ============================================================
// STEP 4: LOGIN CONTROLLER — app/Http/Controllers/AuthController.php
// ============================================================

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Support login by email OR full_name
        $field = filter_var($request->username, FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'full_name';

        $credentials = [
            $field     => $request->username,
            'password' => $request->password,
        ];

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['username' => 'Invalid credentials.']);
        }

        if (!Auth::user()->is_active) {
            Auth::logout();
            return back()->withErrors(['username' => 'Your account has been deactivated.']);
        }

        $request->session()->regenerate();

        // Redirect by role after login
        return match(Auth::user()->role_id) {
            1 => redirect()->route('backend.dashboard'),        // Admin → full dashboard
            2 => redirect()->route('events.index'),             // User  → events page
            3 => redirect()->route('supplier_booking.index'),   // Supplier → booking page
            default => redirect()->route('backend.dashboard'),
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}


// ============================================================
// STEP 5: MIDDLEWARE — app/Http/Middleware/CheckRole.php
// ============================================================

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    // Usage: middleware('role:1')  or  middleware('role:1,2')
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!in_array((string) Auth::user()->role_id, $roles)) {
            abort(403, 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}


// ============================================================
// STEP 6: REGISTER MIDDLEWARE — app/Http/Kernel.php
// ============================================================

protected $routeMiddleware = [
    // ... existing entries ...
    'role' => \App\Http\Middleware\CheckRole::class,
];


// ============================================================
// STEP 7: ROUTES — routes/web.php
// ============================================================

// Public
Route::get('/login',   [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',  [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    // ── All roles: Admin(1), User(2), Supplier(3) ──
    Route::get('/',        fn() => view('backend.dashboard'))->name('backend.dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');

    // ── Admin(1) + User(2) only ──
    Route::middleware('role:1,2')->group(function () {
        Route::get('/events',   [EventController::class,   'index'])->name('events.index');
        Route::get('/speakers', [SpeakerController::class, 'index']);
        Route::get('/schedule', [ScheduleController::class,'index']);
        Route::get('/sponsors', [SponsorController::class, 'index']);
        Route::get('/mailbox',  [MailboxController::class, 'inbox']);
        Route::get('/compose',  [MailboxController::class, 'compose']);
        Route::get('/read_mail',[MailboxController::class, 'read']);
    });

    // ── Admin(1) + Supplier(3) only ──
    Route::middleware('role:1,3')->group(function () {
        Route::resource('/supplier_booking', BookingController::class)
             ->names('supplier_booking');
    });

    // ── Admin(1) only ──
    Route::middleware('role:1')->group(function () {
        Route::resource('/users', UserController::class);
    });
});