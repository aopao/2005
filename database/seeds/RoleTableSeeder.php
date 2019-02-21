<?php

use Illuminate\Database\Seeder;
use \Spatie\Permission\Models\Role;
use \Spatie\Permission\Models\Permission;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = \App\Entities\Admin::find(10);

        $roles = [
            ['name' => 'admin', 'display_name' => '超级管理员', 'guard_name' => 'admin'],
            ['name' => 'editor', 'display_name' => '编辑', 'guard_name' => 'admin'],
        ];
        foreach ($roles as $value) {
            Role::create($value);
        }

        $permissions = [
            ['name' => 'admin.profile', 'display_name' => '当前用户信息', 'guard_name' => 'admin'],
            ['name' => 'admin.admin.index', 'display_name' => '管理员列表', 'guard_name' => 'admin'],
            ['name' => 'admin.admin.store', 'display_name' => '管理员添加', 'guard_name' => 'admin'],
            ['name' => 'admin.admin.show', 'display_name' => '管理员查看', 'guard_name' => 'admin'],
            ['name' => 'admin.admin.update', 'display_name' => '管理员修改', 'guard_name' => 'admin'],
            ['name' => 'admin.admin.destroy', 'display_name' => '管理员删除', 'guard_name' => 'admin'],

            ['name' => 'admin.agent.index', 'display_name' => '代理商列表', 'guard_name' => 'admin'],
            ['name' => 'admin.agent.store', 'display_name' => '代理商添加', 'guard_name' => 'admin'],
            ['name' => 'admin.agent.show', 'display_name' => '代理商查看', 'guard_name' => 'admin'],
            ['name' => 'admin.agent.update', 'display_name' => '代理商修改', 'guard_name' => 'admin'],
            ['name' => 'admin.agent.destroy', 'display_name' => '代理商删除', 'guard_name' => 'admin'],
            ['name' => 'admin.agent.batchProvince', 'display_name' => '处理代理商代理省份', 'guard_name' => 'admin'],
            ['name' => 'admin.agent.getControlProvince', 'display_name' => '获取代理商代理省份', 'guard_name' => 'admin'],

            ['name' => 'admin.college.category.index', 'display_name' => '大学类型列表', 'guard_name' => 'admin'],
            ['name' => 'admin.college.category.store', 'display_name' => '大学类型添加', 'guard_name' => 'admin'],
            ['name' => 'admin.college.category.show', 'display_name' => '大学类型查看', 'guard_name' => 'admin'],
            ['name' => 'admin.college.category.update', 'display_name' => '大学类型修改', 'guard_name' => 'admin'],
            ['name' => 'admin.college.category.destroy', 'display_name' => '大学类型删除', 'guard_name' => 'admin'],

            ['name' => 'admin.college.diplomas.index', 'display_name' => '大学层次列表', 'guard_name' => 'admin'],
            ['name' => 'admin.college.diplomas.store', 'display_name' => '大学层次添加', 'guard_name' => 'admin'],
            ['name' => 'admin.college.diplomas.show', 'display_name' => '大学层次查看', 'guard_name' => 'admin'],
            ['name' => 'admin.college.diplomas.update', 'display_name' => '大学层次修改', 'guard_name' => 'admin'],
            ['name' => 'admin.college.diplomas.destroy', 'display_name' => '大学层次删除', 'guard_name' => 'admin'],

            ['name' => 'admin.college.index', 'display_name' => '大学列表', 'guard_name' => 'admin'],
            ['name' => 'admin.college.store', 'display_name' => '大学添加', 'guard_name' => 'admin'],
            ['name' => 'admin.college.show', 'display_name' => '大学查看', 'guard_name' => 'admin'],
            ['name' => 'admin.college.update', 'display_name' => '大学修改', 'guard_name' => 'admin'],
            ['name' => 'admin.college.destroy', 'display_name' => '大学删除', 'guard_name' => 'admin'],

            ['name' => 'admin.major.levelOptionList', 'display_name' => '专业Option列表', 'guard_name' => 'admin'],
            ['name' => 'admin.major.index', 'display_name' => '专业列表', 'guard_name' => 'admin'],
            ['name' => 'admin.major.store', 'display_name' => '专业添加', 'guard_name' => 'admin'],
            ['name' => 'admin.major.show', 'display_name' => '专业查看', 'guard_name' => 'admin'],
            ['name' => 'admin.major.update', 'display_name' => '专业修改', 'guard_name' => 'admin'],
            ['name' => 'admin.major.destroy', 'display_name' => '专业删除', 'guard_name' => 'admin'],

            ['name' => 'admin.provinceControlScore.index', 'display_name' => '省控线列表', 'guard_name' => 'admin'],
            ['name' => 'admin.provinceControlScore.store', 'display_name' => '省控线添加', 'guard_name' => 'admin'],
            ['name' => 'admin.provinceControlScore.show', 'display_name' => '省控线查看', 'guard_name' => 'admin'],
            ['name' => 'admin.provinceControlScore.update', 'display_name' => '省控线修改', 'guard_name' => 'admin'],
            ['name' => 'admin.provinceControlScore.destroy', 'display_name' => '省控线删除', 'guard_name' => 'admin'],

            ['name' => 'admin.province.optionList', 'display_name' => '省份Option列表', 'guard_name' => 'admin'],
            ['name' => 'admin.province.index', 'display_name' => '省份列表', 'guard_name' => 'admin'],
            ['name' => 'admin.province.store', 'display_name' => '省份添加', 'guard_name' => 'admin'],
            ['name' => 'admin.province.show', 'display_name' => '省份查看', 'guard_name' => 'admin'],
            ['name' => 'admin.province.update', 'display_name' => '省份修改', 'guard_name' => 'admin'],
            ['name' => 'admin.province.destroy', 'display_name' => '省份删除', 'guard_name' => 'admin'],

            ['name' => 'admin.vipCard.optionList', 'display_name' => 'VIP服务卡Option列表', 'guard_name' => 'admin'],
            ['name' => 'admin.vipCard.index', 'display_name' => 'VIP服务卡列表', 'guard_name' => 'admin'],
            ['name' => 'admin.vipCard.store', 'display_name' => 'VIP服务卡添加', 'guard_name' => 'admin'],
            ['name' => 'admin.vipCard.show', 'display_name' => 'VIP服务卡查看', 'guard_name' => 'admin'],
            ['name' => 'admin.vipCard.update', 'display_name' => 'VIP服务卡修改', 'guard_name' => 'admin'],
            ['name' => 'admin.vipCard.destroy', 'display_name' => 'VIP服务卡删除', 'guard_name' => 'admin'],

            ['name' => 'admin.serialNumber.index', 'display_name' => '序列号列表', 'guard_name' => 'admin'],
            ['name' => 'admin.serialNumber.store', 'display_name' => '序列号添加', 'guard_name' => 'admin'],
            ['name' => 'admin.serialNumber.show', 'display_name' => '序列号查看', 'guard_name' => 'admin'],
            ['name' => 'admin.serialNumber.update', 'display_name' => '序列号修改', 'guard_name' => 'admin'],
            ['name' => 'admin.serialNumber.destroy', 'display_name' => '序列号删除', 'guard_name' => 'admin'],

            ['name' => 'admin.role.index', 'display_name' => '角色列表', 'guard_name' => 'admin'],
            ['name' => 'admin.role.store', 'display_name' => '角色添加', 'guard_name' => 'admin'],
            ['name' => 'admin.role.show', 'display_name' => '角色查看', 'guard_name' => 'admin'],
            ['name' => 'admin.role.update', 'display_name' => '角色修改', 'guard_name' => 'admin'],
            ['name' => 'admin.role.destroy', 'display_name' => '角色删除', 'guard_name' => 'admin'],

            ['name' => 'admin.permission.index', 'display_name' => '权限列表', 'guard_name' => 'admin'],
            ['name' => 'admin.permission.store', 'display_name' => '权限添加', 'guard_name' => 'admin'],
            ['name' => 'admin.permission.show', 'display_name' => '权限查看', 'guard_name' => 'admin'],
            ['name' => 'admin.permission.update', 'display_name' => '权限修改', 'guard_name' => 'admin'],
            ['name' => 'admin.permission.destroy', 'display_name' => '权限删除', 'guard_name' => 'admin'],

        ];

        foreach ($permissions as $value) {
            $permission = Permission::create($value);
            $role = Role::find(1);
            $role->givePermissionTo($permission);
            $admin->assignRole('admin');
        }
    }
}
