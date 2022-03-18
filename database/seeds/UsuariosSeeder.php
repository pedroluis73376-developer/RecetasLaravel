<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::create([
            'name' => 'Pedro',
            'email' => 'pedro@outlook.com',
            'url' => 'https:www.google.com',
            'password' => Hash::make('12345678'),

        ]);
        $user->perfil()->create();

        $user2 = User::create([
            'name' => 'luis',
            'email' => 'luis@outlook.com',
            'url' => 'https:www.google.com',
            'password' => Hash::make('12345678'),

        ]);
        $user2->perfil()->create();
    }
}
