<?php

use Botble\Widget\AbstractWidget;

class CategoriesWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Categories'),
            'description' => __('Display list of categories'),
        ]);
    }
}
