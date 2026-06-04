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
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin123'),
                'role_id' => 1, 
                'nomor_telepon' => '081234567890',
                'tanggal_lahir' => '1990-01-01',
            ],
            [
                'name' => 'siswa',
                'email' => 'siswa@gmail.com',
                'password' => bcrypt('siswa123'),
                'role_id' => 2,
                'nomor_telepon' => '081234567891',
                'tanggal_lahir' => '2000-01-01',
            ],
            [
                'name' => 'guru',
                'email' => 'guru@gmail.com',
                'password' => bcrypt('guru123'),
                'role_id' => 3,
                'nomor_telepon' => '081234567892',
                'tanggal_lahir' => '1980-01-01',
            ],
            [
                'name' => 'Ahmad Hidayat',
                'email' => 'ahmad@gmail.com',
                'password' => bcrypt('ahmad123'),
                'role_id' => 3,
                'nomor_telepon' => '081234567893',
                'tanggal_lahir' => '1985-01-01',
            ],
            [
                'name' => 'Hilmi Mithwa',
                'email' => 'hilmi@gmail.com',
                'password' => bcrypt('hilmi123'),
                'role_id' => 2,
                'nomor_telepon' => '081222130032',
                'tanggal_lahir' => '2006-10-01'
            ],
            [
                'name' => 'Mizan',
                'email' => 'mizan@gmail.com',
                'password' => bcrypt('hilmi123'),
                'role_id' => 3,
                'nomor_telepon' => '081222130033',
                'tanggal_lahir' => '1995-05-15'
            ],
            [
                'name' => 'Yussar',
                'email' => 'yussar@gmail.com',
                'password' => bcrypt('yussar123'),
                'role_id' => 2,
                'nomor_telepon' => '081222130034',
                'tanggal_lahir' => '2003-08-20'
            ],

            // User testing
            [ 
                'name' => 'User N3N4',
                'email' => 'n3n4@gmail.com',
                'password' => bcrypt('password'),
                'role_id' => 2, // Role Siswa
            ],

            [
                'name' => 'User N4N5',
                'email' => 'n4n5@gmail.com',
                'password' => bcrypt('password'),
                'role_id' => 2, // Role Siswa
            ]

        ];

        foreach ($userData as $user) {
            DB::table('users')->insert([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => $user['password'],
                'role_id' => $user['role_id'],
                'nomor_telepon' => $user['nomor_telepon'] ?? null,
                'tanggal_lahir' => $user['tanggal_lahir'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
    }
}
