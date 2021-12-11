<?php

namespace Modules\Main\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Nwidart\Modules\Facades\Module;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $modules = Module::all();
        return view('main::index', compact('modules'));
    }
    public function Enable($module)
    {
        $module = Module::find($module);
        $module->enable();
        return back();
    }
    public function Disable($module)
    {
        $module = Module::find($module);
        $module->disable();
        return back();
    }
}
