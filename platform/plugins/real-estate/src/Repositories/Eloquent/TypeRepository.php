<?php

namespace Botble\RealEstate\Repositories\Eloquent;

use Botble\RealEstate\Repositories\Interfaces\TypeInterface;
use Botble\Support\Repositories\Eloquent\RepositoriesAbstract;
use Illuminate\Support\Str;

class TypeRepository extends RepositoriesAbstract implements TypeInterface
{
    public function createSlug($name, $id)
    {
        $slug = Str::slug($name);
        $index = 1;
        $baseSlug = $slug;
        while ($this->model->where('slug', $slug)->where('id', '!=', $id)->count() > 0) {
            $slug = $baseSlug . '-' . $index++;
        }

        if (empty($slug)) {
            $slug = time();
        }
        $this->resetModel();

        return $slug;
    }
}
