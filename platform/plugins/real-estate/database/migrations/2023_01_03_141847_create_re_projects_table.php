<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('re_investors')) {
            Schema::create('re_investors', function (Blueprint $table) {
                $table->id();
                $table->string('name', 120);
                $table->integer('avatar_id')->unsigned()->nullable();
                $table->text('description')->nullable();
                $table->string('status', 60)->default('published');
                $table->timestamps();
            });
        }
        if (! Schema::hasTable('re_projects')) {
            Schema::create('re_projects', function (Blueprint $table) {
                $table->id();
                $table->string('name', 300);
                $table->text('description')->nullable();
                $table->longText('content')->nullable();
                $table->string('images')->nullable();
                $table->string('location')->nullable();
                $table->integer('investor_id')->unsigned();
                $table->integer('number_block')->nullable();
                $table->smallInteger('number_floor')->nullable();
                $table->smallInteger('number_flat')->nullable();
                $table->boolean('is_featured')->default(0);
                $table->decimal('price_from', 15, 0)->nullable();
                $table->decimal('price_to', 15, 0)->nullable();
                $table->integer('currency_id')->unsigned()->nullable();
                $table->integer('city_id')->unsigned()->nullable();
                $table->integer('country_id')->unsigned()->nullable();
                $table->integer('state_id')->unsigned()->nullable();
                $table->string('status', 60)->default('selling');
                $table->string('latitude', 25)->nullable();
                $table->string('longitude', 25)->nullable();
                $table->integer('views')->unsigned()->default(0);
                $table->integer('author_id')->nullable();
                $table->string('author_type', 255)->default(addslashes(User::class));
                $table->timestamps();
            });

            if (! Schema::hasTable('re_projects_translations')) {
                Schema::create('re_projects_translations', function (Blueprint $table) {
                    $table->string('lang_code');
                    $table->integer('re_projects_id');
                    $table->string('name', 255)->nullable();
                    $table->string('description', 400)->nullable();
                    $table->longText('content')->nullable();
                    $table->string('location', 255)->nullable();
                    $table->primary(['lang_code', 're_projects_id'], 're_projects_translations_primary');
                });
            }

            if (! Schema::hasTable('re_investors_translations')) {
                Schema::create('re_investors_translations', function (Blueprint $table) {
                    $table->string('lang_code');
                    $table->integer('re_investors_id');
                    $table->string('name', 255)->nullable();
                    $table->string('description', 400)->nullable();
                    $table->primary(['lang_code', 're_investors_id'], 're_investors_translations_primary');
                });
            }

            if (! Schema::hasTable('re_project_features')) {
                Schema::create('re_project_features', function (Blueprint $table) {
                    $table->integer('project_id')->unsigned();
                    $table->integer('feature_id')->unsigned();
                });
            }

            if (! Schema::hasTable('re_project_categories')) {
                Schema::create('re_project_categories', function (Blueprint $table) {
                    $table->id();
                    $table->integer('project_id')->unsigned()->references('id')->on('re_projects')->onDelete('cascade');
                    $table->integer('category_id')->unsigned()->references('id')->on('re_categories')->onDelete('cascade');
                });
            }

            if (Schema::hasTable('re_properties')) {
                Schema::table('re_properties', function (Blueprint $table) {
                    $table->integer('project_id')->unsigned()->nullable();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('re_properties', function (Blueprint $table) {
            $table->dropColumn(['project_id']);
        });
        Schema::dropIfExists('re_investors_translations');
        Schema::dropIfExists('re_projects_translations');
        Schema::dropIfExists('re_project_categories');
        Schema::dropIfExists('re_project_features');
        Schema::dropIfExists('re_projects');
        Schema::dropIfExists('re_investors');
    }
};
