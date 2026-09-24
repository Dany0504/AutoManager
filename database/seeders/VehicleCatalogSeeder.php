<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleCatalog;

class VehicleCatalogSeeder extends Seeder
{
    public function run(): void
    {
        $cars=[

            ['brand'=>'Honda','model'=>'Accord','year'=>2005,'engine'=>'2.4 K24A4'],
            ['brand'=>'Honda','model'=>'Accord','year'=>2005,'engine'=>'3.0 V6'],
            ['brand'=>'Honda','model'=>'Accord','year'=>2008,'engine'=>'2.4 i-VTEC'],
            ['brand'=>'Honda','model'=>'Civic','year'=>2010,'engine'=>'1.8 R18'],

            ['brand'=>'Chevrolet','model'=>'Malibu','year'=>2010,'engine'=>'2.4 Ecotec'],
            ['brand'=>'Chevrolet','model'=>'Aveo','year'=>2015,'engine'=>'1.6'],
            ['brand'=>'Chevrolet','model'=>'Silverado','year'=>2018,'engine'=>'5.3 V8'],

            ['brand'=>'Toyota','model'=>'Corolla','year'=>2016,'engine'=>'1.8'],
            ['brand'=>'Toyota','model'=>'Camry','year'=>2017,'engine'=>'2.5'],
            ['brand'=>'Toyota','model'=>'Hilux','year'=>2020,'engine'=>'2.8 Diesel'],

            ['brand'=>'Nissan','model'=>'Sentra','year'=>2018,'engine'=>'1.8'],
            ['brand'=>'Nissan','model'=>'Versa','year'=>2020,'engine'=>'1.6'],
            ['brand'=>'Nissan','model'=>'NP300','year'=>2019,'engine'=>'2.5'],

            ['brand'=>'Ford','model'=>'Fusion','year'=>2016,'engine'=>'2.5'],
            ['brand'=>'Ford','model'=>'Explorer','year'=>2015,'engine'=>'3.5 V6'],
            ['brand'=>'Ford','model'=>'F-150','year'=>2019,'engine'=>'5.0 V8'],

            ['brand'=>'Volkswagen','model'=>'Jetta','year'=>2019,'engine'=>'1.4 TSI'],
            ['brand'=>'Volkswagen','model'=>'Vento','year'=>2018,'engine'=>'1.6'],

            ['brand'=>'Mazda','model'=>'Mazda3','year'=>2017,'engine'=>'2.0'],
            ['brand'=>'Mazda','model'=>'CX-5','year'=>2020,'engine'=>'2.5'],

            ['brand'=>'Kia','model'=>'Rio','year'=>2020,'engine'=>'1.6'],
            ['brand'=>'Hyundai','model'=>'Elantra','year'=>2018,'engine'=>'2.0'],

            ['brand'=>'Dodge','model'=>'Charger','year'=>2016,'engine'=>'3.6 Pentastar'],
            ['brand'=>'Chrysler','model'=>'300','year'=>2014,'engine'=>'3.6 Pentastar']

        ];

        foreach($cars as $car){

            VehicleCatalog::create($car);

        }
    }
}