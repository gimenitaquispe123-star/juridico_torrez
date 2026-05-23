<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Usuario;

class RolesYPermisosSeeder extends Seeder
{
    public function run()
    {
        // ============================
        // 1️⃣ Crear roles
        // ============================
        $roles = ['administrador', 'abogado', 'secretario', 'cliente'];
        foreach ($roles as $rol) {
            Role::firstOrCreate(['name' => $rol]);
        }

        // ============================
        // 2️⃣ Crear permisos según tu sistema
        // ============================
        // Administrador
        Permission::firstOrCreate(['name' => 'ver_todo']);
        Permission::firstOrCreate(['name' => 'gestionar_usuarios']);

        // Abogado
        Permission::firstOrCreate(['name' => 'ver_audiencias']);
        Permission::firstOrCreate(['name' => 'gestionar_casos']);
        Permission::firstOrCreate(['name' => 'ver_familiares']);
        Permission::firstOrCreate(['name' => 'ver_divorcios']);

        // Secretario
        Permission::firstOrCreate(['name' => 'gestionar_citas']);
        Permission::firstOrCreate(['name' => 'gestionar_documentos']);

        // Cliente
        Permission::firstOrCreate(['name' => 'ver_procesos']);
        Permission::firstOrCreate(['name' => 'ver_notificaciones']);

        // ============================
        // 3️⃣ Asignar permisos a roles
        // ============================
        Role::findByName('administrador')->givePermissionTo([
            'ver_todo', 
            'gestionar_usuarios', 
            'ver_audiencias',
            'gestionar_casos',
            'ver_familiares',
            'ver_divorcios',
            'gestionar_citas',
            'gestionar_documentos',
            'ver_procesos',
            'ver_notificaciones'
        ]);

        Role::findByName('abogado')->givePermissionTo([
            'ver_audiencias',
            'gestionar_casos',
            'ver_familiares',
            'ver_divorcios'
        ]);

        Role::findByName('secretario')->givePermissionTo([
            'gestionar_citas',
            'gestionar_documentos'
        ]);

        Role::findByName('cliente')->givePermissionTo([
            'ver_procesos',
            'ver_notificaciones'
        ]);

        // ============================
        // 4️⃣ Asignar roles a usuarios existentes
        // ============================
        $usuarios = Usuario::all();

        foreach ($usuarios as $usuario) {
            if($usuario->rol){ // columna rol existente
                $usuario->assignRole($usuario->rol);
            }
        }
    }
}
