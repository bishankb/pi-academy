<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SinglePermissionTableSeeder extends Seeder
{
   /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::firstOrCreate(['name' => 'view_confidentials']);
        Permission::firstOrCreate(['name' => 'view_export_datas']);
        Permission::firstOrCreate(['name' => 'edit_online_examination_credentials']);
        Permission::firstOrCreate(['name' => 'view_staff_attendences']);
        Permission::firstOrCreate(['name' => 'view_examination_results']);
        Permission::firstOrCreate(['name' => 'view_teacher_routines']);
        Permission::firstOrCreate(['name' => 'send_push_notifications']);

        $role = Role::findByName('admin')->first();
        $role->givePermissionTo('view_confidentials');
        $role->givePermissionTo('view_export_datas');
        $role->givePermissionTo('edit_online_examination_credentials');
        $role->givePermissionTo('view_staff_attendences');
        $role->givePermissionTo('view_examination_results');
        $role->givePermissionTo('view_teacher_routines');
        $role->givePermissionTo('send_push_notifications');
    }
}
