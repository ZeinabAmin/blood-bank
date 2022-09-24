<?php
 namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
/**
* Run the database seeds.
*
* @return void
*/
public function run()
{



$permissions = [
'users_list',
'users-create',
'users-edit',
'users-delete',
'categories-lists',
'categories-create',
'categories-edit',
'categories-delete'
];
foreach ($permissions as $permission) {
Permission::create(['name' => $permission,'guard_name' =>'web','display_name' => $permission]);


}

}
}
