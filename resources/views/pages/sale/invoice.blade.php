<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <title>Invoice - #{{ $sales->sale_id }}</title>
    <style>
        body {
            font-family: Outfit, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .store-info {
            text-align: right;
        }

        .store-info h2 {
            margin: 0;
            font-size: 24px;
        }

        .store-info p {
            margin: 5px 0;
            font-size: 14px;
        }

        .store-info img {
            width: 100px;
            height: auto;
            margin-top: 10px;
        }

        .invoice-info {
            margin-bottom: 20px;
        }

        .invoice-info h1 {
            font-size: 28px;
            margin: 0;
        }

        .invoice-info p {
            margin: 5px 0;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .total {
            font-size: 18px;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="store-info">
                <h2>APPLEVERSE</h2>
                <p>Jalan Galaksi, Bima Sakti, Milkyway City</p>
                {{-- <img src="{{ asset('assets/images/wikrama-logo.png') }}"> --}}
            </div>
            <div class="invoice-info">
                <h1>Invoice - #{{ $sales->id }}</h1>
                <p>{{ $sales->created_at }}</p>
                @if ($sales->customer)
                    <p><strong>Customer:</strong> {{ $sales->customer->no_hp }}</p>
                    <p><strong>Member Since:</strong> {{ $sales->customer->created_at->format('d M Y') }}</p>
                    <p><strong>Points Used:</strong> {{ $pointUsed }}</p>
                @endif
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($details as $detail)
                    <tr>
                        <td>{{ $detail->product->name }}</td>
                        <td>Rp{{ number_format($detail->product->price, 0, ',', '.') }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <div>
                <p><strong>Cashier:</strong> {{ $sales->user->name }}</p>
                <p><strong>Pay:</strong> Rp{{ number_format($sales->total_pay, 0, ',', '.') }}</p>
                <p><strong>Change:</strong> Rp{{ number_format($sales->total_return, 0, ',', '.') }}</p>
            </div>
            <div class="text-right total">
                <p><strong>Total:</strong> Rp{{ number_format($totalAfterDiscount, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
</body>
</html>
