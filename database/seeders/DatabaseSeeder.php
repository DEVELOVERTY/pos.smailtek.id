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
        // Core System Seeders
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(PermissionSeeder2::class);
        $this->call(PermissionSeeder3::class);
        $this->call(PermissionSeeder4::class);
        $this->call(RoleHasPermissionSeeder::class);
        
        // Master Data Seeders
        $this->call(CountrySeeder::class); 
        $this->call(CurrencySeeder::class); 
        $this->call(PrinterSeeder::class);
        $this->call(BankSeeder::class);
        $this->call(PaymentMethodSeeder::class);
        
        // Settings Seeders
        $this->call(SettingSeeder::class);
        $this->call(SettingsHrmSeeder::class);
        
        // Store & User Seeders
        $this->call(StoreSeeder::class); 
        $this->call(StoreTokenSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CustomerSeeder::class);
        
        // Product Related Seeders
        $this->call(TaxrateSeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(BoxSeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(SupplierSeeder::class);
        $this->call(ProductSeeder::class);
        
        // HRM Seeders
        $this->call(DepartmentSeeder::class);
        $this->call(DesignationSeeder::class);
    }
}
