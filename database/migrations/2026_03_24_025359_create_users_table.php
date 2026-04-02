    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        /**
         * Run the migrations.
         */
        public function up(): void
        {
            Schema::create('users', function (Blueprint $table) {
                // Primary Key: user_id bigint NOT NULL AUTO_INCREMENT
                $table->id('user_id'); 
                
                // role_id int NOT NULL
                $table->integer('role_id');
                
                // full_name varchar(120) NOT NULL
                $table->string('full_name', 120);
                
                // email varchar(190) NOT NULL UNIQUE
                $table->string('email', 190)->unique();
                
                // password_hash varchar(255) NOT NULL
                $table->string('password_hash', 255);
                
                // avatar_url varchar(500) DEFAULT NULL
                $table->string('avatar_url', 500)->nullable();
                
                // is_active tinyint(1) NOT NULL DEFAULT '1'
                $table->boolean('is_active')->default(true);
                
                // created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
                $table->timestamp('created_at')->useCurrent();
                
                // updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

                // KEY `fk_users_role` (`role_id`)
                $table->index('role_id', 'fk_users_role');
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('users');
        }
    };