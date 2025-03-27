    <style>
        .output {
            font-size: 30px;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            width: 200px;
            margin: 0 auto;
        }

        .keypad {
            display: grid;
            grid-template-columns: repeat(3, 70px);
            grid-gap: 10px;
            max-width: 350px;
            margin: 20px auto;
        }

        .key {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 70px;
            height: 70px;
            background-color: #f0f0f0;
            border: 2px solid #ccc;
            font-size: 20px;
            cursor: pointer;
            user-select: none;
        }

        .key:active {
            background-color: #d0d0d0;
        }

        .clear-btn {
            grid-column: span 3;
            background-color: #ff6f61;
            color: white;
            border: none;
            font-size: 20px;
            cursor: pointer;
        }
    </style>

    <!-- Modal -->
    <div class="modal fade" id="modalDiscount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Dicount</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" enctype="multipart/form-data" id="form-discount">
                    <div class="modal-body">
                        <div class="grid grid-cols-2 gap-4 m-5">
                            <div class="">
                                <span>Discount by Percent:</span>
                                <input type="number" class="w-full p-3 border border-gray-300 rounded"
                                    id="discount_percentage" value="0">
                            </div>
                            <div class="">
                                <span>Discount by Amount:</span>
                                <input type="number" class="w-full p-3 border border-gray-300 rounded"
                                    id="discount_amount" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" type="submit" id="submitButton" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="paymentType" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl"> <!-- Large modal -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Payment Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Left Column: Calculator -->
                        <div class="col">
                            <div class="card max-w-lg mx-auto p-4 border rounded shadow-lg">
                                <div class="mb-3">
                                    <p>Total Amount (USD): $<span id="totalusd">0.00</span></p>
                                    <p>Total Amount (KHR): <span id="totalriel">0.00</span>៛</p>
                                </div>

                                <div class="grid grid-cols-3 gap-4">
                                    <div class="col-span-3">
                                        <input type="text" class="w-full p-3 border border-gray-300 rounded"
                                            id="output" disabled value="0">
                                    </div>

                                    <div class="grid grid-cols-3 gap-4 col-span-3">
                                        <button class="p-3 bg-gray-100 border border-gray-300 rounded hover:bg-gray-200"
                                            onclick="appendNumber('1')">1</button>
                                        <button class="p-3 bg-gray-100 border border-gray-300 rounded hover:bg-gray-200"
                                            onclick="appendNumber('2')">2</button>
                                        <button class="p-3 bg-gray-100 border border-gray-300 rounded hover:bg-gray-200"
                                            onclick="appendNumber('3')">3</button>
                                        <button class="p-3 bg-gray-100 border border-gray-300 rounded hover:bg-gray-200"
                                            onclick="appendNumber('4')">4</button>
                                        <button class="p-3 bg-gray-100 border border-gray-300 rounded hover:bg-gray-200"
                                            onclick="appendNumber('5')">5</button>
                                        <button class="p-3 bg-gray-100 border border-gray-300 rounded hover:bg-gray-200"
                                            onclick="appendNumber('6')">6</button>
                                        <button class="p-3 bg-gray-100 border border-gray-300 rounded hover:bg-gray-200"
                                            onclick="appendNumber('7')">7</button>
                                        <button class="p-3 bg-gray-100 border border-gray-300 rounded hover:bg-gray-200"
                                            onclick="appendNumber('8')">8</button>
                                        <button class="p-3 bg-gray-100 border border-gray-300 rounded hover:bg-gray-200"
                                            onclick="appendNumber('9')">9</button>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4 col-span-3">
                                        <button
                                            class="p-3 bg-red-500 text-white border border-gray-300 rounded hover:bg-red-600"
                                            onclick="clearOutput()">Clear</button>
                                        <button class="p-3 bg-gray-100 border border-gray-300 rounded hover:bg-gray-200"
                                            onclick="appendNumber('0')">0</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Middle Column: Payment Types -->
                        <div class="col">
                            <div class="card max-w-lg mx-auto p-4 border rounded shadow-lg">
                                <h1 class="mb-3">Payment Type</h1>
                                @foreach ($paymenttypes as $paymenttype)
                                    <div class="grid grid-cols-2 gap-4">
                                        <button
                                            class="btn btn-primary text-center bg-blue-500 text-white p-3 rounded m-2"
                                            onclick="addPayment('{{ $paymenttype->name }}')">{{ $paymenttype->name }}</button>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Right Column: Payment Summary Table -->
                        <div class="col">
                            <table class="table-auto w-full border-collapse border border-gray-300">
                                <thead>
                                    <tr>
                                        <th class="border border-gray-300 p-2">Payment Type</th>
                                        <th class="border border-gray-300 p-2">Amount</th>
                                        <th class="border border-gray-300 p-2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="paymentTableBody">
                                    <!-- Payments will be inserted here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end me-5">
                        <p>Balance: $<span id="balanceAmount">0.00</span></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="savePayments()">Save</button>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid">
        <footer class="footer position-fixed bottom-0 w-100">
            <div class="row">
                <div class="col-6">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td class="text-end fw-bold w-2/3">Count :</td>
                                <td class="text-end w-1/3" id="total_qty">0.00</td>
                            </tr>
                            <tr>
                                <td class="text-end fw-bold w-2/3">Discount :</td>
                                <td class="text-end w-1/3" id="total_discount">0.00</td>
                                <input type="hidden" id="discount_value">
                            </tr>
                            <tr>
                                <td class="text-end fw-bold w-2/3">SubTotal :</td>
                                <td class="text-end w-1/3" id="total_subtotal">0.00</td>
                                <input type="hidden" name="" id="sub_total">
                            </tr>
                            <tr>
                                <td class="text-end fw-bold w-2/3">GrandTotal :</td>
                                <td class="text-end w-1/3" id="total">0.00</td>
                            </tr>
                            <tr>
                                <td class="text-end fw-bold w-2/3">Total KHR :</td>
                                <td class="text-end w-1/3" id="total_khr">0.00</td>
                                <input type="hidden" id="exchange_rate" value="1">
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-6">
                    <div class="row position-absolute bottom-0 w-100 mr-2">
                        <div class="col-lg-3 col-6">
                            <button class="small-box bg-warning text-white" data-bs-toggle="modal"
                                data-bs-target="#modalDiscount"
                                style="border: none; width: 100%; padding: 3px; cursor: pointer;">
                                <div class="inner">
                                    <i class="fas fa-tag " style="font-size: 1.5rem;"></i>
                                    <p>Discount</p>
                                </div>
                            </button>
                        </div>
                        <div class="col-lg-3 col-6">
                            <button class="small-box bg-info"
                                style="border: none; width: 100%; padding:  3px; cursor: pointer;"
                                data-bs-toggle="modal" data-bs-target="#paymentType">
                                <div class="inner">
                                    <i class="fas fa-credit-card" style="font-size: 1.5rem;;"></i>
                                    <p>Payment Type</p>
                                </div>
                            </button>
                        </div>
                        <div class="col-lg-3 col-6">
                            <button class="small-box bg-danger"
                                style="border: none; width: 100%; padding:  3px; cursor: pointer;">
                                <div class="inner">
                                    <i class="fa fa-undo" style="font-size: 1.5rem;;"></i>
                                    <p>Return</p>
                                </div>
                            </button>
                        </div>
                        <div class="col-lg-3 col-6">
                            <button class="small-box bg-success" onclick="storeSale()"
                                style="border: none; width: 100%; padding:  3px;  cursor: pointer;">
                                <div class="inner">
                                    <i class="fa fa-save" style="font-size: 1.5rem;"></i>
                                    <p>Submit</p>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        const outputElement = document.getElementById('output');

        // Keyboard shortcuts
        document.addEventListener('keydown', function(event) {
            const key = event.key;
            if (!isNaN(key)) {
                appendNumber(key);
            } else if (key === 'Backspace') {
                backspace();
            } else if (key === 'Enter') {
                const firstPaymentType = document.querySelector('.btn-primary');
                if (firstPaymentType) firstPaymentType.click();
            } else if (key === 'Escape') {
                clearOutput();
            }
        });

        // Append number to the display
        function appendNumber(number) {
            if (outputElement.value === '0') {
                outputElement.value = number;
            } else {
                outputElement.value += number;
            }
        }

        // Remove last number
        function backspace() {
            outputElement.value = outputElement.value.slice(0, -1);
            if (outputElement.value === '') {
                outputElement.value = '0';
            }
        }

        // Clear output
        function clearOutput() {
            outputElement.value = '0';
        }

        // Add payment row to the table
        function addPayment(paymentType) {
            const amount = outputElement.value;

            if (amount === '0' || amount === '') {
                alert('Please enter an amount first');
                return;
            }

            const tableBody = document.getElementById('paymentTableBody');
            const newRow = document.createElement('tr');

            newRow.innerHTML = `
        <td class="border border-gray-300 p-2">${paymentType}</td>
        <td class="border border-gray-300 p-2">${amount}</td>
        <td class="border border-gray-300 p-2">
            <button class="bg-red-500 text-white px-2 py-1 rounded" onclick="removeRow(this)">Remove</button>
        </td>
    `;

            tableBody.appendChild(newRow);
            clearOutput();
        }

        // Remove a row from the table
        function removeRow(button) {
            const row = button.parentElement.parentElement;
            row.remove();
        }

        // Save payments function
        function savePayments() {
            const rows = document.querySelectorAll('#paymentTableBody tr');
            const payments = [];

            rows.forEach(row => {
                const paymentType = row.cells[0].textContent;
                const amount = parseFloat(row.cells[1].textContent);
                payments.push({
                    paymentType,
                    amount
                });
            });

            // Here you can send the payments array to your server using an API or log it
            console.log('Payments to save:', payments);

            // Optionally, you can close the modal after saving
            $('#paymentType').modal('hide');
        }

        function updateBalance() {
            const totalUsd = parseFloat(document.getElementById('totalusd').textContent) || 0;
            let totalPaid = 0;

            document.querySelectorAll('#paymentTableBody tr').forEach(row => {
                totalPaid += parseFloat(row.cells[1].textContent) || 0;
            });

            const balance = totalUsd - totalPaid;
            document.getElementById('balanceAmount').textContent = balance.toFixed(2);
        }

        // Modify `addPayment()` and `removeRow()` to call `updateBalance()`

        function addPayment(paymentType) {
            const amount = parseFloat(outputElement.value) || 0;

            if (amount === 0) {
                alert('Please enter an amount first');
                return;
            }

            const tableBody = document.getElementById('paymentTableBody');
            const newRow = document.createElement('tr');

            newRow.innerHTML = `
        <td class="border border-gray-300 p-2">${paymentType}</td>
        <td class="border border-gray-300 p-2">${amount.toFixed(2)}</td>
        <td class="border border-gray-300 p-2">
            <button class="bg-red-500 text-white px-2 py-1 rounded" onclick="removeRow(this)">Remove</button>
        </td>
    `;

            tableBody.appendChild(newRow);
            clearOutput();
            updateBalance();
        }

        function removeRow(button) {
            button.parentElement.parentElement.remove();
            updateBalance();
        }

        $(document).ready(function() {
            // Calculate Total Subtotal
            calculateTotalSubtotal();

            // When clicking on submit button in the modal
            $('#submitButton').on('click', function(event) {
                event.preventDefault();

                // Get Discount Values
                const discountPercentage = parseFloat($('#discount_percentage').val()) || 0;
                const discountAmount = parseFloat($('#discount_amount').val()) || 0;

                // Get SubTotal Value
                const subTotal = parseFloat($('#sub_total').val()) || 0;

                let total = subTotal;

                // Apply Discount Percentage
                if (discountPercentage > 0) {
                    const discount = (subTotal * discountPercentage) / 100;
                    total = subTotal - discount;
                    $('#total').text(total.toFixed(2));
                    $('#total_discount').text(discount.toFixed(2));
                    $('#discount_value').val(discount);
                    $('#totalusd').text(total.toFixed(2));
                    console.log('Discount Applied (Percentage):', total); // Log for debugging
                }
                // Apply Discount Amount
                else if (discountAmount > 0) {
                    total = subTotal - discountAmount;
                    $('#total').text(total.toFixed(2));
                    $('#total_discount').text(discountAmount.toFixed(2));
                    $('#discount_value').val(discountAmount);
                    $('#totalusd').text(total.toFixed(2));
                    console.log('Discount Applied (Amount):', total); // Log for debugging
                } else {
                    $('#total_discount').text(0);
                    $('#total').text(subTotal.toFixed(2));
                    $('#totalusd').text(subTotal.toFixed(2));
                }

                // Calculate Total KHR
                const totalKhr = total * exchangeRate;
                $('#total_khr').text(totalKhr.toFixed(2));
                $('#totalriel').text(totalKhr.toFixed(2));

                console.log('Total KHR:', totalKhr); // Log for debugging

                // Close the Discount Modal
                $('#modalDiscount').modal('hide');
            });
        });
    </script>
