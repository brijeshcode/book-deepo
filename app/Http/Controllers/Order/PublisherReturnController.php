<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Orders\PublisherChallan;
use App\Models\Orders\PublisherOrderReturn;
use App\Models\Orders\PublisherOrderReturnItem;
use Illuminate\Support\Facades\Storage;
use App\Models\Setup\Publisher;
use Illuminate\Http\Request;
use App\Models\Setup\Book;
use Inertia\Inertia;

class PublisherReturnController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['can:access {{ auth }}'])->except(['locations','warehouses','suppliers','publishers']);
        // $this->middleware(['can:create {{ auth }}'])->only(['create', 'store']);
        // $this->middleware(['can:edit {{ auth }}'])->only(['edit', 'update']);
    }

    public function index(Request $request)
    {
        $returns = PublisherOrderReturn::with('publisher:id,name')
                ->when($request->quantity, function ($query, $quantity){
                    $query->where('quantity', $quantity);
                })
                ->when($request->publisher_order_id, function ($query, $publisher_order_id){
                    $query->where('publisher_order_id', $publisher_order_id);
                })
                ->when($request->publisher_id, function ($query, $publisher_id){
                    $query->where('publisher_id', $publisher_id);
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
        $publishers = Publisher::select('id', 'name')->whereActive(1)->has('returns')->get();
        return Inertia::render('Order/Publishers/ReturnIndex', compact('returns', 'publishers'));
    }

    public function store(Request $request)
    {
        $publisherReturn = PublisherOrderReturn::where('publisher_order_id', $request->publisher_order_id)->where('publisher_id', $request->publisher_id)->first();
        // dd($publisherReturn);
        if (!is_null($publisherReturn)) {
            $this->update($request, $publisherReturn);
            return redirect(route('school.order.index'))->with('type', 'success')->with('message', 'Return save successfully !!');
        }
        \DB::transaction(function() use ($request) {
            $publisherReturn = PublisherOrderReturn::create($request->only('date', 'publisher_id', 'publisher_order_id','quantity', 'amount', 'note'));

            $publisherReturn->items()->createMany($request->items);

            foreach ($request->items as $key => $item) {
                $this->updateBookQuantity($item['book_id'], $item['quantity']);
            }

            $challans = $request->challans;
            foreach ($challans as $key => $challan) {
                $challans[$key]['path'] = $this->uploadReturnChallans($challan['path'], $request->publisher_id);
            }
            $publisherReturn->challans()->createMany($challans);

        });

        return redirect(route('school.order.index'))->with('type', 'success')->with('message', 'Return save successfully !!');

    }

    public function update($request, PublisherOrderReturn $returns)
    {
        \DB::transaction(function() use ($request, $returns) {
            $returns->update($request->only('date', 'quantity', 'amount', 'note'));

            foreach ($request->items as $key => $item) {
                // dd($item);
                $publiserReturnItem = PublisherOrderReturnItem::where('publisher_order_item_id', $item['publisher_order_item_id'])->first();
                // dd($publiserReturnItem);
                $this->updateBookQuantity($item['book_id'], $publiserReturnItem->quantity, $item['quantity']);
                $publiserReturnItem->quantity = $item['quantity'];
                $publiserReturnItem->price = $item['price'];
                $publiserReturnItem->save();
            }

            $challans = $request->challans;
            foreach ($challans as $key => $challan) {
                if (isset($challan['id'])) {
                    $publisherChallan = PublisherChallan::where('id', $challan['id'])->first();
                    $publisherChallan->date = $challan['date'];
                    $publisherChallan->challan_no = $challan['challan_no'];
                    $publisherChallan->amount = $challan['amount'];
                    $publisherChallan->path = $this->uploadReturnChallans($challan['path'], $returns->publisher_id);
                    $publisherChallan->note = $challan['note'];
                    $publisherChallan->challan_type = $challan['challan_type'];
                    $publisherChallan->save();
                    unset($challans[$key]);
                }
            }

            if (count($challans) > 0) {
                foreach ($challans as $key => $challan) {
                    $challans[$key]['path'] = $this->uploadReturnChallans($challan['path'], $returns->publisher_id);
                }
                $returns->challans()->createMany($challans);
            }
        });

    }

    public function updateBookQuantity($bookId, $newQty, $oldQty = 0)
    {
        $book = Book::whereId($bookId)->first();
        $book->quantity -= $newQty + $oldQty;
        $book->save();
    }

    public function uploadReturnChallans($challanPath, $publisherId)
    {
        if(gettype($challanPath) == 'string' || is_null($challanPath)){
            return $challanPath;
        }
        $now = now();
        $imageName = $publisherId . '_' .time().'.'.$challanPath->extension();
        $location = 'Challans/Publisher/Return/'. $now->year. '/'. $now->format('m');
        return Storage::url($challanPath->storeAs($location, $imageName, 'public'));
    }
}
