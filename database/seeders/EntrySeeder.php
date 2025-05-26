<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class EntrySeeder extends Seeder
{
    public function run()
    {
        // Roles create karo
        $tier1 = Role::create(['name' => 'Tier1']);
        $userRole = Role::create(['name' => 'Tier2']);
        $userRole = Role::create(['name' => 'Tier3']);
        $userRole = Role::create(['name' => 'Tier4']);


        // Permissions create karo
        $permission1 = Permission::create(['name' => 'edit articles']);
        $permission2 = Permission::create(['name' => 'delete articles']);

        // Admin ko permissions assign karo
        $tier1->givePermissionTo($permission1);
        $tier1->givePermissionTo($permission2);
    }
}
