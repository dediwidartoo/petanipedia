<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$users = [
    		'username' => 'admin',
	        'email' => 'admin@admin.com',
	        'password' => bcrypt('admin'),
	        'remember_token' => str_random(16),
	        'api_token' => str_random(24),
	        'is_admin' => true,
    	];

        
    	DB::table('users')->insert($users);


        factory(App\Models\User::class,60)->create();
    }
}
