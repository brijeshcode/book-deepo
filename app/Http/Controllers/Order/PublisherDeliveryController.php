<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Orders\PublisherChallan;
use App\Models\Orders\PublisherOrder;
use App\Models\Orders\PublisherOrderDelivery;
use App\Models\Orders\PublisherOrderDeliveryItem;
use App\Models\Orders\PublisherOrderItem;
use App\Models\Orders\SchoolOrder;
use App\Models\Orders\SchoolOrderItem;
use App\Models\Setup\Book;
use App\Models\Setup\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PublisherDeliveryController extends Controller
{
    public function index(Request $request)
    {
        $deliveries = PublisherOrderDelivery::with('publisher:id,name' , 'items')
                ->when($request->quantity, function ($query, $quantity){
                    $query->where('quantity',  '='  , $quantity);
                })
                ->when($request->amount, function ($query, $amount){
                    $query->where('amount',  '='  , $amount);
                })
                ->when($request->publisher_id, function ($query, $publisher_id){
                    $query->where('publisher_id',  '='  , $publisher_id);
                })
                ->when($request->from_date, function ($query, $from_date){
                    $query->where('date',  '>=' , $from_date);
                })
                ->when($request->to_date, function ($query, $to_date){
                    $query->where('date',  '<='  , $to_date);
                })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();
        $publishers = Publisher::select('id', 'name')->whereActive(1)->has('deliveries')->get();
        return Inertia::render('Order/Publishers/Deliveries/Index', compact('deliveries', 'publishers'));
    }
    public function store(Request $request)
    {
        // dd($request->challans);
        // check if update or store
        $delivery = PublisherOrderDelivery::where('publisher_order_id', $request->publisher_order_id)->where('publisher_id' , $request->publisher_id)->first();
        if (!is_null($delivery)) {
            $this->update($request, $delivery);
            return redirect(route('school.order.index'))->with('type', 'success')->with('message', 'Delivey save successfully !!');
        }


        // dd('publisher store');

        // Tasks
        // 1. Insert publisher delivery
        // 2. insert publisher delivery items
        // 3. update publisher order items recived quantity
        // 4. update school order items recived quantity
        // 5. update book quantity

        // $this->validateFull($request);

        \DB::transaction(function() use ($request) {
            $challans = $request->challans;
            foreach ($challans as $key => $challan) {
                $challans[$key]['path'] = $this->uploadChallans($challan['path']);
            }

            // dd($request);
            // 1.& 2  Insert publisher delivery &&  insert publisher delivery items
            $publisherOrder = PublisherOrderDelivery::create($request->only('date', 'publisher_id', 'school_id', 'publisher_order_id', 'school_order_id',  'quantity', 'discount_percent', 'discount', 'sub_total', 'total_amount','note'));

            $publisherOrder->items()->createMany($request->items);

            $challans = $request->challans;
            foreach ($challans as $key => $challan) {
                $challans[$key]['path'] = $this->uploadChallans($challan['path']);
            }
            $publisherOrder->challans()->createMany($challans);


            $schoolOrder = SchoolOrder::where( 'id', $request->school_order_id)->first();
            $schoolOrder->status = $schoolOrder->quantity ==  $request->quantity  ? 'Completed' : 'Partial';
            $schoolOrder->save();

            foreach ($request->items as $key => $item) {
                // 3. update publisher order items recived quantity
                // 4. update school order items recived quantity
                // 5. update book quantity
                $this->updatePubliserOrderItemQuantity($item['publisher_order_item_id'], $item['quantity']);
            }
        });

        return redirect(route('school.order.index'))->with('type', 'success')->with('message', 'Delivey save successfully !!');
    }

    public function update(Request $request, PublisherOrderDelivery $delivery)
    {
        \DB::transaction(function() use ($request, $delivery) {
            $delivery->update($request->only('quantity', 'discount_percent', 'discount', 'sub_total', 'total_amount','note'));
            foreach ($request->items as $key => $item) {
                $this->updatePubliserOrderItemQuantity($item['publisher_order_item_id'], $item['quantity']);

                $publisherItem = PublisherOrderDeliveryItem::where('publisher_order_item_id', $item['publisher_order_item_id'])->first();
                $publisherItem->quantity = $item['quantity'];
                $publisherItem->unit_price = $item['unit_price'];
                $publisherItem->discount_percent = $item['discount_percent'];
                $publisherItem->discount_total = $item['discount_total'];
                $publisherItem->price_total = $item['price_total'];
                $publisherItem->save();
            }

            $challans = $request->challans;

            foreach ($challans as $key => $challan) {
                if (isset($challan['id'])) {
                    $publisherChallan = PublisherChallan::where('id', $challan['id'])->first();
                    $publisherChallan->date = $challan['date'];
                    $publisherChallan->challan_no = $challan['challan_no'];
                    $publisherChallan->amount = $challan['amount'];
                    $publisherChallan->path = $this->uploadChallans($challan['path']);
                    $publisherChallan->note = $challan['note'];
                    $publisherChallan->save();
                    unset($challans[$key]);
                }
            }

            if (count($challans) > 0) {
                foreach ($challans as $key => $challan) {
                    $challans[$key]['path'] = $this->uploadChallans($challan['path']);
                }
                $delivery->challans()->createMany($challans);
            }
        });
        return redirect(route('school.order.index'))->with('type', 'success')->with('message', 'Delivey save successfully !!');

    }

    // 3. update publisher order items recived quantity
    public function updatePubliserOrderItemQuantity($publisherItemId, $quantity)
    {
        $publisherItem = PublisherOrderItem::whereId($publisherItemId)->first();

        $this->updateBookQuantity($publisherItem->book_id, $quantity, $publisherItem->quantity_recived);
        $this->updateSchoolOrderItemQuantity($publisherItem->school_order_item_id, $quantity);

        $publisherItem->quantity_recived = $quantity;
        $publisherItem->save();
    }

    public function updateBookQuantity($bookId,$newQty, $oldQty = 0 )
    {
        $book = Book::where('id', $bookId)->first();
        $book->quantity +=  $newQty - $oldQty;
        $book->save();
    }

    // 4. update school order items recived quantity
    public function updateSchoolOrderItemQuantity($schoolOrderItemId, $recivedQuantity)
    {
        $schoolItem = SchoolOrderItem::whereId($schoolOrderItemId)->first();
        $schoolItem->recived_quantity = $recivedQuantity;
        $schoolItem->save();
    }

    public function uploadChallans($challanPath)
    {
        if(gettype($challanPath) == 'string' || is_null($challanPath)){
            return $challanPath;
        }
        $now = now();
        $imageName = time().'.'.$challanPath->extension();
        $location = 'Challans/Publisher/'. $now->year. '/'. $now->format('m');
        return Storage::url($challanPath->storeAs($location, $imageName, 'public'));

    }

}
