<?php

namespace Botble\Page\Tables;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Facades\BaseHelper;
use Botble\Base\Facades\Html;
use Botble\Page\Models\Page;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class PageTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Page::class)
            ->addActions([
                EditAction::make()->route('pages.edit'),
                DeleteAction::make()->route('pages.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                NameColumn::make()->alignLeft(),
                Column::make('template')
                    ->title(trans('core/base::tables.template'))
                    ->alignLeft(),
                CreatedAtColumn::make(),
                StatusColumn::make(),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('pages.destroy'),
            ])
            ->addBulkChanges([
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
                'template' => [
                    'title' => trans('core/base::tables.template'),
                    'type' => 'customSelect',
                    'choices' => get_page_templates(),
                    'validate' => 'required',
                ],
                'created_at' => [
                    'title' => trans('core/base::tables.created_at'),
                    'type' => 'datePicker',
                ],
            ])
            ->queryUsing(function (Builder $query) {
                $query->select([
                    'id',
                    'name',
                    'template',
                    'created_at',
                    'status',
                ]);
            })
            ->onAjax(function (): JsonResponse {
                return $this->toJson(
                    $this
                        ->table
                        ->eloquent($this->query())
                        ->editColumn('name', function (Page $item) {
                            if (! $this->hasPermission('posts.edit')) {
                                $name = BaseHelper::clean($item->name);
                            } else {
                                $name = Html::link(route('pages.edit', $item->getKey()), BaseHelper::clean($item->name));
                            }

                            if (function_exists('theme_option') && BaseHelper::isHomepage($item->getKey())) {
                                $name .= Html::tag('span', ' — ' . trans('packages/page::pages.front_page'), [
                                    'class' => 'additional-page-name',
                                ])->toHtml();
                            }

                            return apply_filters(PAGE_FILTER_PAGE_NAME_IN_ADMIN_LIST, $name, $item);
                        })
                        ->editColumn('template', function (Page $item) {
                            static $pageTemplates;

                            $pageTemplates ??= get_page_templates();

                            return Arr::get($pageTemplates, $item->template ?: 'default');
                        })
                );
            });
    }

    public function buttons(): array
    {
        return $this->addCreateButton(route('pages.create'), 'pages.create');
    }
}
