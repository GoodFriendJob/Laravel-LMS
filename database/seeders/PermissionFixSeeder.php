<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Auth\Role;


class PermissionFixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [47];
        $role = Role::where('name','=','student')->first();
        $role->syncPermissions($permissions);
    }
}
