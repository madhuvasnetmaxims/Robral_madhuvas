@include('include.header')

<style>
    .container {
        max-width: 800px;
        margin: auto; 
    }

    .table {
        width: 100%;
        border-collapse: collapse; 
        background-color: rgba(0, 0, 0, 0.7); 
    }

    .table th, .table td {
        padding: 12px; 
        text-align: left;
        color: #fff; 
    }

    .table th {
        background-color: rgba(255, 165, 0, 0.8); 
        font-weight: bold; 
        text-transform: uppercase; 
    }

    .table-footer td {
        font-weight: bold; 
    }

    .table th, .table td {
        border: none; 
    }

    .remove-icon {
        color: red; 
        cursor: pointer; 
        font-size: 20px;
    }

    .remove-icon:hover {
        color: darkred;
    }

    img {
        border-radius: 5px;
    }
</style>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script type="text/javascript">
    @if(Session::has('success'))
        toastr.options.timeOut = 1000; 
        toastr.success("{{ session('success') }}");
    @endif
</script>

<div class="container mt-5">
    <table class="table">
        @if(count(($cartItems)) > 0)

        <thead>
            <tr>
                <th>Image</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Remove</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cartItems as $cartItem)
                <tr>
                    <td>
                        <img src="{{ $cartItem['image'] }}" height="100" width="100" alt="Image of {{ $cartItem['name'] }}">
                    </td>
                    <td>{{ $cartItem['name'] }}</td>
                    <td class="price-{{ $cartItem['id'] }}">{{ number_format($cartItem['price'], 2) }}</td>
                    <td>
                        <div class="quantity-control">
                            <button id="minus-button-{{ $cartItem['id'] }}" class="btn btn-secondary btn-sm" onclick="updateQuantity({{ $cartItem['id'] }}, -1)">-</button>
                            <span id="quantity-{{ $cartItem['id'] }}">{{ $cartItem['quantity'] }}</span>
                            <button class="btn btn-secondary btn-sm" onclick="updateQuantity({{ $cartItem['id'] }}, 1)">+</button>
                        </div>
                    </td>
                    
                    
                    <td class="total-price total-price-{{ $cartItem['id'] }}">
                        {{ number_format($cartItem['price'] * $cartItem['quantity'], 2) }}
                    </td>
                    <td>
                        <form action="{{ route('cart.remove', $cartItem['id']) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="remove-icon" title="Remove Item" onclick="return confirm('Are you sure you want to remove this item?');">&times;</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            <tr class="table-footer">
                <td colspan="5"><strong>Grand Total</strong></td>
                <td><strong id="grand-total">{{ number_format($cartTotal, 2) }}</strong></td>
                <td></td>
            </tr>
        </tbody>
        

        @else

        <p class="p-5 alert alert-danger">No Items Available in the Cart</p>

        @endif
        
    </table>
    <div class="d-flex justify-content-end">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Proceed to pay</button>

    </div>

</div>


<script>
   function updateQuantity(productId, change) {
    const quantitySpan = document.getElementById(`quantity-${productId}`);
    const minusButton = document.getElementById(`minus-button-${productId}`);
    let currentQuantity = parseInt(quantitySpan.innerText);

    currentQuantity += change;

    if (currentQuantity < 1) {
        currentQuantity = 1;
    }

    quantitySpan.innerText = currentQuantity;

    if (currentQuantity === 1) {
        minusButton.disabled = true; 
    } else {
        minusButton.disabled = false; 
    }

    const price = parseFloat(document.querySelector(`.price-${productId}`).innerText.replace(',', ''));
    const totalPrice = (price * currentQuantity).toFixed(2);

    document.querySelector(`.total-price-${productId}`).innerText = totalPrice;

    calculateGrandTotal();

    fetch(`{{ route('cart-update', ':id') }}`.replace(':id', productId), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ quantity: currentQuantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            toastr.success(data.message);
        } else {
            toastr.error('Failed to update quantity.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        toastr.error('An error occurred while updating the quantity.');
    });
}


    function calculateGrandTotal() {
        let grandTotal = 0;

        document.querySelectorAll('.total-price').forEach((totalPriceElement) => {
            grandTotal += parseFloat(totalPriceElement.innerText.replace(',', ''));
        });

        document.getElementById('grand-total').innerText = grandTotal.toFixed(2);
    }

function checkQuantitiesOnLoad() {
    document.querySelectorAll('[id^="quantity-"]').forEach((quantityElement) => {
        const productId = quantityElement.id.split('-')[1]; 
        const currentQuantity = parseInt(quantityElement.innerText);
        const minusButton = document.getElementById(`minus-button-${productId}`);

        if (currentQuantity === 1) {
            minusButton.disabled = true; 
        } else {
            minusButton.disabled = false;
        }
    });
}

document.addEventListener('DOMContentLoaded', checkQuantitiesOnLoad);

</script>



@include('include.footer')
