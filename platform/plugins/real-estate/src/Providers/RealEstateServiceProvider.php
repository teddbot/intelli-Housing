<?php

namespace Botble\RealEstate\Providers;

use Botble\Api\Facades\ApiHelper;
use Botble\Base\Facades\EmailHandler;
use Botble\Base\Facades\MetaBox;
use Botble\Base\Supports\Helper;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Language\Facades\Language;
use Botble\LanguageAdvanced\Supports\LanguageAdvancedManager;
use Botble\Optimize\Facades\OptimizerHelper;
use Botble\RealEstate\Commands\RenewPropertiesCommand;
use Botble\RealEstate\Facades\RealEstateHelper;
use Botble\RealEstate\Http\Middleware\RedirectIfAccount;
use Botble\RealEstate\Http\Middleware\RedirectIfNotAccount;
use Botble\RealEstate\Models\Account;
use Botble\RealEstate\Models\AccountActivityLog;
use Botble\RealEstate\Models\Category;
use Botble\RealEstate\Models\Consult;
use Botble\RealEstate\Models\Currency;
use Botble\RealEstate\Models\Facility;
use Botble\RealEstate\Models\Feature;
use Botble\RealEstate\Models\Investor;
use Botble\RealEstate\Models\Package;
use Botble\RealEstate\Models\Project;
use Botble\RealEstate\Models\Property;
use Botble\RealEstate\Models\Review;
use Botble\RealEstate\Models\Transaction;
use Botble\RealEstate\Models\Type;
use Botble\RealEstate\Repositories\Eloquent\AccountActivityLogRepository;
use Botble\RealEstate\Repositories\Eloquent\AccountRepository;
use Botble\RealEstate\Repositories\Eloquent\CategoryRepository;
use Botble\RealEstate\Repositories\Eloquent\ConsultRepository;
use Botble\RealEstate\Repositories\Eloquent\CurrencyRepository;
use Botble\RealEstate\Repositories\Eloquent\FacilityRepository;
use Botble\RealEstate\Repositories\Eloquent\FeatureRepository;
use Botble\RealEstate\Repositories\Eloquent\InvestorRepository;
use Botble\RealEstate\Repositories\Eloquent\PackageRepository;
use Botble\RealEstate\Repositories\Eloquent\ProjectRepository;
use Botble\RealEstate\Repositories\Eloquent\PropertyRepository;
use Botble\RealEstate\Repositories\Eloquent\ReviewRepository;
use Botble\RealEstate\Repositories\Eloquent\TransactionRepository;
use Botble\RealEstate\Repositories\Eloquent\TypeRepository;
use Botble\RealEstate\Repositories\Interfaces\AccountActivityLogInterface;
use Botble\RealEstate\Repositories\Interfaces\AccountInterface;
use Botble\RealEstate\Repositories\Interfaces\CategoryInterface;
use Botble\RealEstate\Repositories\Interfaces\ConsultInterface;
use Botble\RealEstate\Repositories\Interfaces\CurrencyInterface;
use Botble\RealEstate\Repositories\Interfaces\FacilityInterface;
use Botble\RealEstate\Repositories\Interfaces\FeatureInterface;
use Botble\RealEstate\Repositories\Interfaces\InvestorInterface;
use Botble\RealEstate\Repositories\Interfaces\PackageInterface;
use Botble\RealEstate\Repositories\Interfaces\ProjectInterface;
use Botble\RealEstate\Repositories\Interfaces\PropertyInterface;
use Botble\RealEstate\Repositories\Interfaces\ReviewInterface;
use Botble\RealEstate\Repositories\Interfaces\TransactionInterface;
use Botble\RealEstate\Repositories\Interfaces\TypeInterface;
use Botble\SeoHelper\Facades\SeoHelper;
use Botble\Slug\Facades\SlugHelper;
use Botble\SocialLogin\Facades\SocialService;
use Botble\Theme\Facades\SiteMapManager;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RealEstateServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->singleton(PropertyInterface::class, function () {
            return new PropertyRepository(new Property());
        });

        $this->app->singleton(ProjectInterface::class, function () {
            return new ProjectRepository(new Project());
        });

        $this->app->singleton(FeatureInterface::class, function () {
            return new FeatureRepository(new Feature());
        });

        $this->app->bind(InvestorInterface::class, function () {
            return new InvestorRepository(new Investor());
        });

        $this->app->bind(CurrencyInterface::class, function () {
            return new CurrencyRepository(new Currency());
        });

        $this->app->bind(ConsultInterface::class, function () {
            return new ConsultRepository(new Consult());
        });

        $this->app->bind(CategoryInterface::class, function () {
            return new CategoryRepository(new Category());
        });

        $this->app->bind(FacilityInterface::class, function () {
            return new FacilityRepository(new Facility());
        });

        $this->app->bind(ReviewInterface::class, function () {
            return new ReviewRepository(new Review());
        });

        $this->app->bind(AccountInterface::class, function () {
            return new AccountRepository(new Account());
        });

        $this->app->bind(AccountActivityLogInterface::class, function () {
            return new AccountActivityLogRepository(new AccountActivityLog());
        });

        $this->app->bind(PackageInterface::class, function () {
            return new PackageRepository(new Package());
        });

        $this->app->singleton(TransactionInterface::class, function () {
            return new TransactionRepository(new Transaction());
        });

        $this->app->singleton(TypeInterface::class, function () {
            return new TypeRepository(new Type());
        });

        config([
            'auth.guards.account' => [
                'driver' => 'session',
                'provider' => 'accounts',
            ],
            'auth.providers.accounts' => [
                'driver' => 'eloquent',
                'model' => Account::class,
            ],
            'auth.passwords.accounts' => [
                'provider' => 'accounts',
                'table' => 're_account_password_resets',
                'expire' => 60,
            ],
        ]);

        $router = $this->app->make('router');

        $router->aliasMiddleware('account', RedirectIfNotAccount::class);
        $router->aliasMiddleware('account.guest', RedirectIfAccount::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('RealEstateHelper', RealEstateHelper::class);

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        SlugHelper::registerModule(Property::class, 'Real Estate Properties');
        SlugHelper::registerModule(Category::class, 'Real Estate Property Categories');
        SlugHelper::registerModule(Project::class, 'Real Estate Projects');
        SlugHelper::setPrefix(Property::class, 'properties');
        SlugHelper::setPrefix(Project::class, 'projects');
        SlugHelper::setPrefix(Category::class, 'property-category');

        $this->setNamespace('plugins/real-estate')
            ->loadAndPublishConfigurations(['permissions', 'email', 'real-estate', 'assets'])
            ->loadMigrations()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web', 'review'])
            ->publishAssets();

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()
                ->registerItem([
                    'id' => 'cms-plugins-real-estate',
                    'priority' => 5,
                    'parent_id' => null,
                    'name' => 'plugins/real-estate::real-estate.name',
                    'icon' => 'fa fa-bed',
                    'permissions' => ['property.index'],
                ])
                ->registerItem([
                    'id' => 'cms-plugins-project',
                    'priority' => 1,
                    'parent_id' => 'cms-plugins-real-estate',
                    'name' => 'plugins/real-estate::project.name',
                    'icon' => null,
                    'url' => route('project.index'),
                    'permissions' => ['project.index'],
                ])
                ->registerItem([
                    'id' => 'cms-plugins-property',
                    'priority' => 0,
                    'parent_id' => 'cms-plugins-real-estate',
                    'name' => 'plugins/real-estate::property.name',
                    'icon' => null,
                    'url' => route('property.index'),
                    'permissions' => ['property.index'],
                ])
                ->registerItem([
                    'id' => 'cms-plugins-re-feature',
                    'priority' => 2,
                    'parent_id' => 'cms-plugins-real-estate',
                    'name' => 'plugins/real-estate::feature.name',
                    'icon' => null,
                    'url' => route('property_feature.index'),
                    'permissions' => ['property_feature.index'],
                ])
                ->registerItem([
                    'id' => 'cms-plugins-facility',
                    'priority' => 3,
                    'parent_id' => 'cms-plugins-real-estate',
                    'name' => 'plugins/real-estate::facility.name',
                    'icon' => null,
                    'url' => route('facility.index'),
                    'permissions' => ['facility.index'],
                ])
                ->registerItem([
                    'id' => 'cms-plugins-investor',
                    'priority' => 3,
                    'parent_id' => 'cms-plugins-real-estate',
                    'name' => 'plugins/real-estate::investor.name',
                    'icon' => null,
                    'url' => route('investor.index'),
                    'permissions' => ['investor.index'],
                ])
                ->registerItem([
                    'id' => 'cms-plugins-real-estate-settings',
                    'priority' => 999,
                    'parent_id' => 'cms-plugins-real-estate',
                    'name' => 'plugins/real-estate::real-estate.settings',
                    'icon' => null,
                    'url' => route('real-estate.settings'),
                    'permissions' => ['real-estate.settings'],
                ])
                ->registerItem([
                    'id' => 'cms-plugins-consult',
                    'priority' => 6,
                    'parent_id' => null,
                    'name' => 'plugins/real-estate::consult.name',
                    'icon' => 'fas fa-headset',
                    'url' => route('consult.index'),
                    'permissions' => ['consult.index'],
                ])
                ->registerItem([
                    'id' => 'cms-plugins-real-estate-category',
                    'priority' => 4,
                    'parent_id' => 'cms-plugins-real-estate',
                    'name' => 'plugins/real-estate::category.name',
                    'icon' => null,
                    'url' => route('property_category.index'),
                    'permissions' => ['property_category.index'],
                ])
                ->registerItem([
                    'id' => 'cms-plugins-real-estate-type',
                    'priority' => 5,
                    'parent_id' => 'cms-plugins-real-estate',
                    'name' => 'plugins/real-estate::type.name',
                    'icon' => null,
                    'url' => route('property_type.index'),
                    'permissions' => ['property_type.index'],
                ])
                ->registerItem([
                    'id' => 'cms-plugins-real-estate-account',
                    'priority' => 22,
                    'parent_id' => null,
                    'name' => 'plugins/real-estate::account.name',
                    'icon' => 'fa fa-users',
                    'url' => route('account.index'),
                    'permissions' => ['account.index'],
                ])
                ->registerItem([
                    'id' => 'cms-real-estate-review',
                    'priority' => 9,
                    'parent_id' => 'cms-plugins-real-estate',
                    'name' => 'plugins/real-estate::review.name',
                    'icon' => null,
                    'url' => route('reviews.index'),
                    'permissions' => ['reviews.index'],
                ]);

            if (RealEstateHelper::isEnabledCreditsSystem()) {
                dashboard_menu()
                    ->registerItem([
                        'id' => 'cms-plugins-package',
                        'priority' => 23,
                        'parent_id' => null,
                        'name' => 'plugins/real-estate::package.name',
                        'icon' => 'fas fa-money-check-alt',
                        'url' => route('package.index'),
                        'permissions' => ['package.index'],
                    ]);
            }
        });

        if (class_exists('ApiHelper')) {
            ApiHelper::setConfig([
                'model' => Account::class,
                'guard' => 'account',
                'password_broker' => 'accounts',
                'verify_email' => setting('verify_account_email', config('plugins.real-estate.real-estate.verify_email')),
            ]);
        }

        $this->app->register(CommandServiceProvider::class);

        SiteMapManager::registerKey([
            'properties',
            'projects',
            'property-categories',
            'agents',
            'properties-city',
        ]);

        $useLanguageV2 = $this->app['config']->get('plugins.real-estate.real-estate.use_language_v2', false) &&
            defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME');

        if (defined('LANGUAGE_MODULE_SCREEN_NAME') && $useLanguageV2) {
            LanguageAdvancedManager::registerModule(Property::class, [
                'name',
                'description',
                'content',
                'location',
                'label',
            ]);

            LanguageAdvancedManager::registerModule(Project::class, [
                'name',
                'description',
                'content',
                'location',
            ]);

            LanguageAdvancedManager::registerModule(Investor::class, [
                'name',
                'description',
            ]);

            LanguageAdvancedManager::registerModule(Category::class, [
                'name',
                'description',
            ]);

            LanguageAdvancedManager::registerModule(Feature::class, [
                'name',
            ]);

            LanguageAdvancedManager::registerModule(Facility::class, [
                'name',
            ]);

            LanguageAdvancedManager::registerModule(Type::class, [
                'name',
                'slug',
            ]);

            LanguageAdvancedManager::registerModule(Package::class, [
                'name',
                'features',
            ]);
        }
        $this->app->booted(function () use ($useLanguageV2) {
            if (defined('LANGUAGE_MODULE_SCREEN_NAME') && ! $useLanguageV2) {
                Language::registerModule([
                    Property::class,
                    Project::class,
                    Investor::class,
                    Feature::class,
                    Category::class,
                    Type::class,
                    Facility::class,
                    Package::class,
                ]);
            }

            if (defined('SOCIAL_LOGIN_MODULE_SCREEN_NAME') && Route::has('public.account.login')) {
                SocialService::registerModule([
                    'guard' => 'account',
                    'model' => Account::class,
                    'login_url' => route('public.account.login'),
                    'redirect_url' => route('public.account.dashboard'),
                ]);
            }

            SeoHelper::registerModule([
                Property::class,
                Project::class,
            ]);

            $this->app->make(Schedule::class)->command(RenewPropertiesCommand::class)->dailyAt('23:30');

            EmailHandler::addTemplateSettings(REAL_ESTATE_MODULE_SCREEN_NAME, config('plugins.real-estate.email', []));

            $this->app->register(HookServiceProvider::class);
        });

        $this->app->register(EventServiceProvider::class);

        if (is_plugin_active('rss-feed') && Route::has('feeds.properties')) {
            \RssFeed::addFeedLink(route('feeds.properties'), 'Properties feed');
        }

        add_action(BASE_ACTION_META_BOXES, function ($context, $object) {
            if (get_class($object) == Account::class && $context == 'advanced') {
                MetaBox::addMetaBox('additional_blog_category_fields', __('Addition Information'), function () {
                    $description = null;
                    $args = func_get_args();
                    if (! empty($args[0])) {
                        $description = MetaBox::getMetaData($args[0], 'description', true);
                    }

                    return view('plugins/real-estate::partials.account_additional_fields', compact('description'));
                }, get_class($object), $context);
            }
        }, 24, 2);

        add_action(BASE_ACTION_AFTER_CREATE_CONTENT, function ($type, $request, $object) {
            if (get_class($object) == Account::class) {
                MetaBox::saveMetaBoxData($object, 'description', $request->input('description'));
            }
        }, 230, 3);

        add_action(BASE_ACTION_AFTER_UPDATE_CONTENT, function ($type, $request, $object) {
            if (get_class($object) == Account::class) {
                MetaBox::saveMetaBoxData($object, 'description', $request->input('description'));
            }
        }, 231, 3);
    }

    public function setInAdmin(bool $isInAdmin): bool
    {
        $isInAdmin = in_array('account', Route::current()->middleware()) || $isInAdmin;

        if ($isInAdmin) {
            OptimizerHelper::disable();
        }

        return $isInAdmin;
    }
}
