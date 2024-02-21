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
        if (Schema::hasColumn('countries', 'dial_code')) {
            Schema::table('countries', function (Blueprint $table) {
                $table->dropColumn('dial_code');
            });
        }

        Schema::table('countries', function (Blueprint $table) {
            $table->string('dial_code', 120)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
