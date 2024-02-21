<?php

namespace Botble\Location\Models;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;

class State extends BaseModel
{
    protected $table = 'states';

    protected $fillable = [
        'name',
        'abbreviation',
        'country_id',
        'order',
        'status',
        'is_featured',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    public function country()
    {
        return $this->belongsTo(Country::class)->withDefault();
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function (State $state) {
            City::where('state_id', $state->id)->delete();
        });
    }
}
