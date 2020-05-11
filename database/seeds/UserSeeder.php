<?php

use App\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'login'=>'admin',
            'password'=>Hash::make('admin'),
            'role_id'=>Role::where('role','admin')->first()->id,
        ]);
    }
}
