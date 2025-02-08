@extends('applayout')
@section('content')
    <h1>Invoice Management</h1>
    <br>
    <form action="{{ route('editItemInvoice') }}" method="POST">
        @csrf

        <div style="margin-bottom: 10px">
            <label style="width: 150px">Customer Name</label>
            <input type="" name="customerName" value="{{ $invoice->customerName }}" class="itemInput" id="customerName"
                placeholder="Customer Name" />
        </div>

        <div style="margin-bottom: 10px">
            <label style="width: 150px">Customer Phone</label>
            <input type="" name="customerPhone" value="{{ $invoice->customerPhone }}" class="itemInput"
                id="customerPhone" placeholder="Customer Phone" />
        </div>
        <button type="button" id="searchPhoneButton" class="buttonCustom">Search Phone</button>

        <input type="hidden" value="{{ $invoice->id }}" name="id" />
        <div id="formArray">
            @foreach ($invoiceItems as $invoiceItem)
                <div class="formSection">
                    <label>Item</label>
                    <select name="item[]" class="item-select">
                        @foreach ($items as $index => $item)
                            <option value="{{ $item->id }}" data-name="{{ $item->name }}"
                                data-price="{{ $item->price }}" {{ $item->id == $invoiceItem->itemId ? 'selected' : '' }}>
                                {{ $item->name }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="name[]" class="itemName" placeholder="name"
                        value="{{ $invoiceItem->itemName }}" />
                    <input type="hidden" name="price[]" class="itemPrice" placeholder="price"
                        value="{{ $invoiceItem->itemPrice }}" />
                    <input type="hidden" name="pricePiece[]" class="itemPricePiece" placeholder="piece"
                        value="{{ $invoiceItem->itemPricePiece }}" />
                    <input type="number" name="qty[]" class="quantity-input" placeholder="Quantity"
                        value="{{ $invoiceItem->itemQty }}" />
                    <label class="total-price">Rp. {{ number_format($invoiceItem->itemPrice) }}</label>
                    <button type="button" class="delete-button">-</button>
                </div>
            @endforeach
        </div>
        <br />

        <button type="button" class="buttonCustom" id="addFieldButton">Add Another Item</button>
        <br />

        <button type="submit" class="buttonCustom">Edit</button>
    </form>

    <script>
        $(document).ready(function() {
            $("#searchPhoneButton").click(function() {
                let phone = $("#customerPhone").val();

                if (phone === "") {
                    alert("Please enter a phone number.");
                    return;
                }

                $.ajax({
                    url: "/searchPhone", // Calling the API route
                    type: "GET",
                    data: {
                        phone: phone
                    },
                    success: function(response) {
                        if (response.success) {
                            $("#customerName").val(response.customer.name);
                        } else {
                            alert("Customer not found.");
                        }
                    },
                    error: function() {
                        alert("Error searching customer.");
                    }
                });
            });
        });
        // Function to calculate and update total price
        function updateTotalPrice(section) {
            const select = section.querySelector('.item-select');
            const qtyInput = section.querySelector('.quantity-input');
            const totalPriceLabel = section.querySelector('.total-price');

            const priceInput = section.querySelector('.itemPrice');
            const nameInput = section.querySelector('.itemName');
            const pieceInput = section.querySelector('.itemPricePiece');

            const price = parseFloat(select.options[select.selectedIndex].getAttribute('data-price')) || 0;
            const name = select.options[select.selectedIndex].getAttribute('data-name');



            const quantity = parseFloat(qtyInput.value) || 0;
            const totalPrice = price * quantity;

            priceInput.value = totalPrice;

            nameInput.value = name;

            pieceInput.value = price;

            totalPriceLabel.textContent = `Rp. ${totalPrice.toLocaleString('id-ID')}`;
        }

        // Function to handle delete
        function addDeleteEvent(button) {
            button.addEventListener('click', function() {
                const formArray = document.getElementById('formArray');
                if (formArray.querySelectorAll('.formSection').length > 1) {
                    const formSection = button.parentElement;
                    formSection.remove();
                } else {
                    alert('At least one row is required.');
                }
            });
        }

        // Event listener for dynamically adding a new form section
        document.getElementById('addFieldButton').addEventListener('click', function() {
            const formArray = document.getElementById('formArray');

            const newSection = document.createElement('div');
            newSection.className = 'formSection';
            newSection.innerHTML = `
            <label>Item</label>
            <select name="item[]" class="item-select">
                @foreach ($items as $index => $item)
                <option value="{{ $item->id }}" data-name="{{ $item->name }}" data-price="{{ $item->price }}">{{ $item->name }}</option>
                @endforeach
            </select>
            <input type="hidden" name="name[]"  class="itemName" placeholder="Quantity" />
            <input type="hidden" name="price[]"   class="itemPrice" placeholder="Quantity" />
            <input type="hidden" name="pricePiece[]"  class="itemPricePiece" placeholder="Quantity" />

            <input type="number" name="qty[]" class="quantity-input" placeholder="Quantity" />
            <label class="total-price">Rp. 0</label>
            <button type="button" class="delete-button">-</button>
        `;

            formArray.appendChild(newSection);

            const newSelect = newSection.querySelector('.item-select');
            const newQtyInput = newSection.querySelector('.quantity-input');
            const deleteButton = newSection.querySelector('.delete-button');

            newSelect.addEventListener('change', () => updateTotalPrice(newSection));
            newQtyInput.addEventListener('input', () => updateTotalPrice(newSection));
            addDeleteEvent(deleteButton);
        });

        document.querySelectorAll('.formSection').forEach(section => {
            const select = section.querySelector('.item-select');
            const qtyInput = section.querySelector('.quantity-input');
            const deleteButton = section.querySelector('.delete-button');

            select.addEventListener('change', () => updateTotalPrice(section));
            qtyInput.addEventListener('input', () => updateTotalPrice(section));
            addDeleteEvent(deleteButton);
        });
    </script>
@endsection
