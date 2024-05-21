<?php

namespace LambdaDigamma\MMPages\Http\Controllers\Admin;

use LambdaDigamma\MMPages\Http\Controllers\Controller;
use LambdaDigamma\MMPages\Models\MenuItem;

class EditorController extends Controller
{
    public function menu()
    {
        return MenuItem::all();
    }
}
