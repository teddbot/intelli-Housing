<?php

namespace Botble\Location\Models;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;

class Country extends BaseModel
{
    protected $table = 'countries';

    protected $fillable = [
        'name',
        'nationality',
        'order',
        'status',
        'is_featured',
        'code',
        'dial_code',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function (Country $country) {
            $states = State::get();
            foreach ($states as $state) {
                State::where('id', $state->id)->delete();
            }

            City::where('country_id', $country->id)->delete();
        });
    }
}
