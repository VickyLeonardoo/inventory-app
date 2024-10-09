<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Models\ItemApplication;

class ItemApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Application $application){
        // Get all items
        $allItems = Item::all();
        
        // Get items already associated with this application
        $existingItemIds = $application->item->pluck('id')->toArray();
        
        // Filter out the items that are already associated
        $availableItems = $allItems->whereNotIn('id', $existingItemIds);
        
        return view('item_application.create', [
            'items' => $availableItems,
            'application' => $application
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,Application $application)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        foreach ($request->items as $item) {
            $application->item()->attach($item['item_id'], ['quantity' => $item['quantity']]);
        }
        
        return redirect()->route('application.show', $application)->with('success', 'Item added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Application $application, ItemApplication $item){
        // Get all items
        $allItems = Item::all();

        // Get items already associated with this application, excluding the current item

        $existingItemIds = $application->item->pluck('id')->toArray();


        // Filter out the items that are already associated, but keep the current item
        $availableItems = $allItems->filter(function ($availableItem) use ($existingItemIds, $item) {
            return !in_array($availableItem->id, $existingItemIds) || $availableItem->id == $item->item_id;
        });

        return view('item_application.edit', [
            'item' => $item,
            'application' => $application,
            'availableItems' => $availableItems
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Application $application, ItemApplication $item)
    {
        $data = $request->validate([
            'item_id' => 'required',
            'quantity' => 'required|integer|min:1',
        ]);
        $item->update($data);
        return redirect()->route('application.show', $application)->with('success', 'Item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application, ItemApplication $item)
    {
        $item->delete();
        return redirect()->route('application.show', $application)->with('success', 'Application deleted successfully.');
    }

}
