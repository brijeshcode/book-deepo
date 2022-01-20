<?php

namespace App\Http\Controllers\Logs;

use App\Http\Controllers\Controller;
use App\Models\Notifications\SchoolEmailLog;
use App\Models\Orders\SchoolOrder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SchoolOrderEmailLogController extends Controller
{

    public function create(Request $request, $order_id)
    {
        $order = SchoolOrder::with('items', 'items.supplier','items.publisher' , 'school:id,name,email,contact_person', 'items.book')
            ->where('id',$order_id)->first();
        $mailData = [];

        $mailData[$order->school->email] =[
            'reciver_id' => $order->school_id,
            'reciver_type' => 'School',
            'reciver_email' => $order->school->email,
            'reciver_name' => $order->school->name . ' ('. $order->school->contact_person . ')'
        ];

        foreach ($order->items as $key => $item) {

            $deliveryBy = $item->order_to == 'Supplier' ? $item->supplier_id : $item->publisher_id;
            $reciverEmail = $item->order_to == 'Supplier' ? $item->supplier->email : $item->publisher->email;
            $recivername = $item->order_to == 'Supplier' ? $item->supplier->name : $item->publisher->name;

            $mailData[$reciverEmail]['reciver_id'] = $deliveryBy ;
            $mailData[$reciverEmail]['reciver_type'] = $item->order_to;
            $mailData[$reciverEmail]['reciver_email'] = $reciverEmail ;
            $mailData[$reciverEmail]['reciver_name'] = $recivername ;
        }
        // return $mailData;
        return Inertia::render('Order/Schools/ManualNotification', compact('mailData', 'order'));
    }

    public function store(Request $request, $order_id)
    {
        $request->validate(
            [
                'reciver_email' => 'required',
                'body' => 'required',
                'subject' => 'required'
            ],
            [
                'reciver_email.required' => 'Recivier is required.',
                'body.required' => "Body is required",
                'subject.required' => "Subject is required"
            ]
        );
        SchoolEmailLog::create($request->all());

        return redirect(route('schoolOrder.show', $order_id))->with('type', 'success')->with('message', 'Notification send successfully');
    }

    public function junk(Request $request, $order_id)
    {
        $order = SchoolOrder::with('items', 'items.supplier','items.publisher' , 'school:id,email,contact_person', 'items.book')
            ->where('id',$order_id)->first();
        $mailData = [];

        foreach ($order->items as $key => $item) {

            $deliveryBy = $item->order_to == 'Supplier' ? $item->supplier_id : $item->publisher_id;

            if ($item->order_to == 'Supplier') {
                $mailData[$item->order_to][$deliveryBy]['reciver_email'] = $item->supplier->email ;
                $mailData[$item->order_to][$deliveryBy]['reciver_name'] = $item->supplier->name ;
            }else{
                $mailData[$item->order_to][$deliveryBy]['reciver_email'] = $item->publisher->email ;
                $mailData[$item->order_to][$deliveryBy]['reciver_name'] = $item->publisher->name ;

            }


            $mailData[$item->order_to][$deliveryBy]['reciver_type'] = $item->order_to;
            $mailData[$item->order_to][$deliveryBy]['book'] =  $item->book->name;
            $mailData[$item->order_to][$deliveryBy]['subject'] =  $item->book->subject;
            $mailData[$item->order_to][$deliveryBy]['class'] =  $item->book->class;
            $mailData[$item->order_to][$deliveryBy]['quantity'] =  $item->quantity;

            if (isset($mailData[$item->order_to][$deliveryBy]['quantity'])) {
                $mailData[$item->order_to][$deliveryBy]['quantity'] +=  $item->quantity;
            }else{
                $mailData[$item->order_to][$deliveryBy]['quantity'] =  $item->quantity;
            }

            if (isset($mailData[$item->order_to][$deliveryBy]['recived_quantity'])) {
                $mailData[$item->order_to][$deliveryBy]['recived_quantity'] +=  $item->recived_quantity;
            }else{
                $mailData[$item->order_to][$deliveryBy]['recived_quantity'] =  $item->recived_quantity;
            }


        }
        return $mailData;
        return Inertia::render('Order/Schools/ManualNotification', compact('mailData', 'order'));
    }
}
