<?php

namespace Botble\RealEstate\Facades;

use Botble\RealEstate\Supports\RealEstateHelper as RealEstateHelperSupport;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Botble\RealEstate\Supports\RealEstateHelper
 */
class RealEstateHelper extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return RealEstateHelperSupport::class;
    }
}
