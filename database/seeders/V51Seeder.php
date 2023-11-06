<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class V51Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'live_lesson_access',
            'live_lesson_create',
            'live_lesson_edit',
            'live_lesson_view',
            'live_lesson_delete',
            'live_lesson_slot_access',
            'live_lesson_slot_create',
            'live_lesson_slot_edit',
            'live_lesson_slot_view',
            'live_lesson_slot_delete'
        ];

        foreach ($permissions as $item) {
            Permission::findOrCreate($item);
        }
        Artisan::call('cache:clear');

        $admin = Role::findByName('administrator');
        $admin->givePermissionTo($permissions);
        $teacher =Role::findByName('teacher');
        $teacher->givePermissionTo($permissions);
    }
}
