<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArrivalRequest;
use App\Http\Requests\UpdateArrivalRequest;
use App\Models\Item;
use App\Models\Arrival;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ArrivalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $arrivals = Arrival::all()->load('supplier')->load('item');
        return view('arrival.index', compact('arrivals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::all();
        $suppliers = Supplier::all();
        return view('arrival.create', compact('items', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArrivalRequest $request)
    {
        $data = $request->validated();
        
        Arrival::create($data);
        $item = Item::find($data['item_id']);
        $item->current_stock += $data['quantity'];
        $item->save();
        return redirect()->route('arrival.index')->with('success','Data has been created and stock has been updated!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Arrival $arrival)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Arrival $arrival)
    {
        $items = Item::all();
        $suppliers = Supplier::all();
        return view('arrival.edit', compact('items','suppliers','arrival'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArrivalRequest $request, Arrival $arrival)
    {
        $data = $request->validated();
        $arrival->update($data);

        $item = $arrival->item;
        $oldQuantity = $arrival->quantity;
        $newQuantity = $data['quantity'];
    
        // Update stok berdasarkan perbedaan quantity lama dan baru
        $item->current_stock = $item->current_stock - $oldQuantity + $newQuantity;
        $item->save();

        return redirect()->route('arrival.index')->with('success','Data has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Arrival $arrival)
    {
        // Ambil item yang terkait dengan arrival
        $item = $arrival->item;

        // Kurangi stok sesuai dengan jumlah quantity arrival yang dihapus
        $item->current_stock -= $arrival->quantity;
        $item->save();

        // Hapus arrival
        $arrival->delete();

        return redirect()->back()->with('success', 'Arrival berhasil dihapus dan stok diperbarui');
    }
}
