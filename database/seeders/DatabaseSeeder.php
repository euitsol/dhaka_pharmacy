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
            SettingsSeeder::class,
            EmailTemplateSeeder::class,
            OperationalAreaSeeder::class,
            DistrictManagerSeeder::class,
            LocalAreaManagerSeeder::class,
            RiderSeeder::class,
            MedicineCategorySeeder::class,
            MedicineCompanySeeder::class,
            MedicineGenericSeeder::class,
            MedicineStrengthSeeder::class,
            MedicineUnitSeeder::class,
            ProductCategorySeeder::class,
            ProductSubCategorySeeder::class,
            // MedicineSeeder::class,
            // MedicineUnitBkdnSeeder::class,
            PushNtSeeder::class,
            PushNotificationSeeder::class,
            SslCommerzSeeder::class,
            AddressSeeder::class,
            PointSettingSeeder::class,
            MapboxSettingsSeeder::class,
            DocumentationSeeder::class,
        ]);
    }
}