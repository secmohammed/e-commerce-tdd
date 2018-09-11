<?php

namespace App\Http\Controllers;

use App\Http\Responses\HomeIndexResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return new HomeIndexResponse;
    }
}