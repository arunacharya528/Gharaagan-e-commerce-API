<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        header {
            display: grid;
            grid-template-columns: 50vw 50vw;
        }

        .number {
            text-align: right;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .price-table th {
            text-transform: uppercase;
        }

        .price-table td,
        .price-table th {
            padding: 0.5rem;
        }

        .overview {
            display: inline-block;
            text-overflow: unset;
        }

        .overview .title {
            text-transform: uppercase;
            font-weight: lighter;
        }

        .overview .content {
            font-weight: bold;
            font-size: 1.2rem;
        }

        .alert {
            border: 1px solid crimson;
            background-color: rgba(220, 20, 60, 0.1);
            padding: 1rem;
            border-radius: 1rem;
        }

        .address .title {
            text-transform: uppercase;
            font-weight: bold;
            padding: 0.5rem 0;
        }
    </style>
</head>

<body>


    @php
        $getDiscountPercent = function ($discount) {
            return $discount === null || $discount->active === 0 ? '-' : $discount->discount_percent . '%';
        };

        $getDiscountedPrice = function ($price, $discount) {
            if ($discount === null || $discount->active === 0) {
                return $price;
            } else {
                return $price - 0.01 * $price * $discount->discount_percent;
            }
        };

        $getLineTotal = function ($item) use ($getDiscountedPrice) {
            return $getDiscountedPrice($item->inventory->price, $item->inventory->discount) * $item->quantity;
        };

        $getSubTotal = function ($orderDetail) use ($getLineTotal) {
            $total = 0;
            foreach ($orderDetail->orderItems as $item) {
                $total += $getLineTotal($item);
            }

            return $total;
        };

        $getSum = function ($collection) {
            $sum = 0;
            for ($i = 0; $i < count($collection); $i++) {
                $sum += $collection[$i];
            }
            return $sum;
        };

        $totalSum = $getSum([$getDiscountedPrice($getSubTotal($orderDetail), $orderDetail->discount), $orderDetail->address->delivery->price]);

    @endphp

    <table class="">
        <tbody>
            <tr>
                <td style="width: 50%;" class="address">
                    <div class="title">Bill From</div>
                    <div>
                        @php
                            echo App\Models\SiteDetail::where('name', 'site_address')->first()->value;
                        @endphp
                    </div>
                </td>
                <td style="width: 50%;text-align:right;" class="address">
                    <div class="title">Bill To</div>
                    <div>{{ $orderDetail->address->address_line1 }}</div>
                    <div>{{ $orderDetail->address->address_line2 }}</div>
                    <div>{{ $orderDetail->address->delivery->region }}</div>
                    <div>{{ $orderDetail->address->telephone }}</div>
                    <div>{{ $orderDetail->address->mobile }}</div>
                </td>
            </tr>
        </tbody>

    </table>


    <table style="padding: 2.5rem 0;">
        <tbody>
            <tr>
                <td class="overview" style="width: 33%">
                    <div class="title">Invoice Date</div>
                    <div class="content">
                        {{ date('F d, Y H:i:s', strtotime($orderDetail->created_at)) }}
                    </div>
                </td>
                <td class="overview" style="width: 33%; text-align:center;">
                    <div class="title">Invoice #</div>
                    <div class="content">{{ $orderDetail->id }}</div>
                </td>
                <td class="overview" style="width: 33%; text-align:right;">
                    <div class="title">Amount Due</div>
                    <div class="content">Rs.{{ $orderDetail->total }}</div>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width: 100%" class="price-table">
        <thead>
            <tr class="bg-gray-400/50">
                <th class="">S.N.</th>
                <th class="">Item</th>
                <th class="">Type</th>
                <th class="number">Unit Cost</th>
                <th class="number">Discount</th>
                <th class="number">Discounted Price</th>
                <th class="number">Quantity</th>
                <th class="number">Total</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($orderDetail->orderItems as $item)
                <tr class="">
                    <th class="">{{ $loop->index + 1 }}</th>
                    <td class="">{{ $item->product->name }}</td>
                    <td class="">{{ $item->inventory->type }}</td>
                    <td class="number">Rs. {{ $item->inventory->price }}</td>
                    <td class="number">{{ $getDiscountPercent($item->inventory->discount) }}</td>
                    <td class="number">Rs.
                        {{ $getDiscountedPrice($item->inventory->price, $item->inventory->discount) }}</td>
                    <td class="number">{{ $item->quantity }}</td>
                    <td class="number">Rs. {{ $getLineTotal($item) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table style="width: 100%; padding:2.5rem 0;">
        <tbody>
            <tr>
                <td style="width: 60%">
                    @if ($totalSum !== (float) $orderDetail->total)
                        <div class="alert">
                            The inconsistencies within this bill could be because of various reasons. But the <b>Calculated total</b> was recorded within our database during the time of <b>order placement</b>.
                            <br>
                            For more information contact us.
                        </div>
                    @endif
                </td>
                <td style="width: 40%">
                    <table style="width: 100%" class="price-table">
                        <tbody>
                            <tr>
                                <th class="" style="width:50%; text-align: left;">Subtotal</th>
                                <td class="" style="width:50%; text-align: right;">
                                    Rs.{{ $getSubTotal($orderDetail) }}</td>
                            </tr>
                            <tr>
                                <th class="" style="width:50%; text-align: left;">Discount</th>
                                <td class="" style="width:50%; text-align: right;">
                                    {{ $getDiscountPercent($orderDetail->discount) }}</td>
                            </tr>
                            <tr>
                                <th class="" style="width:50%; text-align: left;">After discount
                                </th>
                                <td class="" style="width:50%; text-align: right;">
                                    Rs. {{ $getDiscountedPrice($getSubTotal($orderDetail), $orderDetail->discount) }}
                                </td>
                            </tr>
                            <tr>
                                <th style="width:50%; text-align: left;">Delivery Price</th>
                                <td style="width:50%; text-align: right;">
                                    Rs. {{ $orderDetail->address->delivery->price }}
                                </td>
                            </tr>

                            @if ($totalSum !== (float) $orderDetail->total)
                                <tr class="bg-gray-400/50">
                                    <th style="width:50%; text-align: left;">! Calculated Total</th>
                                    <td style="width:50%; text-align: right;">Rs.{{ $totalSum }}</td>
                                </tr>
                            @endif

                            <tr class="bg-gray-400/50">
                                <th style="width:50%; text-align: left;">Total</th>
                                <td style="width:50%; text-align: right;">Rs.{{ $orderDetail->total }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
