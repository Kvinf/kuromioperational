@extends('applayout')
@section('content')
    <div class="content-header">
        <h1>Invoice Management</h1>
        <a href="{{ route('addinvoice') }}" type="button" style="width: 75px" class="buttonCustom">
            +
        </a>
    </div>
    <br />
    <table class="table">
        <thead>
            <tr style="background-color: transparent">
                <th style="background-color: transparent" scope="col">No.</th>
                <th style="background-color: transparent" scope="col">Invoice Number</th>
                <th style="background-color: transparent" scope="col">Total Price</th>
                <th style="background-color: transparent" scope="col">-</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($items as $index => $item)
                <tr style="background-color: transparent">
                    <th style="background-color: transparent" scope="row">{{ $index + 1 }}</th>
                    <td style="background-color: transparent">{{ $item['invoiceNumber'] }}</td>
                    <td style="background-color: transparent">Rp. {{ $item['totalPrice'] }}</td>
                    <td style="background-color: transparent">
                        <a href="{{ route('downloadInvoice', ['id' => $item['id']]) }}" class="btn btn-success btn-sm">
                            Download
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
