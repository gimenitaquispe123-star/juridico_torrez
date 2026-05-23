<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario; 
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
       
        $role = Role::firstOrCreate(['name' => 'administrador']);

        $user = Usuario::firstOrCreate(
            ['email' => 'admin@tusistema.com'],
            [
                'usuario' => 'admin',
                'password' => Hash::make('admin123'),
                'rol' => 'administrador',
                'estado' => 1
            ]
        );

      if (!$user->hasRole('administrador')) {
            $user->assignRole($role);
        }
    }
}
