<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;

class AsignarRolesUsuariosSeeder extends Seeder
{
    public function run()
    {
        $usuarios = Usuario::all();

        foreach ($usuarios as $usuario) {
            if($usuario->rol){
                $usuario->assignRole($usuario->rol);
            }
        }
    }
}
