<?php

namespace Database\Seeders\Auth;

use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * Class PermissionRoleTableSeeder.
 */
class PermissionRoleTableSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();

        // Create Roles
        $admin = Role::create(['name' => config('access.users.admin_role')]);
        $teacher = Role::create(['name' => 'teacher']);
        $student = Role::create(['name' => 'student']);
        $user = Role::create(['name' => 'user']);


        $permissions = [

            ['id' => 1, 'name' => 'user_management_access',],
            ['id' => 2, 'name' => 'user_management_create',],
            ['id' => 3, 'name' => 'user_management_edit',],
            ['id' => 4, 'name' => 'user_management_view',],
            ['id' => 5, 'name' => 'user_management_delete',],

            ['id' => 6, 'name' => 'permission_access',],
            ['id' => 7, 'name' => 'permission_create',],
            ['id' => 8, 'name' => 'permission_edit',],
            ['id' => 9, 'name' => 'permission_view',],
            ['id' => 10, 'name' => 'permission_delete',],

            ['id' => 11, 'name' => 'role_access',],
            ['id' => 12, 'name' => 'role_create',],
            ['id' => 13, 'name' => 'role_edit',],
            ['id' => 14, 'name' => 'role_view',],
            ['id' => 15, 'name' => 'role_delete',],

            ['id' => 16, 'name' => 'user_access',],
            ['id' => 17, 'name' => 'user_create',],
            ['id' => 18, 'name' => 'user_edit',],
            ['id' => 19, 'name' => 'user_view',],
            ['id' => 20, 'name' => 'user_delete',],

            ['id' => 21, 'name' => 'course_access',],
            ['id' => 22, 'name' => 'course_create',],
            ['id' => 23, 'name' => 'course_edit',],
            ['id' => 24, 'name' => 'course_view',],
            ['id' => 25, 'name' => 'course_delete',],

            ['id' => 26, 'name' => 'lesson_access',],
            ['id' => 27, 'name' => 'lesson_create',],
            ['id' => 28, 'name' => 'lesson_edit',],
            ['id' => 29, 'name' => 'lesson_view',],
            ['id' => 30, 'name' => 'lesson_delete',],

            ['id' => 31, 'name' => 'question_access',],
            ['id' => 32, 'name' => 'question_create',],
            ['id' => 33, 'name' => 'question_edit',],
            ['id' => 34, 'name' => 'question_view',],
            ['id' => 35, 'name' => 'question_delete',],

            ['id' => 36, 'name' => 'questions_option_access',],
            ['id' => 37, 'name' => 'questions_option_create',],
            ['id' => 38, 'name' => 'questions_option_edit',],
            ['id' => 39, 'name' => 'questions_option_view',],
            ['id' => 40, 'name' => 'questions_option_delete',],

            ['id' => 41, 'name' => 'test_access',],
            ['id' => 42, 'name' => 'test_create',],
            ['id' => 43, 'name' => 'test_edit',],
            ['id' => 44, 'name' => 'test_view',],
            ['id' => 45, 'name' => 'test_delete',],

            ['id' => 46, 'name' => 'order_access',],

            ['id' => 47, 'name' => 'view backend',],

            ['id' => 48, 'name' => 'category_access',],
            ['id' => 49, 'name' => 'category_create',],
            ['id' => 50, 'name' => 'category_edit',],
            ['id' => 51, 'name' => 'category_view',],
            ['id' => 52, 'name' => 'category_delete',],

            ['id' => 53, 'name' => 'blog_access',],
            ['id' => 54, 'name' => 'blog_create',],
            ['id' => 55, 'name' => 'blog_edit',],
            ['id' => 56, 'name' => 'blog_view',],
            ['id' => 57, 'name' => 'blog_delete',],

            ['id' => 58, 'name' => 'reason_access',],
            ['id' => 59, 'name' => 'reason_create',],
            ['id' => 60, 'name' => 'reason_edit',],
            ['id' => 61, 'name' => 'reason_view',],
            ['id' => 62, 'name' => 'reason_delete',],

            ['id' => 63, 'name' => 'page_access',],
            ['id' => 64, 'name' => 'page_create',],
            ['id' => 65, 'name' => 'page_edit',],
            ['id' => 66, 'name' => 'page_view',],
            ['id' => 67, 'name' => 'page_delete',],

            ['id' => 68, 'name' => 'bundle_access',],
            ['id' => 69, 'name' => 'bundle_create',],
            ['id' => 70, 'name' => 'bundle_edit',],
            ['id' => 71, 'name' => 'bundle_view',],
            ['id' => 72, 'name' => 'bundle_delete',],

            ['id' => 73, 'name' => 'live_lesson_access'],
            ['id' => 74, 'name' => 'live_lesson_create'],
            ['id' => 75, 'name' => 'live_lesson_edit'],
            ['id' => 76, 'name' => 'live_lesson_view'],
            ['id' => 77, 'name' => 'live_lesson_delete'],

            ['id' => 78, 'name' => 'live_lesson_slot_access'],
            ['id' => 79, 'name' => 'live_lesson_slot_create'],
            ['id' => 80, 'name' => 'live_lesson_slot_edit'],
            ['id' => 81, 'name' => 'live_lesson_slot_view'],
            ['id' => 82, 'name' => 'live_lesson_slot_delete'],

            ['id' => 83, 'name' => 'stripe_plan_access'],
            ['id' => 84, 'name' => 'stripe_plan_create'],
            ['id' => 85, 'name' => 'stripe_plan_edit'],
            ['id' => 86, 'name' => 'stripe_plan_view'],
            ['id' => 87, 'name' => 'stripe_plan_delete'],
            ['id' => 88, 'name' => 'stripe_plan_restore'],
        ];

        foreach ($permissions as $item) {
            Permission::create($item);
        }

//        $admin_permissions = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67];

        $teacher_permissions = [1, 21, 22, 23, 24,25, 26, 27, 28, 29,30, 31, 32, 33, 34,35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 47, 48, 49, 51, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82];

        $student_permission = [47];


        $admin->syncPermissions(Permission::all());
        $teacher->syncPermissions($teacher_permissions);
        $student->syncPermissions($student_permission);

        $this->enableForeignKeys();
    }
}
