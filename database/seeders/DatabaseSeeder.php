<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(CountrySeeder::class); 
        $this->call(CurrencySeeder::class); 
        $this->call(PrinterSeeder::class);
        $this->call(StoreSeeder::class); 
        $this->call(TaxrateSeeder::class);   
        $this->call(CustomerSeeder::class);
        $this->call(SettingsHrmSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(PermissionSeeder2::class);
        $this->call(PermissionSeeder3::class);
        $this->call(PermissionSeeder4::class);
        $this->call(RoleHasPermissionSeeder::class);
    }
}
