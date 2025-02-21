<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dhaka Pharmacy - Invoice #{{ $order->order_id }}</title>
    <style>
        /* Custom CSS */
        :root {
            --primary-color: #0088cc;
            --secondary-color: #4caf50;
            --border-color: #e5e7eb;
            --text-muted: #6b7280;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.5;
            color: #111827;
        }

        .invoice-card {
            padding: 2rem;
            max-width: 850px;
            margin: 0 auto;
        }

        .logo {
            height: 48px;
            width: auto;
        }

        .invoice-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 1rem;
        }

        .invoice-number {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-bottom: 2rem;
        }

        .divider {
            height: 1px;
            background-color: var(--border-color);
            margin: 2rem 0;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin: -0.5rem;
        }

        .col {
            flex: 1;
            padding: 0.5rem;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            border-bottom: 1px solid var(--border-color);
        }

        .table th {
            text-align: left;
            font-weight: 600;
            background-color: #f9fafb;
        }

        .text-right {
            text-align: right;
        }

        .text-muted {
            color: var(--text-muted);
        }

        .mt-4 {
            margin-top: 2rem;
        }

        .mb-2 {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>

    <div class="invoice-card">
        <!-- Header -->
        <div class="row">
            <div class="col">
                <img src="{{ storage_url(settings('site_logo')) }}" alt="Dhaka Pharmacy Logo" class="logo">
                <h1 class="invoice-title">Invoice</h1>
                <p class="invoice-number">#{{ $order->order_id }}</p>
            </div>
            <div class="col text-right">
                <p><strong>Order Date:</strong> {{ timeFormate($order->created_at) }}</p>
                <p><strong>Status:</strong> {{ slugToTitle($order->status_string) }}</p>
                <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>
            </div>
        </div>

        <div class="divider"></div>

        <!-- Addresses -->
        <div class="row">
            <div class="col">
                <h3>Delivery Address</h3>
                <p>{{ optional($order->customer)->name }}</p>
                <p>{{ optional($order->address)->address }}</p>
                <p>{{ optional($order->address)->area }}, {{ optional($order->address)->city }}</p>
                <p>Phone: {{ optional($order->customer)->phone }}</p>
            </div>
            <div class="col text-right">
                <h3>From</h3>
                <p>Dhaka Pharmacy</p>
                <p>4th Floor, Noor Mansion, Plot-4, Main Road, Mirpur-10, Dhaka-1216</p>
                <p>Phone: +8801714432534</p>
                <p>Email: admin@dhakapharmacy.com.bd</p>
            </div>
        </div>

        <div class="divider"></div>

        <!-- Order Items -->
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Discount</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ optional($product->pivot->unit)->name }}</td>
                    <td>{{ $product->pivot->quantity }}</td>
                    <td>৳{{ number_format($product->pivot->unit_price, 2) }}</td>
                    <td>৳{{ number_format($product->pivot->unit_discount, 2) }}</td>
                    <td class="text-right">৳{{ number_format($product->pivot->total_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Order Summary -->
        <div class="row mt-4">
            <div class="col"></div>
            <div class="col">
                <table class="table">
                    <tr>
                        <td>Subtotal:</td>
                        <td class="text-right">৳{{ number_format($order->sub_total, 2) }}</td>
                    </tr>
                    @if($order->product_discount > 0)
                    <tr>
                        <td>Product Discount:</td>
                        <td class="text-right">-৳{{ number_format($order->product_discount, 2) }}</td>
                    </tr>
                    @endif
                    @if($order->voucher_discount > 0)
                    <tr>
                        <td>Voucher Discount:</td>
                        <td class="text-right">-৳{{ number_format($order->voucher_discount, 2) }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td>Delivery Fee:</td>
                        <td class="text-right">৳{{ number_format($order->delivery_fee, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Total:</th>
                        <th class="text-right">৳{{ number_format($order->sub_total - $order->product_discount - $order->voucher_discount + $order->delivery_fee, 2) }}</th>
                    </tr>
                </table>
            </div>
        </div>

        <div class="divider"></div>

        <!-- Footer -->
        <div class="row">
            <div class="col">
                <p class="text-muted mb-2">Payment Method: {{ ucfirst($order->payment_status) }}</p>
                <p class="text-muted mb-2">Delivery Type: {{ $order->deliveryType() }}</p>
                <p class="text-muted">Order Type: {{ $order->orderType() }}</p>
            </div>
        </div>
    </div>
</body>
</html>
