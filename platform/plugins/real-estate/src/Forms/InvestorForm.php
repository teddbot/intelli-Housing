<?php

namespace Botble\RealEstate\Forms;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Forms\FormAbstract;
use Botble\RealEstate\Http\Requests\InvestorRequest;
use Botble\RealEstate\Models\Investor;
use Throwable;

class InvestorForm extends FormAbstract
{
    /**
     * @return mixed|void
     * @throws Throwable
     */
    public function buildForm()
    {
        $this
            ->setupModel(new Investor())
            ->setValidatorClass(InvestorRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label' => trans('core/base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('description', 'textarea', [
                'label' => trans('core/base::forms.description'),
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'rows' => 4,
                    'placeholder' => trans('core/base::forms.description_placeholder'),
                    'data-counter' => 350,
                ],
            ])
            ->add('status', 'customSelect', [
                'label' => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'class' => 'form-control select-full',
                ],
                'choices' => BaseStatusEnum::labels(),
            ])
            ->add('avatar_image', 'mediaImage', [
                'label' => trans('core/base::forms.image'),
                'label_attr' => ['class' => 'control-label'],
                'value' => $this->getModel()->avatar->url,
            ])
            ->setBreakFieldPoint('avatar_image');
    }
}
