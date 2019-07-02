<?php

use Illuminate\Database\Seeder;
use App\User;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	$user = new User;
    	$user->name = 'admin';
    	$user->email = 'admin@admin.com';
    	$user->password = bcrypt('password');
    	$user->level = 'admin';
    	$user->save();
        // $this->call(UsersTableSeeder::class);
    }
}
