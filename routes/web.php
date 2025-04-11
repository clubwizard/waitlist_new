<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\PublicWaitlistController; // Add this line
use App\Http\Controllers\WaitlistManagementController;


Route::get('/', function () {
    $restaurant = \App\Models\Restaurant::where('active', true)->first();
    
    if ($restaurant) {
        return redirect()->route('public.waitlist.show', $restaurant->slug);
    }
    
    return view('welcome');
})->name('home');

Route::prefix('waitlist')->name('public.waitlist.')->group(function () {
    Route::get('/{restaurant:slug}', [PublicWaitlistController::class, 'show'])->name('show');
    Route::post('/{restaurant:slug}', [PublicWaitlistController::class, 'store'])->name('store');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/restaurants/{restaurant}/waitlist/create', [WaitlistManagementController::class, 'create'])->name('restaurants.waitlist.create');
    Route::post('/restaurants/{restaurant}/waitlist', [WaitlistManagementController::class, 'store'])->name('restaurants.waitlist.store');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('restaurants', RestaurantController::class);

    Route::get('/restaurants/{restaurant}/waitlist', [WaitlistManagementController::class, 'index'])->name('restaurants.waitlist.index');
    Route::patch('/waitlist-entries/{entry}/status', [WaitlistManagementController::class, 'updateStatus'])->name('waitlist.entries.updateStatus');
    Route::delete('/waitlist-entries/{entry}', [WaitlistManagementController::class, 'destroy'])->name('waitlist.entries.destroy');

});


require __DIR__.'/auth.php';
