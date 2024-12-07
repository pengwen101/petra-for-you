<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventCategory;
use Illuminate\Support\Facades\Validator;

class EventCategoryController extends Controller
{
    public function index()
    {
        $categories = EventCategory::all(['id', 'name', 'notes'])->sortByDesc('created_at');
        return view('myAdmin.category.category', compact('categories'));
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:event_categories|max:255',
            'notes' => 'nullable|max:255',
        ], [
            'name.required' => 'The event category name is required.',
            'name.unique' => 'This event category name has already been taken.',
            'notes.max' => 'Notes must not exceed 255 characters.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.category')
                ->with('error', $validator->errors()->first())
                ->withInput();
        }

        EventCategory::create([
            'name' => $request->name,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.category')->with('success', 'Event category successfully created.');
    }

    public function update(Request $request, $id)
    {
        $eventCategory = EventCategory::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:event_categories,name,' . $id . '|max:255',
            'notes' => 'nullable|max:255',
        ], [
            'name.required' => 'The event category name is required.',
            'name.unique' => 'This event category name has already been taken.',
            'notes.max' => 'Notes must not exceed 255 characters.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.category')
                ->with('error', $validator->errors()->first())
                ->withInput();
        }

        $eventCategory->update([
            'name' => $request->name,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.category')->with('success', 'Event category successfully updated.');
    }

    public function remove($id)
    {
        $eventCategory = EventCategory::findOrFail($id);

        $eventCategory->delete();

        return redirect()->route('admin.category')->with('success', 'Event category successfully deleted.');
    }
}