<?php

namespace Botble\Table\Columns;

class NameColumn extends Column
{
    public static function make(array|string $data = [], string $name = ''): static
    {
        return parent::make($data ?: 'name', $name)
            ->title(trans('core/base::tables.name'))
            ->alignLeft();
    }
}
