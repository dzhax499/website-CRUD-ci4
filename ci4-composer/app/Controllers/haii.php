<?php

namespace App\Controllers;

class haii extends BaseController
{
    public function index(): string
    {
        return view(name:'hello');
    }
}
