<?php

namespace Salesengineonline\Hypermedia\src\Support;


use Illuminate\Foundation\Http\FormRequest;

abstract class HypermediaRequest extends FormRequest
{
    public abstract function form();

    public abstract function model();

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return collect($this->form())->map(function ($prop) {
            return $prop['validate'] ?? null;
        })->filter()->toArray();
    }
}