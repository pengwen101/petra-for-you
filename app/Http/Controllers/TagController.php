<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all(['id', 'name'])->sortByDesc('created_at');
        return view('myAdmin.tag.tag', compact('tags'));
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:tags|max:255',
        ], [
            'name.required' => 'The tag name is required.',
            'name.unique' => 'This tag name has already been taken.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.tag')
                ->with('error', $validator->errors()->first())
                ->withInput();
        }

        Tag::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.tag')->with('success', 'Tag successfully created.');
    }

    public function update(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:tags,name,' . $id . '|max:255',
        ], [
            'name.required' => 'The tag name is required.',
            'name.unique' => 'This tag name has already been taken.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.tag')
                ->with('error', $validator->errors()->first())
                ->withInput();
        }

        $tag->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.tag')->with('success', 'Tag successfully updated.');
    }

    public function remove($id)
    {
        $tag = Tag::findOrFail($id);

        $tag->delete();

        return redirect()->route('admin.tag')->with('success', 'Tag successfully deleted.');
    }
}