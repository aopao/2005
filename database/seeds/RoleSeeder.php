<?php

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
        $admin = \App\Entities\Admin::find(10);

        $data = ['name' => 'provinceControlScore.add', 'display_name' => '省控线查看', 'guard_name' => 'admin'];
        $permission = \Spatie\Permission\Models\Permission::create($data);
        $role = \Spatie\Permission\Models\Role::find(2);
        $role->givePermissionTo($permission);
        $admin->assignRole('admin');
    }
}
