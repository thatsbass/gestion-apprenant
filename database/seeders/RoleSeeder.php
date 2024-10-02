<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::create(['libelle' => 'Admin']);
        Role::create(['libelle' => 'Manager']);
        Role::create(['libelle' => 'Coach']);
        Role::create(['libelle' => 'CME']);
        Role::create(['libelle' => 'Apprenant']);
        Role::create(['libelle' => 'Vigile']);
    }
}
