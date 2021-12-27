<?php

use App\Http\Controllers\Order\PublisherOrderController;
use App\Http\Controllers\Order\PurchaseOrderController;
use App\Http\Controllers\Setup\BookController;
use App\Http\Controllers\Setup\LocationsController;
use App\Http\Controllers\Setup\PublisherController;
use App\Http\Controllers\Setup\SchoolController;
use App\Http\Controllers\Setup\SupplierController;
use App\Http\Controllers\Setup\WarehouseController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

/*Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');*/

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/setup/locations', [LocationsController::class, 'index'])->name('locations');
    Route::get('/setup/locations/create', [LocationsController::class, 'create'])->name('locations.create');
    Route::post('/setup/locations', [LocationsController::class, 'store'])->name('locations.store');
    Route::get('/setup/locations/{location}/edit', [LocationsController::class, 'edit'])->name('locations.edit');
    Route::put('/setup/locations/{location}', [LocationsController::class, 'update'])->name('locations.update');

    Route::get('/setup/schools', [SchoolController::class, 'index'])->name('schools');
    Route::get('/setup/schools/create', [SchoolController::class, 'create'])->name('schools.create');
    Route::post('/setup/schools', [SchoolController::class, 'store'])->name('schools.store');
    Route::get('/setup/schools/{school}/edit', [SchoolController::class, 'edit'])->name('schools.edit');
    Route::put('/setup/schools/{school}', [SchoolController::class, 'update'])->name('schools.update');

    Route::get('/setup/warehouses', [WarehouseController::class, 'index'])->name('warehouses');
    Route::get('/setup/warehouses/create', [WarehouseController::class, 'create'])->name('warehouses.create');
    Route::post('/setup/warehouses', [WarehouseController::class, 'store'])->name('warehouses.store');
    Route::get('/setup/warehouses/{warehouse}/edit', [WarehouseController::class, 'edit'])->name('warehouses.edit');
    Route::put('/setup/warehouses/{warehouse}', [WarehouseController::class, 'update'])->name('warehouses.update');

    Route::get('/setup/suppliers', [SupplierController::class, 'index'])->name('suppliers');
    Route::get('/setup/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
    Route::post('/setup/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::get('/setup/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
    Route::put('/setup/suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');

    Route::get('/setup/books', [BookController::class, 'index'])->name('books');
    Route::get('/setup/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/setup/books', [BookController::class, 'store'])->name('books.store');
    Route::get('/setup/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/setup/books/{book}', [BookController::class, 'update'])->name('books.update');

    Route::get('/setup/publishers', [PublisherController::class, 'index'])->name('publishers');
    Route::get('/setup/publishers/create', [PublisherController::class, 'create'])->name('publishers.create');
    Route::post('/setup/publishers', [PublisherController::class, 'store'])->name('publishers.store');
    Route::get('/setup/publishers/{publisher}/edit', [PublisherController::class, 'edit'])->name('publishers.edit');
    Route::put('/setup/publishers/{publisher}', [PublisherController::class, 'update'])->name('publishers.update');
    Route::get('/publishers/{publisher}/books/', [PublisherController::class, 'books'])->name('publishers.books');


    Route::get('/publisher/orders', [PublisherOrderController::class, 'index'])->name('publishersOrder');
    Route::get('/publisher/orders/create', [PublisherOrderController::class, 'create'])->name('publishersOrder.create');
    Route::post('/publisher/orders', [PublisherOrderController::class, 'store'])->name('publishersOrder.store');
    Route::get('/publisher/orders/{order}/edit', [PublisherOrderController::class, 'edit'])->name('publishersOrder.edit');
    Route::put('/publisher/orders/{order}', [PublisherOrderController::class, 'update'])->name('publishersOrder.update');
    Route::delete('/publisher/order/item/{item}/delete', [PublisherOrderController::class, 'deleteItem'])->name('publisherOrderItem.delete');

    /*Route::get('/order/supplier', [SupplierOrderController::class, 'index'])->name('publishersOrder');
    Route::get('/order/supplier/create', [SupplierOrderController::class, 'create'])->name('publishersOrder.create');
    Route::post('/order/supplier', [SupplierOrderController::class, 'store'])->name('publishersOrder.store');
    Route::get('/order/supplier/{publisher}/edit', [SupplierOrderController::class, 'edit'])->name('publishersOrder.edit');
    Route::put('/order/supplier/{publisher}', [SupplierOrderController::class, 'update'])->name('publishersOrder.update');*/


});