<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventCategory;

class EventCategoryController extends Controller
{
    public function index()
{
    $categories = EventCategory::all();
    return view('myAdmin.category.category', compact('categories'));
}

public function add(Request $request)
{
    $request->validate([
        'name' => 'required|unique:event_categories|max:255',
        'notes' => 'nullable|max:255',
    ]);

    EventCategory::create([
        'name' => $request->name,
        'notes' => $request->notes,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('admin.category');
}
public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|unique:event_categories,name,' . $id . '|max:255',
        'notes' => 'nullable|max:255',
    ]);

    EventCategory::query()->where('id', $id)->update([
        'name' => $request->name,
        'notes' => $request->notes,
        'updated_at' => now()
    ]);

    return redirect()->route('admin.category');
}

public function remove($id)
{
    EventCategory::destroy($id);
    return redirect()->route('admin.category');
}
}
