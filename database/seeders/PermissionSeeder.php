<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'listar administradores', 'guard_name' => 'backend']);
        Permission::create(['name' => 'crear administrador', 'guard_name' => 'backend']);
        Permission::create(['name' => 'guardar administrador', 'guard_name' => 'backend']);
        Permission::create(['name' => 'ver administrador', 'guard_name' => 'backend']);
        Permission::create(['name' => 'editar administrador', 'guard_name' => 'backend']);
        Permission::create(['name' => 'eliminar administrador', 'guard_name' => 'backend']);
        Permission::create(['name' => 'cambiar status administrador', 'guard_name' => 'backend']);

        Permission::create(['name' => 'ver home', 'guard_name' => 'backend']);
        Permission::create(['name' => 'editar home', 'guard_name' => 'backend']);

        Permission::create(['name' => 'listar usuarios', 'guard_name' => 'backend']);
        Permission::create(['name' => 'crear usuario', 'guard_name' => 'backend']);
        Permission::create(['name' => 'guardar usuario', 'guard_name' => 'backend']);
        Permission::create(['name' => 'ver usuario', 'guard_name' => 'backend']);
        Permission::create(['name' => 'editar usuario', 'guard_name' => 'backend']);
        Permission::create(['name' => 'eliminar usuario', 'guard_name' => 'backend']);
        Permission::create(['name' => 'ver validar usuario', 'guard_name' => 'backend']);
        Permission::create(['name' => 'validar usuario', 'guard_name' => 'backend']);
        Permission::create(['name' => 'validar todos los usuarios', 'guard_name' => 'backend']);
        Permission::create(['name' => 'exportar usuarios', 'guard_name' => 'backend']);

        Permission::create(['name' => 'listar padrones', 'guard_name' => 'backend']);
        Permission::create(['name' => 'crear padron', 'guard_name' => 'backend']);
        Permission::create(['name' => 'guardar padron', 'guard_name' => 'backend']);
        Permission::create(['name' => 'ver padron', 'guard_name' => 'backend']);
        Permission::create(['name' => 'editar padron', 'guard_name' => 'backend']);
        Permission::create(['name' => 'eliminar padron', 'guard_name' => 'backend']);
        Permission::create(['name' => 'ver importar padrones', 'guard_name' => 'backend']);
        Permission::create(['name' => 'importar padrones', 'guard_name' => 'backend']);
        Permission::create(['name' => 'ver exportar padrones', 'guard_name' => 'backend']);
        Permission::create(['name' => 'exportar padrones', 'guard_name' => 'backend']);

        Permission::create(['name' => 'ver logs padrones', 'guard_name' => 'backend']);

        Permission::create(['name' => 'listar bloques', 'guard_name' => 'backend']);
        Permission::create(['name' => 'crear bloque', 'guard_name' => 'backend']);
        Permission::create(['name' => 'guardar bloque', 'guard_name' => 'backend']);
        Permission::create(['name' => 'ver bloque', 'guard_name' => 'backend']);
        Permission::create(['name' => 'editar bloque', 'guard_name' => 'backend']);
        Permission::create(['name' => 'eliminar bloque', 'guard_name' => 'backend']);

        Permission::create(['name' => 'listar posiciones', 'guard_name' => 'backend']);
        Permission::create(['name' => 'crear posicion', 'guard_name' => 'backend']);
        Permission::create(['name' => 'guardar posicion', 'guard_name' => 'backend']);
        Permission::create(['name' => 'ver posicion', 'guard_name' => 'backend']);
        Permission::create(['name' => 'editar posicion', 'guard_name' => 'backend']);
        Permission::create(['name' => 'eliminar posicion', 'guard_name' => 'backend']);

        Permission::create(['name' => 'listar planchas', 'guard_name' => 'backend']);
        Permission::create(['name' => 'crear plancha', 'guard_name' => 'backend']);
        Permission::create(['name' => 'guardar plancha', 'guard_name' => 'backend']);
        Permission::create(['name' => 'ver plancha', 'guard_name' => 'backend']);
        Permission::create(['name' => 'editar plancha', 'guard_name' => 'backend']);
        Permission::create(['name' => 'eliminar plancha', 'guard_name' => 'backend']);

        Permission::create(['name' => 'listar candidatos', 'guard_name' => 'backend']);
        Permission::create(['name' => 'crear candidato', 'guard_name' => 'backend']);
        Permission::create(['name' => 'guardar candidato', 'guard_name' => 'backend']);
        Permission::create(['name' => 'ver candidato', 'guard_name' => 'backend']);
        Permission::create(['name' => 'editar candidato', 'guard_name' => 'backend']);
        Permission::create(['name' => 'eliminar candidato', 'guard_name' => 'backend']);

        Permission::create(['name' => 'listar roles', 'guard_name' => 'backend']);
        Permission::create(['name' => 'crear rol', 'guard_name' => 'backend']);
        Permission::create(['name' => 'guardar rol', 'guard_name' => 'backend']);
        Permission::create(['name' => 'ver rol', 'guard_name' => 'backend']);
        Permission::create(['name' => 'editar rol', 'guard_name' => 'backend']);
        Permission::create(['name' => 'eliminar rol', 'guard_name' => 'backend']);
        Permission::create(['name' => 'ver permisos rol', 'guard_name' => 'backend']);
        Permission::create(['name' => 'editar permisos rol', 'guard_name' => 'backend']);

        Permission::create(['name' => 'ver estado de votacion', 'guard_name' => 'backend']);
        Permission::create(['name' => 'editar estado de votacion', 'guard_name' => 'backend']);

        Permission::create(['name' => 'ver resultados', 'guard_name' => 'backend']);
        Permission::create(['name' => 'exportar resultados', 'guard_name' => 'backend']);
        Permission::create(['name' => 'cargar resultados manuales', 'guard_name' => 'backend']);

        Permission::create(['name' => 'exportar personas no censadas', 'guard_name' => 'backend']);

        Permission::create(['name' => 'ver designaciones', 'guard_name' => 'backend']);
        Permission::create(['name' => 'editar designaciones', 'guard_name' => 'backend']);
    }
}
