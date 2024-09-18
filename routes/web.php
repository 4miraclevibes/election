<?php

use App\Http\Controllers\Dashboard\KecamatanElectionController;
use App\Http\Controllers\Dashboard\TpsElectionController;
use App\Http\Controllers\Dashboard\KelurahanElectionController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ParticipantElectionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [LandingController::class, 'index'])->middleware(['auth', 'verified'])->name('home');

Route::get('/dashboard', function () {
    if (Auth::user()->role->name !== 'admin') { // Asumsikan role_id 1 adalah admin
        return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //Participant
    Route::get('/participant', [ParticipantElectionController::class, 'index'])->name('participant.index');
    Route::get('/participant/all', [ParticipantElectionController::class, 'all'])->name('participant.all');
    Route::post('/participant', [ParticipantElectionController::class, 'store'])->name('participant.store');
    Route::delete('/participant/{id}', [ParticipantElectionController::class, 'destroy'])->name('participant.destroy');
});

Route::group([
    'prefix' => 'dashboard', 
    'as' => 'dashboard.', 
    'middleware' => ['auth', function ($request, $next) {
        if (Auth::user()->role->name !== 'admin') { // Asumsikan role_id 1 adalah admin
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return $next($request);
    }]
], function () {
    // User
    Route::get('user/index', [UserController::class, 'index'])->name('user.index');
    Route::get('user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('user/edit/{user}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('user/update/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('user/destroy/{user}', [UserController::class, 'destroy'])->name('user.destroy');

    // TPS Election
    Route::get('tps/index', [TpsElectionController::class, 'index'])->name('tps.index');
    Route::post('tps/store', [TpsElectionController::class, 'store'])->name('tps.store');
    Route::delete('tps/destroy/{id}', [TpsElectionController::class, 'destroy'])->name('tps.destroy');
    Route::post('tps/storeDetail', [TpsElectionController::class, 'storeDetail'])->name('tps.storeDetail');
    Route::delete('tps/destroyDetail/{id}', [TpsElectionController::class, 'destroyDetail'])->name('tps.destroyDetail');

    // Kelurahan Election
    Route::get('kelurahan/index', [KelurahanElectionController::class, 'index'])->name('kelurahan.index');
    Route::post('kelurahan/store', [KelurahanElectionController::class, 'store'])->name('kelurahan.store');
    Route::delete('kelurahan/destroy/{id}', [KelurahanElectionController::class, 'destroy'])->name('kelurahan.destroy');
    // Kecamatan Election
    Route::get('kecamatan/index', [KecamatanElectionController::class, 'index'])->name('kecamatan.index');
    Route::post('kecamatan/store', [KecamatanElectionController::class, 'store'])->name('kecamatan.store');
    Route::delete('kecamatan/destroy/{id}', [KecamatanElectionController::class, 'destroy'])->name('kecamatan.destroy');
});

require __DIR__.'/auth.php';
