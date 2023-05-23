<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Traits\Conditionable;
class UniqueSingularOrPlural implements Rule
{

    protected $ignore;
    protected $categoryId;
    protected $model;

    public function __construct($model,$ignore = null)
    {
        $this->ignore = $ignore;
        $this->model = 'App\Models\\'.Str::singular($model);
    }

    public function passes($attribute, $value)
    {
        $this->categoryId = $this->model::where($attribute, Str::singular($value))
            ->orWhere($attribute, Str::plural($value))
            ->when($this->ignore, function ($query) {
                return $query->where($this->ignore->getKeyName(), '!=', $this->ignore->getKey());
            })
            ->value((new $this->model)->getKeyName());

        return !$this->categoryId;
    }


    public function message()
    {
        return __('validation.unique');
    }


}
