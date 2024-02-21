<?php

namespace Database\Seeders;

use Botble\Base\Supports\BaseSeeder;

class DatabaseSeeder extends BaseSeeder
{
    public function run(): void
    {
        $this->prepareRun();

        $this->call(LanguageSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(BlockSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(ThemeOptionSeeder::class);
        $this->call(BlogSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(AccountSeeder::class);
        $this->call(PackageSeeder::class);
        $this->call(FacilitySeeder::class);
        $this->call(PropertyCategorySeeder::class);
        $this->call(PropertyFeatureSeeder::class);
        $this->call(PropertyTypeSeeder::class);
        $this->call(PropertySeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(WidgetSeeder::class);
        $this->call(TestimonialSeeder::class);
        $this->call(InvestorSeeder::class);
        $this->call(ProjectSeeder::class);

        $this->finished();
    }
}
