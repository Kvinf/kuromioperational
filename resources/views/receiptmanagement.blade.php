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
                <td style="background-color: transparent">No.HP</td>
                <th style="background-color: transparent" scope="col">Total Price</th>
                <th style="background-color: transparent" scope="col">-</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($items as $index => $item)
                <tr style="background-color: transparent">
                    <th style="background-color: transparent" scope="row">{{ $index + 1 }}</th>
                    <td style="background-color: transparent">{{ $item['invoiceNumber'] }}</td>
                    <td style="background-color: transparent">{{ $item['customerPhone'] }}</td>
                    <td style="background-color: transparent">Rp. {{ $item['totalPrice'] }}</td>
                    <td style="background-color: transparent">
                        <a href="{{ route('downloadInvoice', ['id' => $item['id']]) }}" class="btn btn-success btn-sm">
                            Download
                        </a>
                        <a href="{{ route('editinvoice', ['id' => $item['id']]) }}" class="btn btn-warning btn-sm">
                            Edit
                        </a>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $item['id'] }}" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            Delete
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Modal</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure wan to delete this invoice ?
                    <form action="{{ route('deleteItemInvoice') }}" method="POST">
                        @csrf
                        <input id="idDelete" name="id" type="hidden">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-danger" value="Delete" />
                </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                let itemId = this.getAttribute('data-id');
                buttonDeleteOnClick(itemId);
            });
        });

        function buttonDeleteOnClick(id) {
            document.getElementById("idDelete").value = id; // Make sure "idDelete" exists
        }
    </script>
@endsection
