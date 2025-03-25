@extends('pages.pos.posmaster')

@section('content')
    <style>
        .scrollable-container {
            max-height: 350px;
            overflow-y: auto;
        }

        .info-box {
            background-color: white;
            color: black;
            padding: 20px;
            cursor: pointer;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: flex-start;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            transition: background-color 0.3s ease;
            overflow: hidden;
            font-size: 18px;
        }

        .info-box:hover {
            background-color: #88d3f5;
        }

        .box-content {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: flex-start;
            width: 100%;
        }

        .image-container {
            width: 50%;
            /* Container takes 50% of the button width */
            height: 50px;
            /* Fixed height for the container */
            background-color: #f1f1f1;
            /* Placeholder background color */
            margin-right: 10px;
            /* Space between image and text */
            overflow: hidden;
            /* Hide any part of the image that exceeds the container */
        }

        .image-container img {
            width: 100%;
            /* Ensure image takes full width of container */
            height: 100%;
            /* Ensure image takes full height of container */
            object-fit: cover;
            /* Scale image to cover the container without stretching */
        }

        .text-container {
            width: 50%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .box-title {
            font-size: 12px;
            font-weight: 600;
            margin: 0;
            white-space: normal;
            overflow: visible;
            word-wrap: break-word;
        }

        .box-price {
            font-size: 11px;
            font-weight: bold;
            margin: 5px 0 0;
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
        }

        @media (max-width: 768px) {
            .col-lg-3 {
                width: 50%;
            }
        }

        @media (max-width: 576px) {

            .col-lg-3,
            .col-md-4 {
                width: 100%;
            }
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="card p-3">
                <div class="row">
                    <div class="col-4">
                        <div class="input-group justify-content-between">
                            <div class="relative" style="width: 70%">
                                <select id="searchableSelect"
                                    class="form-control w-full rounded-l-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select an Customer</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group-append">
                                <a href="{{ route('admin.customers.create') }}"
                                    class="btn btn-warning rounded-r-lg w-full flex items-center justify-center">
                                    <i class="fa fa-plus mr-2"></i> Add Customer
                                </a>
                            </div>
                        </div>

                    </div>
                    <div class="col-2">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary w-100">
                            <i class="fa fa-plus"></i> Add Product
                        </a>
                    </div>
                    <div class="col-6">
                        <div>
                            <input type="text" id="product_search" class="form-control" placeholder="Search Products..."
                                onkeyup="searchProduct()">
                            <ul id="search_results"
                                class="hidden border border-t-0 max-h-40 overflow-auto list-none pl-0 bg-white list-group"
                                style="z-index: 1000;position: absolute;width: 97%;">
                                <!-- Search results will be appended here -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-6">
                <div class="card" style="min-height: 330px;">
                    <div class="card-body">
                        <div style="max-height: 300px; overflow-y: auto;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Product</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Subtotal</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="selected_product_table">
                                    <!-- Selected products will appear here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-6">
                <div class="card" style="min-height: 420px">
                    <ul class="nav nav-tabs" id="category-tab" role="tablist">
                        @foreach ($categories as $category)
                            <li class="nav-item">
                                <a class="nav-link text-capitalize {{ $loop->first ? 'active' : '' }}"
                                    id="cat_{{ $category->id }}-tab" data-toggle="pill" href="#cat_{{ $category->id }}"
                                    role="tab" aria-controls="cat_{{ $category->id }}"
                                    aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content m-3" id="category-tabContent">
                        @foreach ($categories as $category)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                id="cat_{{ $category->id }}" role="tabpanel"
                                aria-labelledby="cat_{{ $category->id }}-tab">
                                <div class="scrollable-container">
                                    <div class="row">
                                        @foreach ($category->products as $product)
                                            <div class="col-lg-3 col-md-4 col-6 mb-2">
                                                <button class="info-box"
                                                    style="border: none; width: 100%; padding: 10px; cursor: pointer;"
                                                    onclick="selectProduct({{ $product->id }}, '{{ $product->product_name }}', {{ $product->price }})">
                                                    <div class="box-content">
                                                        <div class="image-container">
                                                            <img src="{{ asset('uploads/products/' . ($product->image ?? 'default_image.png')) }}"
                                                                alt="Product Image">
                                                        </div>
                                                        <div class="text-container">
                                                            <p class="box-title">{{ $product->product_name }}</p>
                                                            <p class="box-price">${{ $product->price }}</p>
                                                        </div>
                                                    </div>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
<script>
    function filterOptions() {
        const search = document.getElementById('search').value.toLowerCase();
        const select = document.getElementById('searchSelect');
        const options = select.options;

        for (let i = 1; i < options.length; i++) {
            const option = options[i];
            const text = option.text.toLowerCase();
            option.style.display = text.includes(search) ? '' : 'none';
        }
    }


    // Function to perform the search and show results
    function searchProduct() {
        const searchQuery = document.getElementById('product_search').value;
        const searchResults = document.getElementById('search_results');

        // If search length is less than 1, don't show results
        if (searchQuery.length < 1) {
            searchResults.innerHTML = '';
            searchResults.classList.add('hidden');
            return;
        }

        // Make AJAX call to get filtered results
        $.ajax({
            url: '{{ route('admin.pos.search') }}', // Update with your route
            type: 'GET',
            data: {
                search_query: searchQuery
            },
            success: function(response) {
                // Display the results
                let options = '';
                response.forEach(product => {
                    options += `
                <li class="cursor-pointer p-3 hover:bg-gray-100 hover:text-blue-600 transition-all ease-in-out duration-200 border-b border-gray-200 list-group-item" 
                    onclick="selectProduct(${product.id}, '${product.product_name}', ${product.price})">
                    <div class="flex items-left space-x-4">
                        <span>Product Name:</span>
                        <span class="me-5">${product.product_name}</span>
                        <span>Price:</span>
                        <span class="me-5">$${product.price}</span>
                        <span>Inventory:</span>
                        <span class="me-5">${product.qty}</span>
                    </div>
                </li>`;
                });
                searchResults.innerHTML = options;
                searchResults.classList.remove('hidden');
                searchResults.classList.remove('d-none');
            }
        });
    }

    function selectProduct(productId, productName, productPrice) {
    const tableBody = document.getElementById('selected_product_table');
    const existingRow = Array.from(tableBody.rows).find(row => row.getAttribute('data-id') == productId);
    const inputElement = document.getElementById('product_search');

    // Clear the search input and hide the results
    inputElement.value = '';
    const searchResults = document.getElementById('search_results');
    searchResults.classList.add('d-none');

    if (existingRow) {
        // If the product already exists in the table, update the quantity
        const qtyInput = existingRow.querySelector('.qty-input');
        qtyInput.value = parseInt(qtyInput.value) + 1;
        updateSubtotal(qtyInput, productPrice);
    } else {
        // If the product is not in the table, add it as a new row
        const rowCount = tableBody.rows.length + 1;
        const row = tableBody.insertRow();
        row.setAttribute('data-id', productId);

        row.innerHTML = `
            <td>${rowCount}</td>
            <td>${productName}</td>
            <td><input type="number" value="1" class="qty-input" onchange="updateSubtotal(this, ${productPrice})"></td>
            <td class="price">${productPrice.toFixed(2)}</td>
            <td class="subtotal">${productPrice.toFixed(2)}</td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeProduct(this)">
                    <i class="fa fa-times"></i>
                </button>
            </td>
        `;

        calculateTotalSubtotal(); // Add this line
    }
}

function calculateTotalSubtotal() {
    const subtotals = document.querySelectorAll('.subtotal');
    const qtyInputs = document.querySelectorAll('.qty-input');
    let total = 0;
    let totalQty = 0;

    subtotals.forEach(subtotal => {
        total += parseFloat(subtotal.textContent) || 0;  
    });

    qtyInputs.forEach(input => {
        totalQty += parseInt(input.value) || 0;  // Sum up the quantities
    });

    document.getElementById('total_subtotal').textContent = total.toFixed(2);  
    document.getElementById('sub_total').value = total.toFixed(2);
    document.getElementById('total').textContent = total.toFixed(2);
    document.getElementById('total_qty').textContent = totalQty;  // Display the total quantity

    if (parseFloat(document.getElementById('total_discount').textContent) === 0) {
        document.getElementById('total').textContent = total.toFixed(2);
    }
    document.getElementById('total_discount').textContent = "0.00";
    document.getElementById('total').textContent = document.getElementById('total_subtotal').textContent;
}

function updateSubtotal(inputElement, price) {
    const row = inputElement.closest('tr');
    let qty = parseInt(inputElement.value);

    if (qty <= 1) {
        qty = 1;
        inputElement.value = 1;
    }

    const subtotal = (qty * price).toFixed(2);
    row.querySelector('.subtotal').textContent = subtotal;

    calculateTotalSubtotal(); 
   
}

function removeProduct(button) {
    const row = button.closest('tr');
    row.remove();
    calculateTotalSubtotal(); // Recalculate after removal
    document.getElementById('total_discount').textContent = "0.00";
    document.getElementById('total').textContent = document.getElementById('total_subtotal').textContent;
}

</script>
