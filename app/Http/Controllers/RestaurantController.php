<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Requests\RestaurantRequest; // Will create this next

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restaurants = Auth::user()->restaurants()->latest()->paginate(10); // Paginate for better performance
        return view('restaurants.index', compact('restaurants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('restaurants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RestaurantRequest $request) // Use RestaurantRequest for validation
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = Auth::id();
        $validatedData['slug'] = Str::slug($validatedData['name']); // Generate slug
        $validatedData['active'] = $request->has('active'); // Handle checkbox

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $validatedData['logo_path'] = $path;
        }

        $originalSlug = $validatedData['slug'];
        $count = 1;
        while (Restaurant::where('slug', $validatedData['slug'])->exists()) {
            $validatedData['slug'] = $originalSlug . '-' . $count++;
        }


        Restaurant::create($validatedData);

        return redirect()->route('restaurants.index')->with('success', 'Restaurant created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Restaurant $restaurant)
    {
        $this->authorize('view', $restaurant);
        return view('restaurants.show', compact('restaurant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Restaurant $restaurant)
    {
        $this->authorize('update', $restaurant);
        return view('restaurants.edit', compact('restaurant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RestaurantRequest $request, Restaurant $restaurant)
    {
        $this->authorize('update', $restaurant);

        $validatedData = $request->validated();
        $validatedData['active'] = $request->has('active'); // Handle checkbox

        if ($restaurant->name !== $validatedData['name']) {
            $validatedData['slug'] = Str::slug($validatedData['name']);
            $originalSlug = $validatedData['slug'];
            $count = 1;
            while (Restaurant::where('slug', $validatedData['slug'])->where('id', '!=', $restaurant->id)->exists()) {
                $validatedData['slug'] = $originalSlug . '-' . $count++;
            }
        } else {
             unset($validatedData['slug']);
        }


        if ($request->hasFile('logo')) {
            if ($restaurant->logo_path) {
                Storage::disk('public')->delete($restaurant->logo_path);
            }
            $path = $request->file('logo')->store('logos', 'public');
            $validatedData['logo_path'] = $path;
        }

        $restaurant->update($validatedData);

        return redirect()->route('restaurants.index')->with('success', 'Restaurant updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant)
    {
        $this->authorize('delete', $restaurant);

        if ($restaurant->logo_path) {
            Storage::disk('public')->delete($restaurant->logo_path);
        }

        $restaurant->delete();

        return redirect()->route('restaurants.index')->with('success', 'Restaurant deleted successfully.');
    }
}
