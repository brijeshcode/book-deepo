<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Orders\SupplierChallan;
use App\Models\Orders\SupplierOrderReturn;
use App\Models\Orders\SupplierOrderReturnItem;
use Illuminate\Support\Facades\Storage;
use App\Models\Setup\Book;
use App\Models\Setup\Supplier;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SupplierReturnController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['can:access {{ auth }}'])->except(['locations','warehouses','suppliers','suppliers']);
        // $this->middleware(['can:create {{ auth }}'])->only(['create', 'store']);
        // $this->middleware(['can:edit {{ auth }}'])->only(['edit', 'update']);
    }

    public function index(Request $request)
    {
        $returns = SupplierOrderReturn::with('supplier', 'order', 'order.school')
                ->when($request->quantity, function ($query, $quantity){
                    $query->where('quantity',  '='  , $quantity);
                })
                ->when($request->supplier_order_id, function ($query, $supplier_order_id){
                    $query->where('supplier_order_id',  '='  , $supplier_order_id);
                })
                ->when($request->supplier_id, function ($query, $supplier_id){
                    $query->where('supplier_id',  '='  , $supplier_id);
                })
                ->when($request->from_date, function ($query, $from_date){
                    $query->where('date',  '>=' , $from_date);
                })
                ->when($request->to_date, function ($query, $to_date){
                    $query->where('date',  '<='  , $to_date);
                })
                ->when($request->note, function ($query, $note){
                    $query->where('note',  '='  , $note);
                })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();
        $suppliers = Supplier::select('id', 'name')->whereActive(1)->has('returns')->get();
        return Inertia::render('Order/Suppliers/ReturnIndex', compact('returns','suppliers'));
    }


    public function store(Request $request)
    {
        $supplierReturn = SupplierOrderReturn::where('supplier_order_id', $request->supplier_order_id)->where('supplier_id', $request->supplier_id)->first();
        if (!is_null($supplierReturn)) {
            $this->update($request, $supplierReturn);
            return redirect(route('school.order.index'))->with('type', 'success')->with('message', 'Return save successfully !!');
        }

        \DB::transaction(function() use ($request) {
            $supplierReturn = SupplierOrderReturn::create($request->only('date', 'supplier_id', 'supplier_order_id','quantity', 'amount', 'note'));
            $supplierReturn->items()->createMany($request->items);
            foreach ($request->items as $key => $item) {
                $this->updateBookQuantity($item['book_id'], $item['quantity']);
            }

            $challans = $request->challans;
            foreach ($challans as $key => $challan) {
                $challans[$key]['path'] = $this->uploadReturnChallansSupplier($challan['path'],$request->supplier_id);
            }
            $supplierReturn->challans()->createMany($challans);
        });

        return redirect(route('school.order.index'))->with('type', 'success')->with('message', 'Return save successfully !!');

    }

    private function update($request, SupplierOrderReturn $supplierReturn)
    {
        \DB::transaction(function() use ($request, $supplierReturn) {
            $supplierReturn->update($request->only('date', 'quantity', 'amount', 'note'));

            foreach ($request->items as $key => $item) {
                // dd($item);
                $supplierReturnItem = SupplierOrderReturnItem::where('supplier_order_item_id', $item['supplier_order_item_id'])->first();
                // dd($supplierReturnItem);
                $this->updateBookQuantity($item['book_id'], $supplierReturnItem->quantity, $item['quantity']);
                $supplierReturnItem->quantity = $item['quantity'];
                $supplierReturnItem->price = $item['price'];
                $supplierReturnItem->save();
            }

            $challans = $request->challans;
            // dd($challans);
            foreach ($challans as $key => $challan) {
                if (!isset($challan['id'])) { continue; }

                $publisherChallan = SupplierChallan::where('id', $challan['id'])->first();
                $publisherChallan->date = $challan['date'];
                $publisherChallan->challan_no = $challan['challan_no'];
                $publisherChallan->amount = $challan['amount'];
                $publisherChallan->path = $this->uploadReturnChallansSupplier($challan['path'], $supplierReturn->supplier_id);
                $publisherChallan->note = $challan['note'];
                $publisherChallan->challan_type = $challan['challan_type'];
                $publisherChallan->save();
                unset($challans[$key]);
            }

            if (count($challans) > 0) {
                foreach ($challans as $key => $challan) {
                    $challans[$key]['path'] = $this->uploadReturnChallansSupplier($challan['path'], $supplierReturn->supplier_id);
                }
                $supplierReturn->challans()->createMany($challans);
            }
        });

    }

    private function updateBookQuantity($bookId, $newQty, $oldQty = 0)
    {
        $book = Book::whereId($bookId)->first();
        $book->quantity -= $newQty + $oldQty;
        $book->save();
    }

    private function uploadReturnChallansSupplier($challanPath, $supplierId)
    {
        if(gettype($challanPath) == 'string' || is_null($challanPath)){
            return $challanPath;
        }
        $now = now();
        $imageName = $supplierId . '_' .time().'.'.$challanPath->extension();
        $location = 'Challans/Supplier/Return/'. $now->year. '/'. $now->format('m');
        return Storage::url($challanPath->storeAs($location, $imageName, 'public'));

    }
}
