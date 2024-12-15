<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleHasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = Role::findOrFail(1);
        for ($x = 0; $x <= 171; $x++) {
            $data->givePermissionTo($x);
        }
    }
}
