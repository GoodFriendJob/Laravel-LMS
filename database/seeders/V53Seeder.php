<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class V53Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'stripe_plan_access',
            'stripe_plan_create',
            'stripe_plan_edit',
            'stripe_plan_view',
            'stripe_plan_delete',
            'stripe_plan_restore',
        ];

        foreach ($permissions as $item) {
            Permission::findOrCreate($item);
        }
        Artisan::call('cache:clear');

        $admin = Role::findByName('administrator');
        $admin->givePermissionTo($permissions);
    }
}
