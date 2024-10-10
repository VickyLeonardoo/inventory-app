<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Item;
use App\Models\Application;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applications = Application::all();

        return view('application.index', [
            'applications' => $applications,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $item = Item::all();
        return view('application.create', [
            'items' => $item,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        $request->validate([
            'application_date' => 'required|date',
            'items' => 'required|array',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $year = Carbon::now()->format('Y'); // Ambil tahun sekarang
        $lastApplication = Application::whereYear('created_at', $year)
                            ->orderBy('id', 'desc') // Dapatkan data terakhir di tahun ini
                            ->first();

        if ($lastApplication) {
            // Ambil nomor dari application_no terakhir, misal 'APP/2024/0005' -> 0005
            $lastNumber = intval(substr($lastApplication->application_no, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT); // Tambahkan 1 dan format jadi 4 digit
        } else {
            // Jika belum ada data di tahun ini, mulai dari 0001
            $newNumber = '0001';
        }

        // Buat application_no baru dengan format APP/{tahun}/000x
        $applicationNo = 'APP/' . $year . '/' . $newNumber;

        $application = Application::create([
            'application_no' => $applicationNo,
            'user_id' => auth()->id(),
            'application_date' => $request->application_date,
        ]);

        foreach ($request->items as $item) {
            $application->item()->attach($item['item_id'], ['quantity' => $item['quantity']]);
        }

        return redirect()->route('application.index')->with('success', 'Application created successfully.');
       
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        return view('application.show', [
            'application' => $application,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Application $application)
    {
        $data = $request->validate([
            'application_date' => 'required|date',
        ]);

        $application->update($data);
        return redirect()->route('application.show',$application)->with('success', 'Application updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        $application->delete();
        return redirect()->route('application.index')->with('success', 'Application deleted successfully.');
    }

    public function pending(Application $application){
        if ($application->item->count() == 0) {
            return redirect()->back()->with('error','Your application must have at least one item.');
        }
        $application->update(['status' => 'Pending']);
        return redirect()->route('application.index')->with('success', 'Application updated successfully.');
    }

    public function approve(Application $application){
        foreach ($application->item as $item) {
            $item->update(['current_stock' => $item->current_stock - $item->pivot->quantity]);
        }
        
        $application->update(['status' => 'Approved']);
        return redirect()->route('application.index')->with('success', 'Application updated successfully.');
    }

    public function reject(Request $request, Application $application){
        $application->update([
                'status' => 'Rejected',
                'remarks' => $request->remark,
            ]);
        return redirect()->route('application.index')->with('success', 'Application updated successfully.');
    }
}
