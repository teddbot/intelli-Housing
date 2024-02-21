<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPropertyLabelColumnToPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('re_properties')) {
            Schema::table('re_properties', function (Blueprint $table) {
                $table->string('label', 200)->nullable()->after('location');
            });
        }
        if (Schema::hasTable('re_properties_translations')) {
            Schema::table('re_properties_translations', function (Blueprint $table) {
                $table->string('label', 200)->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('properties')) {
            Schema::table('properties', function (Blueprint $table) {
                $table->dropColumn('label');
            });
        }

        if (Schema::hasTable('re_properties_translations')) {
            Schema::table('re_properties_translations', function (Blueprint $table) {
                $table->dropColumn('label');
            });
        }
    }
}
