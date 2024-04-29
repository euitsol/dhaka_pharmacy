<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AdminSeeder::class,
            PermissionSeeder::class,
            RoleHasPermissionSeeder::class,
            PharmacySeeder::class,
            DocumentationSeeder::class,
            SettingsSeeder::class,
            EmailTemplateSeeder::class,
            DistrictManagerSeeder::class,
            LocalAreaManagerSeeder::class,
            MedicineCategorySeeder::class,
            MedicineCompanySeeder::class,
            MedicineGenericSeeder::class,
            MedicineStrengthSeeder::class,
            MedicineUnitSeeder::class,
            ProductCategorySeeder::class,
            ProductSubCategorySeeder::class,
            MedicineSeeder::class,
            PushNtSeeder::class,
            PushNotificationSeeder::class,
            SslCommerzSeeder::class,
            AddressSeeder::class,
        ]);
    }
}
