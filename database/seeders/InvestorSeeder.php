<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;
use Botble\RealEstate\Models\Investor;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class InvestorSeeder extends BaseSeeder
{
    public function run()
    {
        $faker = Factory::create('en_US');

        Investor::truncate();
        DB::table('re_investors_translations')->truncate();

        $files = $this->uploadFiles('investors');
        for ($i = 1; $i < 6; $i++) {
            $item = [
                'name' => $faker->company,
                'description' => $faker->realText(200),
                'avatar_id' => $files[$i - 1]['data']->id,
            ];
            Investor::create($item);

            $item['lang_code'] = 'vi';
            $item['re_investors_id'] = $i;
            unset($item['avatar_id']);
            DB::table('re_investors_translations')->insert($item);
        }
    }
}
