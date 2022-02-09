<?php

namespace Tests\Feature\App;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class PermissionTest extends TestCase
{

    public function testCreatePermission()
    {
        Permission::create(['name' => 'listar administradores', 'guard_name' => 'backend']);

        $this->assertTrue(true);
    }
}
