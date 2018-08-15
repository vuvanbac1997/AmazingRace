<?php

use Illuminate\Database\Seeder;
use App\Models\AdminUser;
use App\Models\AdminUserRole;

class AdminUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $admin = factory( AdminUser::class )->create(
            [
                'name'     => 'Administrator',
                'email'    => 'admin@example.com',
                'password' => '123',
            ]
        );
        factory( AdminUserRole::class )->create(
            [
                'admin_user_id' => $admin->id,
                'role'          => AdminUserRole::ROLE_ADMIN,
            ]
        );

        $coach = factory( AdminUser::class )->create(
            [
                'name'     => 'Coach',
                'email'    => 'coach@example.com',
                'password' => '123',
            ]
        );
        factory( AdminUserRole::class )->create(
            [
                'admin_user_id' => $coach->id,
                'role'          => AdminUserRole::ROLE_COACH,
            ]
        );

        $player = factory( AdminUser::class )->create(
            [
                'name'     => 'Player',
                'email'    => 'player@example.com',
                'password' => '123',
            ]
        );
        factory( AdminUserRole::class )->create(
            [
                'admin_user_id' => $player->id,
                'role'          => AdminUserRole::ROLE_PLAYER,
            ]
        );
    }
}
