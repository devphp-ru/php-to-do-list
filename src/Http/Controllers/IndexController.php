<?php

namespace App\Http\Controllers;

use Framework\Controllers\Controller;
use Exception;

class IndexController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(): string
    {

        return view('home/index', [
            'number' => 344,
        ]);
    }

}
