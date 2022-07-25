<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('name');
            $table->string('contact');
            $table->enum('role', [1, 2, 3])->default(3);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        $defaultUserData = [
            [
                'name' => "Super Admin",
                'email' => "superadmin@gharagan.com",
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'contact' => "123456789",
                'role' => 1
            ],

            [
                'name' => "Admin",
                'email' => "admin@gharagan.com",
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'contact' => "123456789",
                'role' => 2
            ],

            [
                'name' => "Client",
                'email' => "client@gharagan.com",
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'contact' => "123456789",
                'role' => 3,
                'email_verified_at' => "2022-07-23 00:00:00"
            ],

        ];

        User::insert($defaultUserData);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
