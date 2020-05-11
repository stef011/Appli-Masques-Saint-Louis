<?php

use Illuminate\Database\Seeder;

class QuartierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('quartiers')->insert([
            ['nom'=>'Centre', 'distribue'=>0, 'stock'=>0],
            ['nom'=>'Neuweg', 'distribue'=>0, 'stock'=>0],
            ['nom'=>'Bourgfelden', 'distribue'=>0, 'stock'=>0]
        ]);
    }
}
