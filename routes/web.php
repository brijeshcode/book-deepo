<?php

use App\Http\Controllers\Logs\SchoolOrderEmailLogController;
use App\Http\Controllers\Order\PublisherDeliveryController;
use App\Http\Controllers\Order\PublisherOrderController;
use App\Http\Controllers\Order\PublisherPaymentController;
use App\Http\Controllers\Order\PublisherReturnController;
use App\Http\Controllers\Order\SaleController;
use App\Http\Controllers\Order\SampleController;
use App\Http\Controllers\Order\SchoolOrderController;
use App\Http\Controllers\Order\SupplierDeliveryController;
use App\Http\Controllers\Order\SupplierOrderController;
use App\Http\Controllers\Order\SupplierPaymentController;
use App\Http\Controllers\Order\SupplierReturnController;
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
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/order/recived/confirmation/{order}/{type}', function(Request $request, $order, $type){
        if ($type == 'Publisher') {
            PublisherOrder::whereId($order)->update(['order_recived_confirmation' => 1]);
        }else{
            SupplierOrder::whereId($order)->update(['order_recived_confirmation' => 1]);
        }
        echo "Order Recirve Confirmed !! Thank you";
})->name('orderRecived')->middleware('signed');


Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->hasRole('Operator')) {
            // echo 'operator';
            // return $schools = $user->schools()->count;
            $schools = $user->schools()->count();
            $sales = Sale::where('user_id' , $user->id)->count();
            $totalSale = Sale::where('user_id' , $user->id)->sum('total_amount');

            return Inertia::render('OperatorDashboard', compact('schools', 'sales', 'totalSale'));

        }else{
            // dd($user->roles[0]->name);
            $schools = School::count();
            $warehouses = Warehouse::count();
            $books = Book::count();
            $schoolOrders = SchoolOrder::count();
            $supplierOrders = SupplierOrder::count();
            $sales = Sale::count();
            $bundles = Bundle::count();
            $publisherOrders = PublisherOrder::count();

            return Inertia::render('Dashboard', compact('schools', 'warehouses', 'books', 'schoolOrders', 'bundles', 'supplierOrders', 'publisherOrders', 'sales'));
        }
    })->name('dashboard');

    Route::get('/get/locations', [LocationsController::class, 'locations'])->name('locations.list');
    Route::resource('/locations', LocationsController::class)->except(['destroy']);

    Route::resource('/warehouses', WarehouseController::class)->except(['destroy']);

    Route::resource('schools', SchoolController::class)->except(['destroy']);
    Route::get('/school/{school}/books', [SchoolController::class, 'bookList'])->name('schools.books');
    Route::get('/school/{school}/books/show', [SchoolController::class, 'books'])->name('schools.books.show');
    Route::get('/school/{school}/bundles', [SchoolController::class, 'bundleList'])->name('schools.bundles');


    // check stock in given school by book list
    Route::post('/school/{school}/check-stock', [SchoolController::class, 'checkStock'])->name('school.checkStock');
    Route::get('/school/{school}/get-stock', [SchoolController::class, 'getStock'])->name('school.getStock');


    Route::get('books/list', [BookController::class , 'list'])->name('books.list');
    Route::resource('books', BookController::class)->except(['destroy']);



    Route::get('publishers/{publisher}/books/', [PublisherController::class , 'books'])->name('publishers.books');
    Route::resource('publishers', PublisherController::class)->except(['destroy']);
    Route::controller(PublisherOrderController::class)->prefix('/publisher/order')->name('publisher.order.')->group(function () {

        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{order}/edit', 'edit')->name('edit');
        Route::get('/{order}/show', 'show')->name('show');
        Route::put('/{order}', 'update')->name('update');

        Route::delete('/item/{item}/delete', 'deleteItem')->name('item.delete');
        Route::get('/{order}/delivery', 'delivery')->name('delivery');
        Route::get('/returns', 'returnIndex')->name('returns.index');
    });
    Route::controller(PublisherDeliveryController::class)->prefix('/publisher/deliveries')->name('publisher.delivery.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/{delivery}/show', 'show')->name('show');
    });
    Route::controller(PublisherReturnController::class)->prefix('/publisher/returns')->name('publisher.return.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
    });

    Route::controller(PublisherPaymentController::class)->prefix('/publisher/payments')->name('publisher.payments.')
        ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{publisherOrder}/order','create')->name('create');
        Route::post('/','store')->name('store');
    });


    Route::get('/supplier/{supplier}/books/', [SupplierController::class, 'books'])->name('suppliers.books');
    Route::resource('suppliers', SupplierController::class)->except(['destroy']);

    Route::controller(SupplierOrderController::class)->prefix('/supplier/order')->name('supplier.order.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('', 'store')->name('store');
        Route::get('/{order}/edit', 'edit')->name('edit');
        Route::get('/{order}/show', 'show')->name('show');
        Route::delete('/item/{item}/delete', 'deleteItem')->name('item.delete');
        Route::get('/{order}/delivery', 'delivery')->name('delivery'); // un-used

    });

    // new route
    Route::controller(SupplierDeliveryController::class)->prefix('/supplier/delivery')->name('supplier.delivery.')->group(function () {
        /*Route::get('/deliveries', 'index')->name('supplier.delivery.index');
        Route::get('/deliveries', 'create')->name('supplier.delivery.create');
        Route::get('/{order}/delivery', 'delivery')->name('delivery');*/
        Route::post('/', 'store')->name('store');
        Route::get('/', 'index')->name('index');
        Route::get('/{delivery}/show', 'show')->name('show');

    });
    Route::controller(SupplierReturnController::class)->prefix('/supplier/returns')->name('supplier.return.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
    });
    Route::get('/supplier/order/returns/{return}', [SupplierOrderController::class, 'returnShow'])->name('supplier.returns.show');


    Route::controller(SchoolOrderController::class)->prefix('/school/orders')->name('school.order.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{order}/edit', 'edit')->name('edit');
        Route::get('/{order}/show', 'show')->name('show');
        Route::put('/{order}', 'update')->name('update');

        Route::delete('/item/{item}/delete', 'deleteItem')->name('item.delete');

        Route::get('/{order}/delivery', 'createSchoolDelivery')->name('delivery');
        Route::get('/{order}/return', 'createReturn')->name('return');
        // Route::post('/delivery', 'storeDelivery')->name('delivery.store');
        Route::post('/return', 'storeReturn')->name('return.store');
    });


    Route::get('/school/orders/{order_id}/email-notification', [SchoolOrderEmailLogController::class, 'create'])->name('school.order.manual_email_notification');
    Route::post('/school/orders/{order_id}/email-notification', [SchoolOrderEmailLogController::class, 'store'])->name('school.order.manual_email_notification.store');


    Route::get('/warehouse/{warehouse_id}/schools', [WarehouseController::class, 'schools'])->name('warehouse.schools');
    Route::get('/location/{location_id}/warehouses', [LocationsController::class, 'warehouses'])->name('location.warehouses');
    Route::get('/location/{location_id}/suppliers', [LocationsController::class, 'suppliers'])->name('location.suppliers');
    Route::get('/location/{location_id}/publishers', [LocationsController::class, 'publishers'])->name('location.publishers');

    Route::resource('/bundles', BundleController::class)->except(['destroy']);

    Route::resource('/sales', SaleController::class)->except(['destroy']);
    Route::controller(SaleController::class)->prefix('/sales')->name('sales.')->group(function () {
        Route::post('/{sale}/cancel', 'cancel')->name('cancel');
        Route::get('/{sale}/invoice/save','saveInvoice')->name('invoice.save');
        Route::get('/{sale}/invoice/print', 'printInvoice')->name('invoice.print');
    });



    Route::controller(SupplierPaymentController::class)->prefix('/supplier/payments')->name('supplier.payments.')
        ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{supplierOrder}/order','create')->name('create');
        Route::post('/','store')->name('store');
        // Route::put('/','update')->name('update');
        // Route::get('/{patyment}','show')->name('show');
    });

    Route::resource('/users', UsersController::class)->except(['destroy', 'show']);
    Route::resource('/roles', RolesController::class)->except(['destroy', 'show']);
    Route::resource('/samples', SampleController::class)->except(['destroy']);

    // Route::get('/supplier/challan/{challan}', [SupplierPaymentController::class, 'showChallan'])->name('supplier.payments.challan.show');

});