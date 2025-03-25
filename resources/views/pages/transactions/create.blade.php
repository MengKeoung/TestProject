@extends('layouts.app')

@section('content')
    <div class="container fluid">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="text-dark font-weight-bold">{{ __('Create Transaction') }}</h1>
                    </div>
                </div>
            </div>
        </section>
    
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- Input Section - 8 columns -->
                    <div class="col-md-8">
                        <form id="createForm" method="POST" action="#" enctype="multipart/form-data">
                            @csrf
                            <!-- Products Card -->
                            <div class="card shadow-sm">
                                <div class="card-header bg-primary">
                                    <h3 class="card-title text-white mb-0">{{ __('Products') }}</h3>
                                </div>
                                <div class="card-body bg-light">
                                    <!-- Hidden product row template -->
                                    <template id="product-template">
                                        <div class="product-item row mb-3">
                                            <div class="col-md-5">
                                                <select name="product_id[]" class="form-control product-select" onchange="calculateTotals()" required>
                                                    <option value="">Select Product</option>
                                                    @foreach ($products as $product)
                                                        @if ($product->status == 1)
                                                            <option value="{{ $product->id }}" data-name="{{ $product->product_name }}" data-price="{{ $product->price }}">
                                                                {{ $product->product_name }} - ${{ $product->price }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('product_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" name="qty[]" class="form-control" placeholder="Quantity" oninput="calculateTotals()" required>
                                                @error('qty')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-2">
                                                <select name="discount_type[]" class="form-control" onchange="calculateTotals()" required>
                                                    <option value="percent">Percent (%)</option>
                                                    <option value="fix">Fixed ($)</option>
                                                </select>
                                                @error('discount_type')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" name="discount[]" class="form-control" placeholder="Discount" oninput="calculateTotals()" required>
                                                @error('discount')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-danger btn-sm remove-product">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </template>
    
                                    <!-- Product list container -->
                                    <div id="product-list">
                                        <!-- Initial, static product row -->
                                        <div class="product-item row mb-3">
                                            <div class="col-md-5">
                                                <select name="product_id[]" class="form-control product-select" onchange="calculateTotals()" required>
                                                    <option value="">Select Product</option>
                                                    @foreach ($products as $product)
                                                        @if ($product->status == 1)
                                                            <option value="{{ $product->id }}" data-name="{{ $product->product_name }}" data-price="{{ $product->price }}">
                                                                {{ $product->product_name }} - ${{ $product->price }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('product_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" name="qty[]" class="form-control" placeholder="Quantity" oninput="calculateTotals()" required>
                                                @error('qty')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-2">
                                                <select name="discount_type[]" class="form-control" onchange="calculateTotals()" required>
                                                    <option value="percent">Percent (%)</option>
                                                    <option value="fix">Fixed ($)</option>
                                                </select>
                                                @error('discount_type')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" name="discount[]" class="form-control" placeholder="Discount" oninput="calculateTotals()" required>
                                                @error('discount')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-danger btn-sm remove-product">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" id="add-product" class="btn btn-success mt-2">
                                        <i class="fas fa-plus mr-1"></i> Add Product
                                    </button>
                                </div>
                            </div>
                            <!-- Transaction Details Card -->
                            <div class="card shadow-sm mt-4">
                                <div class="card-header bg-primary">
                                    <h3 class="card-title text-white mb-0">{{ __('Transaction Details') }}</h3>
                                </div>
                                <div class="card-body bg-light">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="required_lable" for="customer_id">{{ __('Customer') }}</label>
                                            <div class="input-group">
                                                <select name="customer_id" id="customer_id" class="form-control select2 @error('customer_id') is-invalid @enderror" onchange="updateReport()" required>
                                                    <option value="">{{ __('N/A') }}</option>
                                                    @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}" data-name="{{ $customer->name }}" data-phone="{{ $customer->phone }}" data-email="{{ $customer->email }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                                        {{ $customer->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#addCustomerModal">
                                                        <i class="fas fa-plus"></i> {{ __('Add New') }}
                                                    </button>
                                                </div>
                                            </div>
                                            @error('customer_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="booking_date" class="font-weight-bold">{{ __('Booking Date') }}</label>
                                                <input type="date" name="booking_date" id="booking_date" class="form-control" oninput="updateReport()" required>
                                                @error('booking_date')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="payment_method" class="font-weight-bold">{{ __('Payment Method') }}</label>
                                                <select name="payment_method" id="payment_method" class="form-control" onchange="updateReport()" required>
                                                    <option value="">Select Payment Method</option>
                                                    <option value="cash">Cash</option>
                                                    <option value="credit_card">Credit Card</option>
                                                    <option value="bank_transfer">Bank Transfer</option>
                                                    <option value="digital_wallet">Digital Wallet</option>
                                                </select>
                                                @error('payment_method')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sub_total" class="font-weight-bold">{{ __('Sub Total') }}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">$</span>
                                                    </div>
                                                    <input type="text" name="sub_total" id="sub_total" class="form-control" oninput="updateReport()" required>
                                                    @error('sub_total')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="final_total" class="font-weight-bold">{{ __('Final Total') }}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">$</span>
                                                    </div>
                                                    <input type="text" name="final_total" id="final_total" class="form-control" oninput="updateReport()" required>
                                                    @error('final_total')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right mt-3">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save mr-1"></i> Save Transaction
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
    
                    <!-- Transaction Report - 4 columns -->
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-success">
                                <h3 class="card-title text-white mb-0">
                                    <i class="fas fa-file-alt mr-2"></i>Transaction Report
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <div class="mb-3">
                                            <span class="text-muted">Invoice Number</span>
                                            <h5 id="report-invoice-number" class="mb-0">INV-{{ strtoupper(uniqid()) }}</h5>
                                        </div>
                                        <div class="mb-3">
                                            <span class="text-muted">Customer</span>
                                            <h5 id="report-customer" class="mb-0">N/A</h5>
                                        </div>
                                        <div class="mb-3">
                                            <span class="text-muted">Booking Date</span>
                                            <h5 id="report-booking-date" class="mb-0">N/A</h5>
                                        </div>
                                        <div class="mb-3">
                                            <span class="text-muted">Payment Method</span>
                                            <h5 id="report-payment-method" class="mb-0">N/A</h5>
                                        </div>
                                        <div class="mb-3">
                                            <span class="text-muted">Sub Total</span>
                                            <h5 class="mb-0">$<span id="report-sub-total">0.00</span></h5>
                                        </div>
                                        <div class="mb-3">
                                            <span class="text-muted">Final Total</span>
                                            <h5 class="mb-0">$<span id="report-final-total">0.00</span></h5>
                                        </div>
                                    </div>
                                </div>
    
                                <h5 class="mt-4 mb-3 font-weight-bold">Products</h5>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Product</th>
                                                <th>Qty</th>
                                                <th>Discount</th>
                                            </tr>
                                        </thead>
                                        <tbody id="report-products"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    
        <!-- Add Customer Modal -->
        <div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog" aria-labelledby="addCustomerModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="addCustomerModalLabel">Add New Customer</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="addCustomerForm" method="POST" action="{{ route('admin.customers.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" name="redirect_to" value="transaction_create">
    
                                <!-- First Name -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="required">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="required">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                </div>
    
                                <!-- Phone -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone" class="required">Phone</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" required>
                                    </div>
                                </div>    
                            </div>
                        </div>
    
                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="saveCustomer">
                                <i class="fas fa-save mr-1"></i> Save Customer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        document.getElementById('add-product').addEventListener('click', function () {
            let productList = document.getElementById('product-list');
            let template = document.getElementById('product-template').content.cloneNode(true);
            productList.appendChild(template);
        });

        function updateReport() {
            const customerSelect = document.getElementById('customer_id');
            const customerText = customerSelect.options[customerSelect.selectedIndex]?.text || 'N/A';
            document.getElementById('report-customer').textContent = customerText;

            const bookingDate = document.getElementById('booking_date').value;
            const paymentMethod = document.getElementById('payment_method').value;
            const subTotal = document.getElementById('sub_total').value;
            const finalTotal = document.getElementById('final_total').value;

            document.getElementById('report-booking-date').textContent = bookingDate || 'N/A';
            document.getElementById('report-payment-method').textContent = paymentMethod || 'N/A';
            document.getElementById('report-sub-total').textContent = subTotal || '0.00';
            document.getElementById('report-final-total').textContent = finalTotal || '0.00';

            const productRows = document.querySelectorAll('.product-item');
            const reportProducts = document.getElementById('report-products');
            reportProducts.innerHTML = '';

            productRows.forEach(product => {
                const productSelect = product.querySelector('.product-select');
                const productName = productSelect.options[productSelect.selectedIndex]?.dataset?.name || 'N/A';
                const qty = product.querySelector('[name="qty[]"]').value;
                const discountType = product.querySelector('[name="discount_type[]"]').value;
                const discount = product.querySelector('[name="discount[]"]').value;

                const row = `<tr>
                                                <td>${productName}</td>
                                                <td>${qty}</td>
                                                <td>${discount} ${discountType === 'percent' ? '%' : '$'}</td>
                                            </tr>`;
                reportProducts.insertAdjacentHTML('beforeend', row);
            });
        }

        document.getElementById('product-list').addEventListener('click', function (e) {
            const target = e.target;
            const removeButton = target.closest('.remove-product');
            if (removeButton) {
                const productItem = removeButton.closest('.product-item');
                productItem.remove();
                updateReport();
            }
        });

        function calculateTotals() {
            let subTotal = 0;
            let finalTotal = 0;
            const products = document.querySelectorAll('.product-item');

            products.forEach(product => {
                const selectedOption = product.querySelector('.product-select option:checked');
                const basePrice = selectedOption.dataset.price ? parseFloat(selectedOption.dataset.price) : 1;
                const qty = parseFloat(product.querySelector('[name="qty[]"]').value) || 0;
                const discountType = product.querySelector('[name="discount_type[]"]').value;
                const discount = parseFloat(product.querySelector('[name="discount[]"]').value) || 0;

                const productTotal = qty * basePrice;
                let discountAmount = 0;

                if (discountType === 'percent') {
                    discountAmount = (productTotal * discount) / 100;
                } else if (discountType === 'fix') {
                    discountAmount = discount;
                }

                subTotal += productTotal;
                finalTotal += productTotal - discountAmount;
            });

            document.getElementById('sub_total').value = subTotal.toFixed(2);
            document.getElementById('final_total').value = finalTotal.toFixed(2);
            updateReport();
        }


        document.getElementById('createForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.disabled = true;

            // Retrieve customer information from the select element
            const customerSelect = document.getElementById('customer_id');
            const selectedOption = customerSelect.options[customerSelect.selectedIndex];
            const customerId = parseInt(customerSelect.value) || null;
            const guestInfo = customerId ? [{
                name: selectedOption.getAttribute('data-name') || 'N/A',
                phone: selectedOption.getAttribute('data-phone') || 'N/A',
                email: selectedOption.getAttribute('data-email') || 'N/A'
            }] : [];

            // Gather other form fields
            const subTotal = parseFloat(document.getElementById('sub_total').value) || 0;
            const finalTotal = parseFloat(document.getElementById('final_total').value) || 0;
            const bookingDate = document.getElementById('booking_date').value || '';
            const paymentMethod = document.getElementById('payment_method').value || '';

            const sellLines = [];
            document.querySelectorAll('.product-item').forEach(product => {
                const productSelect = product.querySelector('.product-select');
                const productId = productSelect.value;
                if (productId) {
                    const qty = parseFloat(product.querySelector('[name="qty[]"]').value) || 0;
                    const discountType = product.querySelector('[name="discount_type[]"]').value;
                    const discountAmount = parseFloat(product.querySelector('[name="discount[]"]').value) || 0;
                    const selectedOpt = productSelect.options[productSelect.selectedIndex];
                    const basePrice = parseFloat(selectedOpt.dataset.price) || 0;
                    const lineSubTotal = qty * basePrice;
                    let lineFinalTotal = lineSubTotal;
                    if (discountType === 'percent') {
                        lineFinalTotal = lineSubTotal - ((lineSubTotal * discountAmount) / 100);
                    } else if (discountType === 'fix') {
                        lineFinalTotal = lineSubTotal - discountAmount;
                    }
                    sellLines.push({
                        product_id: parseInt(productId),
                        qty,
                        discount_type: discountType,
                        discount_amount: discountAmount,
                        sub_total: lineSubTotal.toFixed(2),
                        final_total: lineFinalTotal.toFixed(2)
                    });
                }
            });

            const requestData = {
                customer_id: customerId,
                sub_total: subTotal.toFixed(2),
                final_total: finalTotal.toFixed(2),
                payment_status: "unpaid",
                status: "request",
                booking_date: bookingDate,
                payment_method: paymentMethod,
                guest_info: guestInfo,
                sell_lines: sellLines
            };

            fetch("{{ route('admin.transactions.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify(requestData)
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Success', data);
                    if (data.status === 1) {
                        window.location.href = "{{ route('admin.transactions.index') }}" + "?msg=" + encodeURIComponent(data.msg);
                    } else {
                        toastr.error(data.msg);
                        submitButton.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    submitButton.disabled = false;
                    toastr.error('An error occurred. Please try again.');
                });
        });
    </script>
@endpush
