<?php

use App\Http\Controllers\Logs\SchoolOrderEmailLogController;
use App\Http\Controllers\Order\PublisherOrderController;
use App\Http\Controllers\Order\PurchaseOrderController;
use App\Http\Controllers\Order\SaleController;
use App\Http\Controllers\Order\SchoolOrderController;
use App\Http\Controllers\Order\SupplierOrderController;
use App\Http\Controllers\Setup\BookController;
use App\Http\Controllers\Setup\BundleController;
use App\Http\Controllers\Setup\LocationsController;
use App\Http\Controllers\Setup\PublisherController;
use App\Http\Controllers\Setup\RolesController;
use App\Http\Controllers\Setup\SchoolController;
use App\Http\Controllers\Setup\SupplierController;
use App\Http\Controllers\Setup\UsersController;
use App\Http\Controllers\Setup\WarehouseController;
use App\Models\Orders\PublisherOrder;
use App\Models\Orders\Sale;
use App\Models\Orders\SchoolOrder;
use App\Models\Orders\SupplierOrder;
use App\Models\Setup\Book;
use App\Models\Setup\Bundle;
use App\Models\Setup\School;
use App\Models\Setup\Warehouse;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/order/recived/confirmation/{order}/{type}', function(Request $request){
    if (! $request->hasValidSignature()) {
        abort(401);
    }else{
        echo 'Order recived confirmed';
    }
})->name('orderRecived');
/*Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');*/

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $schools = School::count();
        $warehouses = Warehouse::count();
        $books = Book::count();
        $schoolOrders = SchoolOrder::count();
        $supplierOrders = SupplierOrder::count();
        $sales = Sale::count();
        $bundles = Bundle::count();
        $publisherOrders = PublisherOrder::count();

        return Inertia::render('Dashboard', compact('schools', 'warehouses', 'books', 'schoolOrders', 'bundles', 'supplierOrders', 'publisherOrders', 'sales'));
    })->name('dashboard');

    Route::get('/locations', [LocationsController::class, 'index'])->name('locations')->middleware('can:access locations');
    Route::get('/locations/create', [LocationsController::class, 'create'])->name('locations.create')->middleware('can:create locations');
    Route::post('/locations', [LocationsController::class, 'store'])->name('locations.store')->middleware('can:create locations');

    Route::get('/locations/{location}/edit', [LocationsController::class, 'edit'])->name('locations.edit')->middleware('can:edit locations');

    Route::put('/locations/{location}', [LocationsController::class, 'update'])->name('locations.update')->middleware('can:create locations');
    Route::get('/get/locations', [LocationsController::class, 'locations'])->name('locations.list');

    Route::get('/warehouses', [WarehouseController::class, 'index'])->name('warehouses');
    Route::get('/warehouses/create', [WarehouseController::class, 'create'])->name('warehouses.create');
    Route::post('/warehouses', [WarehouseController::class, 'store'])->name('warehouses.store');
    Route::get('/warehouses/{warehouse}/edit', [WarehouseController::class, 'edit'])->name('warehouses.edit');
    Route::put('/warehouses/{warehouse}', [WarehouseController::class, 'update'])->name('warehouses.update');


    Route::get('/schools', [SchoolController::class, 'index'])->name('schools');
    Route::get('/schools/create', [SchoolController::class, 'create'])->name('schools.create');
    Route::post('/schools', [SchoolController::class, 'store'])->name('schools.store');
    Route::get('/schools/{school}/edit', [SchoolController::class, 'edit'])->name('schools.edit');
    Route::put('/schools/{school}', [SchoolController::class, 'update'])->name('schools.update');

    Route::get('/school/{school}/books/show', [SchoolController::class, 'books'])->name('schools.books.show');
    Route::get('/school/{school}/books', [SchoolController::class, 'bookList'])->name('schools.books');
    Route::get('/school/{school}/bundles', [SchoolController::class, 'bundleList'])->name('schools.bundles');


    // check stock in given school by book list
    Route::post('/school/{school}/check-stock', [SchoolController::class, 'checkStock'])->name('school.checkStock');
    Route::get('/school/{school}/get-stock', [SchoolController::class, 'getStock'])->name('school.getStock');


    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers');
    Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
    Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::get('/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
    Route::put('/suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
    Route::get('/supplier/{supplier}/books/', [SupplierController::class, 'books'])->name('suppliers.books');



    Route::get('/books', [BookController::class, 'index'])->name('books');
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
    Route::get('/books/list', [BookController::class, 'list'])->name('books.list');



    Route::get('/publishers', [PublisherController::class, 'index'])->name('publishers');
    Route::get('/publishers/create', [PublisherController::class, 'create'])->name('publishers.create');
    Route::post('/publishers', [PublisherController::class, 'store'])->name('publishers.store');
    Route::get('/publishers/{publisher}/edit', [PublisherController::class, 'edit'])->name('publishers.edit');
    Route::put('/publishers/{publisher}', [PublisherController::class, 'update'])->name('publishers.update');
    Route::get('/publishers/{publisher}/books/', [PublisherController::class, 'books'])->name('publishers.books');



    Route::get('/publisher/orders', [PublisherOrderController::class, 'index'])->name('publisher.order');
    Route::get('/publisher/order/create', [PublisherOrderController::class, 'create'])->name('publisher.order.create');
    Route::post('/publisher/order', [PublisherOrderController::class, 'store'])->name('publisher.order.store');
    Route::get('/publisher/order/{order}/edit', [PublisherOrderController::class, 'edit'])->name('publisher.order.edit');
    Route::get('/publisher/order/{order}/show', [PublisherOrderController::class, 'show'])->name('publisher.order.show');
    Route::put('/publisher/order/{order}', [PublisherOrderController::class, 'update'])->name('publisher.order.update');
    Route::delete('/publisher/order/item/{item}/delete', [PublisherOrderController::class, 'deleteItem'])->name('publisherOrderItem.delete');

    Route::get('/publisher/orders/{order}/delivery', [PublisherOrderController::class, 'delivery'])->name('publisher.order.delivery');

    Route::get('/publisher/order/deliveries', [PublisherOrderController::class, 'deliveryIndex'])->name('publisher.delivery.index');
    Route::get('/publisher/order/returns', [PublisherOrderController::class, 'returnIndex'])->name('publisher.returns.index');

    Route::get('/supplier/orders', [SupplierOrderController::class, 'index'])->name('supplierOrder');
    Route::get('/supplier/order/create', [SupplierOrderController::class, 'create'])->name('supplierOrder.create');
    Route::post('/supplier/order', [SupplierOrderController::class, 'store'])->name('supplierOrder.store');
    Route::get('/supplier/order/{order}/edit', [SupplierOrderController::class, 'edit'])->name('supplierOrder.edit');
    // Route::put('/supplier/order/{order}', [SupplierOrderController::class, 'update'])->name('supplierOrder.update');
    Route::delete('/supplier/orde/item/{item}/delete', [SupplierOrderController::class, 'deleteItem'])->name('supplierOrderItem.delete');
    Route::get('/supplier/orders/{order}/delivery', [SupplierOrderController::class, 'delivery'])->name('supplier.order.delivery');
    Route::get('/supplier/order/deliveries', [SupplierOrderController::class, 'deliveryIndex'])->name('supplier.delivery.index');

    Route::get('/supplier/order/returns', [SupplierOrderController::class, 'returnIndex'])->name('supplier.returns.index');
    Route::get('/supplier/order/returns/{return}', [SupplierOrderController::class, 'returnShow'])->name('supplier.returns.show');


    Route::get('/school/orders', [SchoolOrderController::class, 'index'])->name('schoolOrder');
    Route::get('/school/orders/create', [SchoolOrderController::class, 'create'])->name('schoolOrder.create');
    Route::post('/school/orders', [SchoolOrderController::class, 'store'])->name('schoolOrder.store');
    Route::get('/school/orders/{order}/edit', [SchoolOrderController::class, 'edit'])->name('schoolOrder.edit');
    Route::get('/school/orders/{order}/show', [SchoolOrderController::class, 'show'])->name('schoolOrder.show');
    Route::put('/school/orders/{order}', [SchoolOrderController::class, 'update'])->name('schoolOrder.update');
    Route::delete('/school/order/item/{item}/delete', [SchoolOrderController::class, 'deleteItem'])->name('schoolOrderItem.delete');

    Route::get('/school/orders/{order}/delivery', [SchoolOrderController::class, 'delivery'])->name('school.order.delivery');
    Route::post('/school/order/delivery', [SchoolOrderController::class, 'storeDelivery'])->name('school.delivery.store');
    Route::get('/school/orders/{order}/return', [SchoolOrderController::class, 'createReturn'])->name('school.order.return');

    Route::post('/school/order/return', [SchoolOrderController::class, 'storeReturn'])->name('school.order.return.store');


    Route::get('/school/orders/{order_id}/email-notification', [SchoolOrderEmailLogController::class, 'create'])->name('school.order.manual_email_notification');
    Route::post('/school/orders/{order_id}/email-notification', [SchoolOrderEmailLogController::class, 'store'])->name('school.order.manual_email_notification.store');



    Route::get('/warehouse/{warehouse_id}/schools', [WarehouseController::class, 'schools'])->name('warehouse.schools');
    Route::get('/location/{location_id}/warehouses', [LocationsController::class, 'warehouses'])->name('location.warehouses');
    Route::get('/location/{location_id}/suppliers', [LocationsController::class, 'suppliers'])->name('location.suppliers');
    Route::get('/location/{location_id}/publishers', [LocationsController::class, 'publishers'])->name('location.publishers');


    Route::get('/bundles', [BundleController::class, 'index'])->name('bundles');
    Route::get('/bundles/create', [BundleController::class, 'create'])->name('bundles.create');
    Route::post('/bundles', [BundleController::class, 'store'])->name('bundles.store');
    Route::get('/bundles/{bundle}/edit', [BundleController::class, 'edit'])->name('bundles.edit');
    Route::put('/bundles/{bundle}', [BundleController::class, 'update'])->name('bundles.update');
    // need to update code for bundle item delete on update if removed from list


    Route::get('/sales', [SaleController::class, 'index'])->name('sales');
    Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
    Route::get('/sales/{sale}/edit', [SaleController::class, 'edit'])->name('sales.edit');
    Route::get('/sales/{sale}/show', [SaleController::class, 'show'])->name('sales.show');
    Route::put('/sales/{sale}', [SaleController::class, 'update'])->name('sales.update');
    Route::delete('/sales/item/{item}/delete', [SaleController::class, 'deleteItem'])->name('sales.Item.delete');


    Route::get('/users', [UsersController::class, 'index'])->name('users');
    Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
    Route::post('/users', [UsersController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
    // Route::get('/users/{user}/show', [UsersController::class, 'show'])->name('users.show');
    Route::put('/users/{user}', [UsersController::class, 'update'])->name('users.update');
    // Route::delete('/users/item/{item}/delete', [UsersController::class, 'deleteItem'])->name('users.Item.delete');

    Route::get('/roles', [RolesController::class, 'index'])->name('roles');
    Route::get('/roles/create', [RolesController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RolesController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}/edit', [RolesController::class, 'edit'])->name('roles.edit');
    // Route::get('/roles/{role}/show', [RolesController::class, 'show'])->name('roles.show');
    Route::put('/roles/{role}', [RolesController::class, 'update'])->name('roles.update');


});