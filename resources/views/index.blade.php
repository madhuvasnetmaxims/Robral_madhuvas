@include('include.header')

<div class="container">
   <h3 class="mt-3"> Products</h3>
   @php
       $color1 = 'bg-light'; 
       $color2 = 'bg-secondary'; 
       $groupSize = 8; 
   @endphp

   @if (count($products)>0)

   @foreach ($products->chunk($groupSize) as $chunkIndex => $productChunk)
       @php
           $currentColor = $chunkIndex % 2 === 0 ? $color1 : $color2;
       @endphp
       <div class="row mt-5 mb-3 {{ $currentColor }}">
           @foreach ($productChunk as $product)
               <div class="col-sm mb-3 m-2 py-4">
                <div class="card shadow-lg border-light" style="width: 14rem;">
                    <!-- Increase image size -->
                    <img src="{{ $product['image'] }}" class="card-img-top rounded-top" 
                         style="width: 100%; height: 200px; object-fit: cover;" 
                         alt="{{ $product['name'] }}">
                
                    <div class="card-body">
                        <!-- Reduce spacing and font size -->
                        <div class="text-start" style="font-size: 0.8rem;">
                            <span class="text-warning">&#9733;</span>
                            <span class="text-warning">&#9733;</span>
                            <span class="text-warning">&#9733;</span>
                            <span class="text-warning">&#9733;</span>
                            <span class="text-muted">&#9733;</span>
                        </div>
                        <h5 class="card-title text-center font-weight-bold text-dark" style="font-size: 1rem;">
                            {{ $product['name'] }}
                        </h5>
                        <p class="card-text text-muted text-truncate" 
                           style="height: 25px; overflow: hidden; font-size: 0.8rem;">
                            {{ $product['description'] }}
                        </p>
                        <p class="card-text text-center font-weight-bold text-success mt-2" style="font-size: 0.9rem;">
                            ${{ $product['price'] }}
                        </p>
                    </div>
                
                    <div class="card-footer text-center" style="padding: 0.5rem;">
                        @if (in_array($product->id, $cartProductIds))
                            <button class="btn btn-secondary btn-sm py-1 view-cart" style="font-size: 0.8rem;">
                                View Cart
                            </button>
                        @else
                            <button class="btn btn-primary btn-sm py-1 add-to-cart" 
                                    data-id="{{ $product['id'] }}" 
                                    data-name="{{ $product['name'] }}" 
                                    data-price="{{ $product['price'] }}" 
                                    data-image="{{ $product['image'] }}" 
                                    style="font-size: 0.8rem;">
                                Add to cart 
                            </button>
                        @endif
                    </div>
                </div>
                
               </div>
           @endforeach
       </div>
   @endforeach

   @else

   <h4>No products available</h4>
       
   @endif
</div>

@include('include.footer')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script>
    $(document).on('click', '.add-to-cart', function () {
        var productId = $(this).data('id');
        var productName = $(this).data('name');
        var productPrice = $(this).data('price');
        var productImage = $(this).data('image');
        var quantity = 1; 

        $.ajax({
            url: '{{ route('add-to-cart') }}',
            method: 'POST',
            data: {
                id: productId,
                name: productName,
                price: productPrice,
                image: productImage,
                quantity: quantity,
                _token: '{{ csrf_token() }}',
            },
            success: function (response) {
               if (response.status == 'success') {
                   toastr.options.timeOut = 1000; 
                   toastr.success("Product added to cart successfully!"); 
                   
                   setTimeout(function () {
                       location.reload(); 
                   }, 1000); 
               }
            }
        });
    });

   

    $(document).on('click', '.view-cart', function () {
        window.location.href = '{{ route('view.cart') }}';
    });
</script>
