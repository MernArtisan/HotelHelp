<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::select(
            'id',
            'name',
            'location',
            'email',
            'contact',
            'address',
            'manager',
            'supervisor',
            'management_company',
            'ownership_group',
            'tax_location_code',
            'notes',
            'status'
        )
            ->withCount('employees')
            ->orderBy('created_at', 'desc')
            ->get();
            // return $hotels;
        return view('admin.hotels.index', compact('hotels'));
    }

    public function create()
    {
        return view('admin.hotels.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'manager' => 'required|string|max:255',
            'supervisor' => 'required|string|max:255',
            'management_company' => 'required|string|max:255',
            'ownership_group' => 'required|string|max:255',
            'tax_location_code' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'notes' => 'nullable|string',
            'status' => 'required|string|in:active,block',
            'email' => 'nullable|email',
            'contact' => 'nullable', 
        ]);

        try {
            $hotel = Hotel::create($validated);
            return redirect()->route('admin.hotels.index')->with('success', 'Hotel created successfully!');
        } catch (Exception $e) {
            Log::error('Error creating hotel: '. $e->getMessage());
            return redirect()->route('admin.hotels.create')
                ->withErrors(['error' => 'Something went wrong. Please try again.'])
                ->withInput();
        }
    }



    public function edit(string $id)
    {
        $hotel = Hotel::find($id);
        if (!$hotel) {
            return redirect()->route('admin.hotels.index')->with('error', 'Hotel not found.');  // Handle case when hotel not found.
        }
        return view('admin.hotels.edit', compact('hotel'));
    }

    public function update(Request $request, string $id)
    {
        $hotel = Hotel::find($id);
        if (!$hotel) {
            return redirect()->route('admin.hotels.index')->with('error', 'Hotel not found.');
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'manager' => 'required|string|max:255',
            'supervisor' => 'required|string|max:255',
            'management_company' => 'required|string|max:255',
            'ownership_group' => 'required|string|max:255',
            'tax_location_code' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'notes' => 'nullable|string',
            'status' => 'required|string|in:active,block',
            'email' => 'nullable|email|max:255',
            'contact' => 'nullable', 
        ]);
        try { 
            $hotel->update($validated);
            return redirect()->route('admin.hotels.index')->with('success', 'Hotel updated successfully!');
        } catch (Exception $e) {
            Log::error('Error creating hotel: '. $e->getMessage());
            return redirect()->route('admin.hotels.create')
                ->withErrors(['error' => 'Something went wrong. Please try again.'])
                ->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {
            $hotel = Hotel::findOrFail($id);
            if (!$hotel) {
                return redirect()->route('admin.hotels.index')->with('error', 'Hotel not found.');  // Handle case when hotel not found.
            }
            $hotel->delete();
            return redirect()->route('admin.hotels.index')->with('success', 'Hotel deleted successfully!');
        } catch (Exception $e) {
            Log::error('Failed to delete hotel: ' . $e->getMessage());
            return redirect()->route('admin.hotels.index')->with('error', 'Failed to delete hotel. Please try again.');
        }
    }


    public function ClientAddress(Request $request){
        $hotels = Hotel::orderBy('id','desc')->get();
        // return $hotels;
        return view('admin.address.address',compact('hotels'));
    }
}
