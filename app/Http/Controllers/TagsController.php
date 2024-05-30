<?php

namespace App\Http\Controllers;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'Name' => 'required|unique:tags|max:255', // Убедитесь, что Name не повторяется и не превышает 255 символов
        ]);

        Tag::create($request->all());

        return redirect()->back()->with('success', 'Tag created successfully.');
    }
}
