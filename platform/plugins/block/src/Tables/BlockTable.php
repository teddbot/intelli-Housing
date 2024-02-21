<?php

namespace Botble\Block\Tables;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Facades\BaseHelper;
use Botble\Base\Facades\Html;
use Botble\Block\Models\Block;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class BlockTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Block::class)
            ->addActions([
                EditAction::make()->route('block.edit'),
                DeleteAction::make()->route('block.destroy'),
            ]);
    }

    public function ajax(): JsonResponse
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function (Block $item) {
                if (! $this->hasPermission('block.edit')) {
                    return BaseHelper::clean($item->name);
                }

                return Html::link(route('block.edit', $item->getKey()), BaseHelper::clean($item->name));
            });

        if (function_exists('shortcode')) {
            $data = $data->editColumn('alias', function (Block $item) {
                return generate_shortcode('static-block', ['alias' => $item->alias]);
            });
        }

        return $this->toJson($data);
    }

    public function query(): Relation|Builder|QueryBuilder
    {
        $query = $this
            ->getModel()
            ->query()
            ->select([
                'id',
                'alias',
                'name',
                'created_at',
                'status',
            ]);

        return $this->applyScopes($query);
    }

    public function columns(): array
    {
        return [
            IdColumn::make(),
            NameColumn::make(),
            Column::make('alias')
                ->title(trans('core/base::tables.shortcode'))
                ->alignLeft(),
            CreatedAtColumn::make(),
            StatusColumn::make(),
        ];
    }

    public function buttons(): array
    {
        return $this->addCreateButton(route('block.create'), 'block.create');
    }

    public function bulkActions(): array
    {
        return [
            DeleteBulkAction::make()->permission('block.destroy'),
        ];
    }

    public function getBulkChanges(): array
    {
        return [
            'name' => [
                'title' => trans('core/base::tables.name'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],
            'status' => [
                'title' => trans('core/base::tables.status'),
                'type' => 'customSelect',
                'choices' => BaseStatusEnum::labels(),
                'validate' => 'required|' . Rule::in(BaseStatusEnum::values()),
            ],
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'type' => 'datePicker',
            ],
        ];
    }
}
