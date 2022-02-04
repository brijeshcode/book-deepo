<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @env ('production')
            <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        @endenv
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
        <link rel="stylesheet" type="text/css" href="https://schoolsoft.test/css/app.css">
         <script src="{{ mix('js/manifest.js') }}" ></script>
        <script src="{{ mix('js/vendor.js') }}" ></script>
        <script src="{{ mix('js/app.js') }}" ></script>
    </head>
    <body class="font-sans antialiased">
       <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-2">
                <!-- Introduction section -->
                <div class="flex flex-row w-full justify-between border-b">
                    <div class="flex-col px-4 py-2">
                        <p class="text-gray-500 mb-4">Created: {{ $sale->date }}</p>
                        <p class="text-gray-700 text-sm uppercase font-bold">
                            Status<br/>
                            <span class="text-green-600 text-xl ">Completed</span>
                        </p>
                    </div>
                    <div class="flex-col text-right px-4 py-2">
                        <p class="text-lg font-bold text-gray-800">#{{ $sale->id }}</p>
                        <p class="text-lg font-bold text-gray-800">{{ $sale->student_name }}</p>
                        <p class="text-gray-500">{{ $sale->student_email }}</p>
                        <p class="text-gray-500">{{ $sale->student_mobile }}</p>
                    </div>
                </div>

                <div class="flex flex-row border-b mb-4">
                    <div class="flex-col p-4 w-1/3 border-r">
                        <h2 class="uppercase font-semibold mb-2" >School Address</h2>
                        <p class="">{{ $sale->school->name }}</p>
                        <p class="text-gray-500 text-sm">{{ $sale->school->address }}</p>
                        <p class="text-gray-500 text-sm">{{ $sale->school->city }}, {{ $sale->school->state }}</p>
                        <p class="text-gray-500 text-sm">{{ $sale->school->pincode }}</p>
                    </div>
                    <div class="flex-col p-4 w-1/3 border-r">
                        <div class="flex">
                            <div>
                                <h2 class="uppercase font-semibold mb-2" ></h2>
                                <p class="">{{ $sale->school->warehouse->name }}</p>
                                <p class="text-gray-500 text-sm">{{ $sale->school->warehouse->address }}</p>
                                <p class="text-gray-500 text-sm">{{ $sale->school->warehouse->city }}, {{ $sale->school->warehouse->state }}</p>
                                <p class="text-gray-500 text-sm">{{ $sale->school->warehouse->pincode }}</p>
                            </div>
                            <div>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p class="text-gray-500 text-sm">{{ $sale->school->warehouse->email }}</p>
                                <p class="text-gray-500 text-sm">{{ $sale->school->warehouse->mobile }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex-col p-4">
                        <h2 class="uppercase font-semibold mb-2" >Order By</h2>
                        <p class="text-gray-500 text-sm">Operator name</p>

                    </div>
                </div>

                <!-- Order Item details section -->
                    <div class="text-xl uppercase px-4 mt-4">
                        Order Items
                        <div class="h-0.5 w-20 bg-gray-500 rounded"></div>
                    </div>

                    <div class="w-full p-4 mb-4">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Publisher</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th class="px-6 py-3 text-left text-normal  text-gray-900 uppercase"></th>
                                    <th class="px-6 py-3 text-left text-normal  text-gray-900 uppercase"></th>
                                    <th class="px-6 py-3 text-left text-normal  text-gray-900 uppercase">{{ $sale->total_quantity }}</th>
                                    <th class="px-6 py-3 text-left text-normal  text-gray-900 uppercase"></th>
                                    <th class="px-6 py-3 text-left text-normal  text-gray-900 uppercase">{{ $sale->total_amount }}</th>
                                </tr>
                            </tfoot>
                            <tbody>
                            	@forelse ($sale->items as $item)
                            		{{-- expr --}}
                                <tr class=" border-b"  >
                                    <td class="px-6 py-2">
                                        <div class="flex ">
                                            <div class="left ">
                                                <div class="text-gray-900 text-lg">{{ $item->book_name }}</div>
                                                <div class="text-gray-500">
                                                    <span class="font-bold text-sm text-gray-700">Class: </span> {{ $item->class }}
                                                </div>
                                                <div class="text-gray-500">
                                                    <span class="font-bold text-sm text-gray-700">Subject: </span> {{ $item->subject }}
                                                </div>
                                            </div>

                                        </div>

                                    </td>
                                    <td class="px-6">{{ $item->book->publisher->name }}</td>
                                    <td class="px-6">{{ $item->quantity }}</td>
                                    <td class="px-6">{{ $item->cost }}</td>
                                    <td class="px-6">{{ $item->cost * $item->quantity }}</td>
                                </tr>
                            	@empty
                            		{{-- empty expr --}}
                            	@endforelse
                            </tbody>

                        </table>
                    </div>

            </div>
        </div>
    </body>
</html>
