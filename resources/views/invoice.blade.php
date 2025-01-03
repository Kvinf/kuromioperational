<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        @font-face {
            font-family: 'Malinda';
            src: url('{{ public_path('fonts/Malinda.ttf') }}') format('truetype');
        }

        @font-face {
            font-family: 'Vividly';
            src: url('{{ public_path('fonts/Vividly-Regular.ttf') }}') format('truetype');
        }

        @page {
            margin: 0;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            background-color: #6F96D1;
            font-family: 'Vividly', sans-serif;
            color: white;
            font-size: 20px;
            background-image: url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logo3.png'))) }}');
            background-size: 700px auto;
            /* Smaller size */
            background-position: -212px 400px;
            /* Adjusted to align to the left and slightly down */
            background-repeat: no-repeat;
        }

        body {
            padding-left: 50px;
            position: relative;
            z-index: 1;
        }

        .header {
            text-align: left;
            font-size: 100px;
            font-family: 'Malinda', sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1;
            z-index: 2;
            position: relative;
        }

        .customerItem {
            width: 100%;
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            z-index: 2;
            position: relative;
        }

        .customerItemSecond {
            width: 100%;
            display: flex;
            justify-content: space-between;
            margin-top: 1px;
            z-index: 2;
            position: relative;
        }

        .items,
        .totals {
            width: 100%;
            margin-top: 10px;
            z-index: 2;
            position: relative;
        }

        .items th,
        .items td {
            border: 1px solid white;
            padding: 8px;
            width: auto;
            font-family: 'Vividly', sans-serif;
            word-break: break-word;
            white-space: normal;
            text-align: left;
        }

        .items {
            border-collapse: collapse;
        }

        .logo {
            position: absolute;
            bottom: 150px;
            left: 10px;
            width: 300px;
            /* Adjusted to make it smaller */
            z-index: 1;
        }
    </style>
</head>

<body>
    <div class="header">Invoice</div>
    <div>
        <div class="customerItem">
            <div style="float: left; width: 25%">BILL TO : </div>
            <div style="margin-left: 5%; width: 65%">
                <div>{{ $customerName }}</div>
                <div>{{ $customerPhone }}</div>
            </div>
        </div>
        <div class="customerItem">
            <div style="float: left; width: 25%">PAY TO : </div>
            <div style="margin-left: 5%; width: 65%">
                <div>Kurimi Bakes</div>
                <div>081283881777</div>
            </div>
        </div>
        <div class="customerItem" style="margin-top: 1px; margin-bottom: 1px">
            <div style="width: 90%">PAYMENT TO: </div>
        </div>
        <div class="customerItem" style="margin-top: 1px">
            <div style="float: left; width: 25%">BANK</div>
            <div style="margin-left: 5%; width: 65%">
                <div>BCA</div>
                <div></div>
            </div>

        </div>
        <div class="customerItem" style="margin-top: 1px;">
            <div style="float: left; width: 25%">Account Name</div>
            <div style="margin-left: 5%; width: 65%">
                <div>Kimberly Tam</div>
                <div></div>
            </div>
        </div>
        <div class="customerItem" style="margin-top: 1px;">
            <div style="float: left; width: 25%">Account Number</div>
            <div style="margin-left: 5%; width: 65%">
                <div>3833877999</div>
                <div></div>
            </div>
        </div>
    </div>
    <br />
    <table class="items" style="width: 85%; border-collapse: collapse;">
        <colgroup>
            <col style="width: 40%;">
            <col style="width: 15%;">
            <col style="width: 20%;">
            <col style="width: 25%;">
        </colgroup>
        <thead>
            <tr>
                <td
                    style="padding-left:30px; font-size: 20px; border: none; border-top: 1px solid white; border-bottom: 1px solid white;">
                    DESCRIPTION</td>
                <td
                    style="text-align: center; font-size: 20px; border: none; border-top: 1px solid white; border-bottom: 1px solid white;">
                    QUANTITY</td>
                <td
                    style="text-align: center; font-size: 20px; border: none; border-top: 1px solid white; border-bottom: 1px solid white;">
                    PRICE</td>
                <td
                    style="text-align: center; font-size: 20px; border: none; border-top: 1px solid white; border-bottom: 1px solid white;">
                    AMOUNT</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td style="padding-left:30px; width: 40%; border: none;">{{ $item->itemName }}</td>
                    <td style="text-align: center; width: 15%; border: none;">{{ $item->itemQty }}</td>
                    <td style="text-align: center; width: 20%; border: none;">Rp.
                        {{ number_format($item->itemPricePiece, 2) }}</td>
                    <td style="text-align: center; width: 25%; border: none;">Rp.
                        {{ number_format($item->itemPrice, 2) }}</td>
                </tr>
            @endforeach
            <tr>
                <td style="padding-left:30px; width: 45%; border: none; border-top: 1px solid white;"></td>
                <td style="text-align: center; width: 15%; border: none; border-top: 1px solid white;"></td>
                <td style="text-align: center; width: 20%; border: none; border-top: 1px solid white;">Total</td>
                <td style="text-align: center; width: 25%; border: none; border-top: 1px solid white;">Rp.
                    {{ number_format($total, 2) }}</td>
            </tr>
        </tbody>
    </table>
    <div class="customerItem" style="margin-top: 1px;">
        <div style="float: left; width: 25%">Invoice Number</div>
        <div style="margin-left: 5%; width: 65%">{{ $transactionId }}</div>
    </div>
    <div class="customerItem" style="margin-top: 1px;">
        <div style="float: left; width: 25%">Date</div>
        <div style="margin-left: 5%; width: 65%">{{ \Carbon\Carbon::parse($date)->format('d F Y') }}</div>
    </div>
</body>

</html>
