<?php

use Database\Seeders\StakeholderTypeSeeder;
use Database\Seeders\GenderSeeder;
use Database\Seeders\GroupSeeder;
use Database\Seeders\StatusSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\RegionSeeder;
use Database\Seeders\CountrySeeder;
use Database\Seeders\StateSeeder;
use Database\Seeders\CitySeeder;
use Database\Seeders\CompanySeeder;
use Database\Seeders\DivisionSeeder;
use Database\Seeders\SubsidiarySeeder;
use Database\Seeders\ProjectSeeder;
use Database\Seeders\ParameterSeeder;
use Database\Seeders\SectorSeeder;
use Database\Seeders\FunctionSeeder;
use Database\Seeders\EquipmentSeeder;
use Database\Seeders\ZoneSeeder;
use Database\Seeders\LocationSeeder;
use Database\Seeders\TurnSeeder;
use Database\Seeders\StakeholderSeeder;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\PositionSeeder;
use Database\Seeders\LocationTurnSeeder;
use Database\Seeders\PersonSeeder;
use Database\Seeders\StakeholderPersonSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\ProjectUserSeeder;
use Database\Seeders\LocationProjectUserSeeder;
use Database\Seeders\WarehouseSeeder;
use Database\Seeders\MenuSeeder;
use Database\Seeders\MenuRoleSeeder;
use Database\Seeders\PermitSeeder;
use Database\Seeders\RolePermitSeeder;
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
        $this->call([
            StakeholderTypeSeeder::class,
            GenderSeeder::class,
            GroupSeeder::class,
            StatusSeeder::class,
            RoleSeeder::class,
            RegionSeeder::class,
            CountrySeeder::class,
            StateSeeder::class,
            CitySeeder::class,
            CompanySeeder::class,
            DivisionSeeder::class,
            SubsidiarySeeder::class,
            ProjectSeeder::class,
            ParameterSeeder::class,
            SectorSeeder::class,
            FunctionSeeder::class,
            EquipmentSeeder::class,
            ZoneSeeder::class,
            LocationSeeder::class,
            TurnSeeder::class,
            StakeholderSeeder::class,
            DepartmentSeeder::class,
            PositionSeeder::class,
            LocationTurnSeeder::class,
            PersonSeeder::class,
            StakeholderPersonSeeder::class,
            UserSeeder::class,
            ProjectUserSeeder::class,
            LocationProjectUserSeeder::class,
            WarehouseSeeder::class,
            // DefaultSeeder::class,
            MenuSeeder::class,
            MenuRoleSeeder::class,
            PermitSeeder::class,
            RolePermitSeeder::class,
            
        ]);

        
    }
}
