<?php

namespace Botble\Table\Columns;

class CreatedAtColumn extends DateColumn
{
    public static function make(array|string $data = [], string $name = ''): static
    {
        return parent::make('created_at', $name)
            ->data('created_at')
            ->title(trans('core/base::tables.created_at'))
            ->type('date')
            ->width(100);
    }
}
