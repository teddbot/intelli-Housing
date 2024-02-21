<?php

namespace Botble\Table\Columns;

class StatusColumn extends Column
{
    public static function make(array|string $data = [], string $name = ''): static
    {
        return parent::make($data ?: 'status', $name)
            ->data('status')
            ->title(trans('core/base::tables.status'))
            ->alignCenter()
            ->width(100);
    }
}
