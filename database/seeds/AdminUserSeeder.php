<?php

use App\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$userData = [
		    'name' => 'admin',
            'email' => config('app.user_email', 'jixzignacio@gmail.com'),
		    'username' => config('app.user_username', 'admin'),
            'password' => bcrypt('admin'),
		    'remember_token' => null
		];
    	$user = User::find(1);

    	if(!$user){
    		$userData['id'] = 1;
    		DB::table('users')->insert($userData);
    	} else {
    		DB::table('users')
    			->where('id', 1)
    			->update($userData);
    	}

    	DB::table('room_types')->insert([
    		'name' => 'Regular'
    	]);
        
        DB::table('room_rates')->insert([
            'room_type_id' => 1,
            'name' => '12 Hours',
            'hours' => '12',
            'price' => 0
        ]);
        
    }
}
