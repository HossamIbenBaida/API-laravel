<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
    $admin = Role::factory()->create([
        'name'=>'admin'
    ]);
   $editor =Role::factory()->create([
        'name'=>'editor'
    ]);
    $viewer =  Role::factory()->create([
        'name'=>'viewer'
    ]);
    $permissons = Permission::all();
    $admin->permissions()->attach($permissons->pluck('id'));
    $editor->permissions()->attach($permissons->pluck('id'));
    $editor->permissions()->detach(4);
    $viewer->permissions()->attach([1,3,5,7]);
    }
}
