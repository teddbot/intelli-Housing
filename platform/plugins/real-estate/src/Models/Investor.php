<?php

namespace Botble\RealEstate\Models;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Botble\Base\Supports\Avatar;
use Botble\Media\Models\MediaFile;
use Exception;
use RvMedia;

class Investor extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 're_investors';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'status',
        'avatar_id',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function avatar()
    {
        return $this->belongsTo(MediaFile::class)->withDefault();
    }

    /**
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar->url) {
            return RvMedia::url($this->avatar->url);
        }

        try {
            return (new Avatar())->create($this->name)->toBase64();
        } catch (Exception $exception) {
            return RvMedia::getDefaultImage();
        }
    }
}
