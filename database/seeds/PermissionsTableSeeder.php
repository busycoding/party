<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Role;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->truncate();

        // crud company
        $crudCompany = new Permission();
        $crudCompany->name = "crud-company";
        $crudCompany->save();

        // update others company
        $updateOthersCompany = new Permission();
        $updateOthersCompany->name = "update-others-company";
        $updateOthersCompany->save();

        // delete others company
        $deleteOthersCompany = new Permission();
        $deleteOthersCompany->name = "delete-others-company";
        $deleteOthersCompany->save();

        // crud category
        $crudCategory = new Permission();
        $crudCategory->name = "crud-category";
        $crudCategory->save();

        // crud user
        $crudUser = new Permission();
        $crudUser->name = "crud-user";
        $crudUser->save();

        // attach roles permissions
        $admin = Role::whereName('admin')->first();
        $editor = Role::whereName('editor')->first();
        $author = Role::whereName('author')->first();

        $admin->detachPermissions([$crudCompany, $updateOthersCompany, $deleteOthersCompany, $crudCategory, $crudUser]);
        $admin->attachPermissions([$crudCompany, $updateOthersCompany, $deleteOthersCompany, $crudCategory, $crudUser]);

        $editor->detachPermissions([$crudCompany, $updateOthersCompany, $deleteOthersCompany, $crudCategory]);
        $editor->attachPermissions([$crudCompany, $updateOthersCompany, $deleteOthersCompany, $crudCategory]);

        $author->detachPermission($crudCompany);
        $author->attachPermission($crudCompany);
    }
}
