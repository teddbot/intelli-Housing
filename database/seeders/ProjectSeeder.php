<?php

namespace Database\Seeders;

use Botble\Base\Models\MetaBox as MetaBoxModel;
use Botble\Base\Supports\BaseSeeder;
use Botble\Language\Models\LanguageMeta;
use Botble\RealEstate\Models\Account;
use Botble\RealEstate\Models\Project;
use Botble\RealEstate\Models\Property;
use Botble\Slug\Models\Slug;
use Faker\Factory;
use Faker\Provider\en_US\Address;
use Html;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use MetaBox;
use RvMedia;
use SlugHelper;

class ProjectSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $files = $this->uploadFiles('projects');

        Project::truncate();
        DB::table('re_projects_translations')->truncate();
        Slug::where('reference_type', Project::class)->delete();
        MetaBoxModel::where('reference_type', Project::class)->delete();
        LanguageMeta::where('reference_type', Project::class)->delete();

        $faker = Factory::create('en_US');
        $faker->addProvider(new Address($faker));
        $properties = Property::get();
        $projects = [
            [
                'name' => 'Villa Alaya',
                'coordinates' => [
                    'lat' => 38.1343013,
                    'lng' => -85.6498512,
                ],
            ],
            [
                'name' => 'Ani Private Resorts',
                'coordinates' => [
                    'lat' => 38.263793,
                    'lng' => -85.700243,
                ],
            ],
            [
                'name' => 'Casa Tres Soles',
                'coordinates' => [
                    'lat' => 38.142768,
                    'lng' => -85.7717132,
                ],
            ],
            [
                'name' => 'La Bergerie',
                'coordinates' => [
                    'lat' => 44.771005,
                    'lng' => -72.048664,
                ],
            ],
            [
                'name' => 'Hollywood Mansion',
                'coordinates' => [
                    'lat' => 38.1286407,
                    'lng' => -85.8678042,
                ],
            ],
            [
                'name' => 'Crystal Springs',
                'coordinates' => [
                    'lat' => 38.867033,
                    'lng' => -76.979235,
                ],
            ],
            [
                'name' => 'Calivigny Island',
                'coordinates' => [
                    'lat' => 38.9582381,
                    'lng' => -77.0244287,
                ],
            ],
            [
                'name' => 'Marbella Luxury Villa',
                'coordinates' => [
                    'lat' => 38.9256252,
                    'lng' => -77.0982646,
                ],
            ],
            [
                'name' => 'Aspect Doncaster',
                'coordinates' => [
                    'lat' => 38.887255,
                    'lng' => -76.98318499999999,
                ],
            ],
        ];

        foreach ($projects as $index => $item) {
            $item['content'] =
                ($index % 3 == 0 ? Html::tag(
                    'p',
                    '[youtube-video]https://www.youtube.com/watch?v=U05fwua9-D4[/youtube-video]'
                ) : '') .
                Html::tag('p', $faker->realText(1000)) .
                Html::tag(
                    'p',
                    Html::image(RvMedia::getImageUrl(
                        'projects/' . $faker->numberBetween(1, 6) . '.jpg'
                    ))
                        ->toHtml(),
                    ['class' => 'text-center']
                ) .
                Html::tag('p', $faker->realText(500)) .
                Html::tag(
                    'p',
                    Html::image(RvMedia::getImageUrl(
                        'projects/' . $faker->numberBetween(7, 12) . '.jpg'
                    ))
                        ->toHtml(),
                    ['class' => 'text-center']
                ) .
                Html::tag('p', $faker->realText(1000)) .
                Html::tag(
                    'p',
                    Html::image(RvMedia::getImageUrl(
                        'projects/' . $faker->numberBetween(13, 20) . '.jpg'
                    ))
                        ->toHtml(),
                    ['class' => 'text-center']
                ) .
                Html::tag('p', $faker->realText(1000));

            $item['description'] = $faker->text(200);
            $item['location'] = $faker->address;
            $item['author_id'] = Account::inRandomOrder()->value('id');
            $item['author_type'] = Account::class;
            $item['price_from'] = $faker->numberBetween(500, 20000);
            $item['price_to'] = $faker->numberBetween(25000, 100000);
            $item['number_block'] = $faker->numberBetween(2, 6);
            $item['number_floor'] = $faker->numberBetween(2, 6);
            $item['number_flat'] = $faker->numberBetween(100, 200);
            $item['views'] = $faker->numberBetween(1000, 10000);
            $item['city_id'] = $faker->numberBetween(1, 6);
            $item['investor_id'] = $faker->numberBetween(1, 5);
            $item['latitude'] = isset($item['coordinates']) ? $item['coordinates']['lat'] : $faker->latitude;
            $item['longitude'] = isset($item['coordinates']) ? $item['coordinates']['lng'] : $faker->longitude;
            unset($item['coordinates']);
            $images = [];
            for ($i = 0; $i < 6; $i++) {
                $images[] = 'projects/' . $faker->numberBetween(1, 20) . '.jpg';
            }

            $item['images'] = json_encode($images);
            $project = Project::create($item);
            $project->categories()->sync([
                $faker->numberBetween(1, 3),
                $faker->numberBetween(4, 5),
            ]);
            $project->features()->sync([
                $faker->numberBetween(1, 5),
                $faker->numberBetween(5, 12),
            ]);

            $project->facilities()->detach();
            $project->facilities()->attach($faker->numberBetween(1, 3), ['distance' => rand(1, 20)]);
            $project->facilities()->attach($faker->numberBetween(4, 6), ['distance' => rand(1, 20)]);
            $project->facilities()->attach($faker->numberBetween(7, 9), ['distance' => rand(1, 20)]);
            $project->facilities()->attach($faker->numberBetween(10, 12), ['distance' => rand(1, 20)]);

            MetaBox::saveMetaBoxData($project, 'video_url', $faker->randomElement([
                'https://www.youtube.com/watch?v=U05fwua9-D4',
                'https://www.youtube.com/watch?v=0I647GU3Jsc',
            ]));

            Slug::create([
                'reference_type' => Project::class,
                'reference_id' => $project->id,
                'key' => Str::slug($project->name),
                'prefix' => SlugHelper::getPrefix(Project::class),
            ]);
        }

        foreach ($projects as $index => $item) {
            $content =
                ($index % 3 == 0 ? Html::tag(
                    'p',
                    '[youtube-video]https://www.youtube.com/watch?v=U05fwua9-D4[/youtube-video]'
                ) : '') .
                Html::tag('p', $faker->realText(1000)) .
                Html::tag(
                    'p',
                    Html::image(RvMedia::getImageUrl(
                        'projects/' . $faker->numberBetween(1, 6) . '.jpg',
                        'medium'
                    ))
                        ->toHtml(),
                    ['class' => 'text-center']
                ) .
                Html::tag('p', $faker->realText(500)) .
                Html::tag(
                    'p',
                    Html::image(RvMedia::getImageUrl(
                        'projects/' . $faker->numberBetween(7, 12) . '.jpg',
                        'medium'
                    ))
                        ->toHtml(),
                    ['class' => 'text-center']
                ) .
                Html::tag('p', $faker->realText(1000)) .
                Html::tag(
                    'p',
                    Html::image(RvMedia::getImageUrl(
                        'projects/' . $faker->numberBetween(13, 20) . '.jpg',
                        'medium'
                    ))
                        ->toHtml(),
                    ['class' => 'text-center']
                ) .
                Html::tag('p', $faker->realText(1000));
            DB::table('re_projects_translations')->insert([
                're_projects_id' => $index + 1,
                'lang_code' => 'vi',
                'name' => $item['name'],
                'description' => $faker->text(),
                'content' => $content,
                'location' => $faker->address,
            ]);
        }
    }
}
