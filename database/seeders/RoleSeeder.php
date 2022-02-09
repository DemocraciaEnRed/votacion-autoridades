<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $role = Role::create(['name' => 'super-admin', 'guard_name' => 'backend']);
        } catch(RoleAlreadyExists $e) {

        }

        try {
            $role = Role::create(['name' => 'org', 'guard_name' => 'backend']);
        } catch(RoleAlreadyExists $e) {

        }

        try {
            $role = Role::create(['name' => 'org 2', 'guard_name' => 'backend']);
        } catch(RoleAlreadyExists $e) {

        }

        try {
            $role = Role::create(['name' => 'auditor', 'guard_name' => 'backend']);
        } catch(RoleAlreadyExists $e) {

        }

//        DB::table('roles')->insert([
//            [
//                'name' => 'super-admin',
//                'guard_name' => 'backend',
//                'created_at' => Carbon::now(),
//                'updated_at' => Carbon::now(),
//            ],
//            [
//                'name' => 'org',
//                'guard_name' => 'backend',
//                'created_at' => Carbon::now(),
//                'updated_at' => Carbon::now(),
//            ],
//            [
//                'name' => 'org 2',
//                'guard_name' => 'backend',
//                'created_at' => Carbon::now(),
//                'updated_at' => Carbon::now(),
//            ],
//            [
//                'name' => 'auditor',
//                'guard_name' => 'backend',
//                'created_at' => Carbon::now(),
//                'updated_at' => Carbon::now(),
//            ],
//        ]);
    }
}
