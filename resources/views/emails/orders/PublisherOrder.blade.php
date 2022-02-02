@component('mail::message')
# Order Number: {{ $order->id }}

# School Order Number : {{ $order->school_order_id }}
Hi {{ $order->publisher->name }},

	Here is the list of items for new order,
	please go through and update us the availability of these books.

# Order Items
<br/>
@component('mail::table')
| Book          | Publisher     | Quantity |
| ------------- |:-------------:| --------:|
@foreach ($order->items as $item)
| {{ $item->book->name }} <br> Class: {{ $item->book->class }} <br> Subject: {{ $item->book->subject }} | {{ $item->book->publisher->name }}      | {{ $item->quantity }}      |
@endforeach

@endcomponent
@component('mail::button', ['url' => $url])
Recive Confirmation
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
