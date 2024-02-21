<?php

use Botble\Widget\AbstractWidget;

class ShortcodeWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Shortcode widget'),
            'content' => null,
            'description' => __('Adds a text-like widget that allows you to write shortcode in it.'),
        ]);
    }
}
