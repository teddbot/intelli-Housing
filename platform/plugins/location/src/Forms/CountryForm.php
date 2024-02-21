<?php

namespace Botble\Location\Forms;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Forms\FormAbstract;
use Botble\Location\Http\Requests\CountryRequest;
use Botble\Location\Models\Country;

class CountryForm extends FormAbstract
{
    /**
     * {@inheritDoc}
     */
    public function buildForm()
    {
        $this
            ->setupModel(new Country())
            ->setValidatorClass(CountryRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label' => trans('core/base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('nationality', 'text', [
                'label' => trans('plugins/location::country.nationality'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => trans('plugins/location::country.nationality'),
                    'data-counter' => 120,
                ],
            ])
            ->add('code', 'text', [
                'label' => trans('plugins/location::country.code'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => trans('plugins/location::country.code_placeholder'),
                    'data-counter' => 10,
                ],
                'help_block' => [
                    'text' => trans('plugins/location::country.code_helper'),
                    'tag' => 'p',
                    'attr' => [
                        'class' => 'help-ts',
                    ],
                ],
            ])
            ->add('dial_code', 'text', [
                'label' => trans('plugins/location::country.dial_code'),
                'label_attr' => ['class' => 'control-label dial_code'],
                'attr' => [
                    'placeholder' => trans('plugins/location::country.dial_code'),
                ],
            ])
            ->add('order', 'number', [
                'label' => trans('core/base::forms.order'),
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'placeholder' => trans('core/base::forms.order_by_placeholder'),
                ],
                'default_value' => 0,
            ])
            ->add('status', 'customSelect', [
                'label' => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'class' => 'form-control select-full',
                ],
                'choices' => BaseStatusEnum::labels(),
            ])
            ->setBreakFieldPoint('status');
    }
}
