<?php

use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\EdificioController;
use App\Http\Controllers\Admin\OficinaController;
use App\Http\Controllers\Admin\PedidoController;
use App\Http\Controllers\Admin\SolicitanteController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Ruta de logout de emergencia
Route::get('/emergency-logout', function () {
    // Limpiar sesión actual
    session()->flush();
    
    // Eliminar cookie de sesión
    if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            setcookie($name, '', time() - 3600, '/');
        }
    }
    
    return redirect('/login')->with('message', 'Sesión cerrada correctamente.');
})->name('emergency.logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('areas', AreaController::class);
        Route::resource('edificios', EdificioController::class);
        Route::resource('oficinas', OficinaController::class);
        // Rutas para solicitantes (las rutas específicas van antes del resource)
        Route::get('solicitantes/search', [SolicitanteController::class, 'search'])->name('solicitantes.search');
        Route::post('solicitantes/store-quick', [SolicitanteController::class, 'storeQuick'])->name('solicitantes.storeQuick');
        Route::resource('solicitantes', SolicitanteController::class);
        Route::resource('pedidos', PedidoController::class);
        
        Route::post('pedidos/{pedido}/recibir', [PedidoController::class, 'recibir'])->name('pedidos.recibir');
        Route::post('pedidos/{pedido}/enviar', [PedidoController::class, 'enviar'])->name('pedidos.enviar');
        Route::post('pedidos/{pedido}/entregar', [PedidoController::class, 'entregar'])->name('pedidos.entregar');        
        
    });
});

require __DIR__.'/auth.php';
