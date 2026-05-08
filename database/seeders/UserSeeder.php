<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            //[
            //    'name' => 'admin',
            //    'email' => 'admin@gmail.com',
            //    'password' => bcrypt('admin123'),
            //    'role_id' => 1, 
            //],
            //[
            //    'name' => 'siswa',
            //    'email' => 'siswa@gmail.com',
            //    'password' => bcrypt('siswa123'),
            //    'role_id' => 2,
            //],
            //[
            //    'name' => 'guru',
            //    'email' => 'guru@gmail.com',
            //    'password' => bcrypt('guru123'),
            //    'role_id' => 3
            //],
            //[
            //    'name' => 'Ahmad Hidayat',
            //    'email' => 'ahmad@gmail.com',
            //    'password' => bcrypt('ahmad123'),
            //    'role_id' => 3
            //],
            //[
            //    'name' => 'Hilmi Mithwa',
            //    'email' => 'hilmi@gmail.com',
            //    'password' => bcrypt('hilmi123'),
            //    'role_id' => 2
            //],
            //[
            //    'name' => 'Mizan',
            //    'email' => 'mizan@gmail.com',
            //    'password' => bcrypt('hilmi123'),
            //    'role_id' => 3
            //],
            [
                'name' => 'Yussar',
                'email' => 'yussar@gmail.com',
                'password' => bcrypt('yussar123'),
                'role_id' => 2
            ],
            
        ];

        foreach ($userData as $user) {
            DB::table('users')->insert([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => $user['password'],
                'role_id' => $user['role_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
    }
}
