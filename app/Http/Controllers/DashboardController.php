<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\Location;
use App\Models\Supplier;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function landing(){
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }else{
            return view('auth.login');
        }
    }

    public function index(){

        if (auth()->user()->hasRole('superadmin')) {
            $users = User::all()->count();
        } else {
            $users = User::whereDoesntHave('roles', function($query) {
                $query->where('name', 'superadmin');
            })->count();
        }

        $items = Item::all()->count();
        $locations = Location::all()->count();
        $suppliers = Supplier::all()->count();

        return view('dashboard',compact('users','items','locations','suppliers'));
    }
}
