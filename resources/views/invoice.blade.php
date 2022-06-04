<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="flex flex-col space-y-10">
        <div class="flex justify-between">
            <div>
                <div class="uppercase  font-semibold">Bill From</div>
                <div class="flex flex-col">
                    <span>Gharagan address</span>
                </div>
            </div>
            <div>
                <img src="http://via.placeholder.com/200x75?text=Gharagan%20Logo" alt="Gharagan logo" />
            </div>
        </div>

        <br>

        <div class="flex justify-between">
            <div>
                <div class="uppercase  font-semibold">Bill To</div>
                <div class="flex flex-col">
                    <span>{{ $orderDetail->address->address_line1 }}</span>
                    <span>{{ $orderDetail->address->address_line2 }}</span>
                    <span>{{ $orderDetail->address->delivery->region }}</span>
                    <span>{{ $orderDetail->address->telephone }}</span>
                    <span>{{ $orderDetail->address->mobile }}</span>
                </div>
            </div>
            <div class="w-1/3">
                <table class="table-auto w-full">
                    <tbody>
                        <tr>
                            <th class="py-2 text-left">Invoice #</th>
                            <td class="py-2 text-right">{{ $orderDetail->id }}</td>
                        </tr>
                        <tr>
                            <th class="py-2 text-left">Invoice Date</th>
                            <td class="py-2 text-right">
                                {{ date('F d, Y H:i:s', strtotime($orderDetail->created_at)) }}
                            </td>
                        </tr>
                        <tr class="bg-gray-400/50">
                            <th class="py-2 text-left">Amount Due</th>
                            <td class="py-2 text-right">Rs.{{ $orderDetail->total }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        @php
            $getDiscountPercent = function ($discount) {
                return $discount === null ? '-' : $discount->discount_percent . '%';
            };

            $getDiscountedPrice = function ($inventory) {
                if ($inventory->discount === null) {
                    return $inventory->price;
                } else {
                    return $inventory->price - 0.01 * $inventory->price * $inventory->discount->discount_percent;
                }
            };

            $getLineTotal = function ($item) use ($getDiscountedPrice) {
                return $getDiscountedPrice($item->inventory) * $item->quantity;
            };

            $getSubTotal = function ($orderDetail) use ($getLineTotal) {
                $total = 0;
                foreach ($orderDetail->orderItems as $item) {
                    $total += $getLineTotal($item);
                }

                return $total;
            };
        @endphp
        <div>
            <table class="table-auto w-full">
                <thead>
                    <tr class="bg-gray-400/50">
                        <th class="py-2 w-10 text-right">S.N.</th>
                        <th class="py-2 w-max text-left">Item</th>
                        <th class="py-2 w-max text-left">Type</th>
                        <th class="py-2 w-min text-right">Quantity</th>
                        <th class="py-2 w-min text-right">Unit Cost</th>
                        <th class="py-2 w-min text-right">Discount</th>
                        <th class="py-2 w-min text-right">Discounted Price</th>
                        <th class="py-2 w-min text-right">Total</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($orderDetail->orderItems as $item)
                        <tr class="">
                            <th class="py-2 ">{{ $loop->index + 1 }}</th>
                            <td class="py-2 ">{{ $item->product->name }}</td>
                            <td class="py-2 ">{{ $item->inventory->type }}</td>
                            <td class="py-2 text-right">{{ $item->quantity }}</td>
                            <td class="py-2 text-right">Rs. {{ $item->inventory->price }}</td>
                            <td class="py-2 text-right">{{ $getDiscountPercent($item->inventory->discount) }}</td>
                            <td class="py-2 text-right">Rs. {{ $getDiscountedPrice($item->inventory) }}</td>
                            <td class="py-2 text-right">Rs. {{ $getLineTotal($item) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div>
            <div class="flex justify-between">
                <div>

                </div>
                <div class="w-1/3">
                    <table class="table-auto w-full">
                        <tbody>
                            <tr>
                                <th class="py-2 text-left">Subtotal</th>
                                <td class="py-2 text-right">Rs. {{ $getSubTotal($orderDetail) }}</td>
                            </tr>
                            <tr>
                                <th class="py-2 text-left">Delivery Price</th>
                                <td class="py-2 text-right">
                                    Rs. {{ $orderDetail->address->delivery->price }}
                                </td>
                            </tr>
                            <tr class="bg-gray-400/50">
                                <th class="py-2 text-left">Total</th>
                                <td class="py-2 text-right">Rs.{{ $orderDetail->total }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
