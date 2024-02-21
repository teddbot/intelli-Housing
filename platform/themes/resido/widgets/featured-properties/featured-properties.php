<?php

use Botble\Widget\AbstractWidget;

class FeaturedPropertiesWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Featured properties'),
            'description' => __('Featured properties widget.'),
            'number_display' => 5,
        ]);
    }
}
