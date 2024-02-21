<?php

namespace Botble\Location\Models;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;

class City extends BaseModel
{
    protected $table = 'cities';

    protected $fillable = [
        'name',
        'slug',
        'state_id',
        'country_id',
        'record_id',
        'order',
        'status',
        'is_featured',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    public function state()
    {
        return $this->belongsTo(State::class)->withDefault();
    }

    public function country()
    {
        return $this->belongsTo(Country::class)->withDefault();
    }
}
