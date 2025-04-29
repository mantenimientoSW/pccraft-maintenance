<?php

use App\Http\Controllers\Ecommerce\HomeController;
use App\Http\Controllers\Ecommerce\BuscadorProductsController;
use App\Http\Controllers\Ecommerce\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Ecommerce\Cart\CartController;
use App\Http\Controllers\RecomendacionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Ecommerce\UserOrderController;
use App\Http\Controllers\Ecommerce\ConfiguradorPCController;

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

Route::get('/', [HomeController::class, 'index'] )->name('home');

// Sistema de Recomendaciones
Route::get('/recomendaciones', [RecomendacionController::class, 'index']);

// Buscador productos
Route::get('buscador', [BuscadorProductsController::class, 'index'])->name('productos.buscador');
// Producto segun categorias
Route::get('productos/categoria/{category}', [BuscadorProductsController::class, 'categorias'])->name('productos.categorias');

// Mostrar los productos individualmente
Route::get('/productos/{product}', [ProductController::class, 'index'] );


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Probando hasta ver si funciona.
// Mostrar la vista estática de preguntas frecuentes.
Route::get('/soporte', function () {
    return view('support/faqs'); // Asegúrate de que la vista esté en resources/views/faqs.blade.php
})->name('faqs.index');

Route::get('/comentario', function () {
    return view('ecommerce/comment');
})->name('comment.index');
Route::match(['get', 'post'], '/orden/{orderId}/producto/{productId}/reseña', [UserOrderController::class, 'reviewForm'])->name('comment.index');

// Sesiones de usuario
Route::middleware('auth')->group(function () {
    // Rutas del perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update.save');


    // Rutas para la gestión de la contraseña
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');

    // Rutas para la gestión de direcciones
    Route::get('/profile/update', [ProfileController::class, 'showUpdateForm'])->name('profile.update');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update.save');
    
    Route::post('/profile/add-address', [ProfileController::class, 'addAddress'])->name('profile.addAddress');
    Route::delete('/profile/delete-address/{direccion}', [ProfileController::class, 'deleteAddress'])->name('profile.deleteAddress');
    
    // Ruta para seleccionar dirección predeterminada
    Route::patch('/profile/set-default-address/{direccion}', [ProfileController::class, 'setDefaultAddress'])->name('profile.setDefaultAddress');

    // Nueva ruta para editar dirección específica
    Route::get('/profile/edit-address/{direccion}', [ProfileController::class, 'editAddress'])->name('profile.editAddress');
    Route::patch('/profile/edit-address/{direccion}', [ProfileController::class, 'updateAddress'])->name('profile.updateAddress');
});
require __DIR__.'/auth.php';
// Rutas para el usuario ordenes
Route::middleware('auth')->prefix('user')->name('user.')->group(function () {
    Route::get('/orders', [App\Http\Controllers\Ecommerce\UserOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [App\Http\Controllers\Ecommerce\UserOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{id}', [App\Http\Controllers\Ecommerce\UserOrderController::class, 'update'])->name('orders.update');
});

// Rutas para el carrito de compras
Route::get('/shop', [CartController::class, 'shop'])->name('shop');
Route::get('/cart', [CartController::class, 'cart'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/logout', [CartController::class, 'logout'])->name('logout');

//Rutas para los pagos
Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::get('/checkout/success', [CartController::class, 'success'])->name('checkout.success');
Route::get('/checkout/cancel', [CartController::class, 'cancel'])->name('checkout.cancel');

// Rutas para el Configurador PC
Route::get('/shop', [ConfiguradorPCController::class, 'shop'])->name('shop');
Route::get('/configuradorpc', [ConfiguradorPCController::class, 'index'])->name('configuradorpc.index');
Route::post('/configuradorpc/add', [ConfiguradorPCController::class, 'add'])->name('configuradorpc.add');
Route::post('/configuradorpc/addAll', [ConfiguradorPCController::class, 'addAll'])->name('configuradorpc.addAll');
Route::post('/configuradorpc/remove', [ConfiguradorPCController::class, 'remove'])->name('configuradorpc.remove');
Route::post('/configuradorpc/removeAll', [ConfiguradorPCController::class, 'removeAll'])->name('configuradorpc.removeAll');
//Route::post('/logout', [ConfiguradorPCController::class, 'logout'])->name('logout');
