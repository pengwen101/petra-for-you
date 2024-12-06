<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all();
        return view('myAdmin.tag.tag', compact('tags'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:tags|max:255',
        ]);

        Tag::create([
            'name' => $request->name,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.tag');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:tags,name,' . $id . '|max:255',
        ]);

        Tag::query()->where('id', $id)->update([
            'name' => $request->name,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.tag');
    }

    public function remove($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return redirect()->route('admin.tag');
    }
}