<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;

class GetAttributeValue extends Controller
{
    public function getvalue(Request $request)
    {
        $data = $request->validate([
            'name' => 'required'
        ]);
        $attribute = Attribute::where('name', $data["name"])->first();
        if (is_null($attribute)) {
            return response(['data' => []]);
        }
        return response(['data' => $attribute->values->pluck('value')]);
    }
}
