<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Location;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\StoreItemRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateItemRequest;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::all();
        return view('item.index',[
            'items' => $items
        ]);
    }   

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::all();
        return view('item.create',compact('locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('itemImage','public');
            $data['image'] = $imagePath;
        }
        
        $item = Item::create($data);
        return redirect()->route('item.index')->with('success','Item Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        $locations = Location::all();

        return view('item.edit',compact('item','locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemRequest $request, Item $item)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
    
            // Simpan gambar baru
            $imagePath = $request->file('image')->store('itemImage', 'public');
            $data['image'] = $imagePath;
        }

        $item->update($data);
        return redirect()->route('item.index')->with('success','Item Updated Successfully');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('item.index')->with('success','Item Deleted Successfully');
    }
}
