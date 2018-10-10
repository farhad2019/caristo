<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;


class BaseFormRequest extends FormRequest
{
    /*public function __construct()
    {
        $this->validator = app('validator');

        $this->extendValidator($this->validator);

        parent::__construct();
    }*/
}