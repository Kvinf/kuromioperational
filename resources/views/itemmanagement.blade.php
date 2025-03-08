@extends('applayout')
@section('content')
    <div class="content-header">
        <h1>Item Management</h1>
        <button type="button" style="width: 75px" class="buttonCustom" data-bs-toggle="modal" data-bs-target="#exampleModal">
            +
        </button>
    </div>
    <br />
    <table class="table">
        <thead>
            <tr style="background-color: transparent">
                <th style="background-color: transparent" scope="col">No.</th>
                <th style="background-color: transparent" scope="col">Item</th>
                <th style="background-color: transparent" scope="col">Price</th>
                <th style="background-color: transparent" scope="col">-</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($items as $index => $item)
                <tr style="background-color: transparent">
                    <th style="background-color: transparent" scope="row">{{ $index + 1 }}</th>
                    <td style="background-color: transparent">{{ $item['name'] }}</td>
                    <td style="background-color: transparent">Rp. {{ number_format($item['price'], 2) }}</td>
                    <td style="background-color: transparent">

                        <button class="btn btn-warning btn-sm update-btn" data-id="{{ $item['id'] }}"
                            data-price="{{ $item['price'] }}" data-name="{{ $item['name'] }}" data-bs-toggle="modal"
                            data-bs-target="#updateModal">
                            Edit
                        </button>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $item['id'] }}"
                            data-bs-toggle="modal" data-bs-target="#deleteModal">
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('addItem') }}" method="POST">
                        @csrf
                        <div class="itemSection">
                            <label class="itemLabel">Name</label>
                            <input class="itemInput" name="name" type="text">
                        </div>
                        <div class="itemSection">
                            <label class="itemLabel">Price (RP. )</label>
                            <input name="price" type="number" class="itemInput no-spinner">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Add" />
                </div>
                </form>

            </div>
        </div>
    </div>
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('updateItem') }}" method="POST">
                        @csrf
                        <input id="idUpdate" name="id" type="hidden">

                        <div class="itemSection">
                            <label class="itemLabel">Name</label>
                            <input class="itemInput" id="updateName" name="name" type="text">
                        </div>
                        <div class="itemSection">
                            <label class="itemLabel">Price (RP. )</label>
                            <input name="price" id="updatePrice" type="number" class="itemInput no-spinner">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Update" />
                </div>
                </form>

            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Modal</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure want to delete this invoice ?
                    <form action="{{ route('deleteItem') }}" method="POST">
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
        document.querySelectorAll('.update-btn').forEach(button => {
            button.addEventListener('click', function() {
                let itemId = this.getAttribute('data-id');
                let itemName = this.getAttribute('data-name');
                let itemPrice = this.getAttribute('data-price');

                updateButtonClick(itemId,itemName,itemPrice);
            });
        });

        function updateButtonClick(id,name,price) {
            document.getElementById("idUpdate").value = id;
            document.getElementById("updateName").value = name;
            document.getElementById("updatePrice").value = price;

        }

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
