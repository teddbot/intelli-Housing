<?php

namespace Botble\RealEstate\Models;

use Botble\Base\Models\BaseModel;
use Botble\RealEstate\Enums\ConsultStatusEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Consult extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 're_consults';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'content',
        'property_id',
        'status',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => ConsultStatusEnum::class,
    ];

    /**
     * @return BelongsTo
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}
