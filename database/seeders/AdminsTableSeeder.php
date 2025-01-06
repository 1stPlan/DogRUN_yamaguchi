<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $table = 'admins';

    public function run()
    {
        DB::statement('TRUNCATE TABLE '.$this->table.';');
        DB::statement('ALTER TABLE '.$this->table.' AUTO_INCREMENT = 1;');

        DB::table('admins')->insert([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10),
        ]);
    }
}
