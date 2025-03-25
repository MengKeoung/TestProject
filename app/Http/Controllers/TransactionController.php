<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Products;
use App\Models\Transaction;
use App\Models\TransactionSellLine;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Exception;


class TransactionController extends Controller
{
    public function index()
    {
        $paymentStatuses = Transaction::select('payment_status')->distinct()->get();
        $transactions = Transaction::latest('id')->paginate(10);
        $sellLines = TransactionSellLine::latest('id')->paginate(10);
        return view('pages.transactions.index', compact('transactions', 'sellLines', 'paymentStatuses'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $transactions = Transaction::with('customer') 
            ->where('booking_date', 'like', "%{$search}%")
            ->orWhere('payment_status', 'like', "%{$search}%")
            ->orWhereHas('customer', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%"); 
            })
            ->orderBy('id', 'desc')
            ->paginate(10); // Use paginate instead of get() for pagination

        return view('pages.transactions.table', compact('transactions', 'search'))->render(); // Pass the paginated products to the view
    }
    public function filterPaymentstatus(Request $request)
    {
        // Get all unique payment statuses
        $paymentStatuses = Transaction::select('payment_status')->distinct()->get();
    
        // Get the selected payment status from the request
        $paymentStatus = $request->input('payment_status');
    
        // Filter transactions by the selected payment status if available
        $transactions = Transaction::when($paymentStatus, function ($query) use ($paymentStatus) {
                $query->where('payment_status', $paymentStatus);
            })
            ->paginate(10); // Use pagination if you're using it in the view
    
        // Return view with transactions and payment statuses
        return view('pages.transactions.table', compact('transactions', 'paymentStatuses'))->render();
    }
    

    public function create()
    {
        $user = User::pluck('name', 'id');
        $customers = Customer::all();
        $products = Products::select('id', 'product_name', 'price', 'status')->get();

        return view('pages.transactions.create', compact('user', 'products', 'customers'));
    }
    public function store(Request $request)
    {
        $rules = [
            'customer_id' => 'required|integer',
            'sub_total' => 'required|numeric',
            'final_total' => 'required|numeric',
            'payment_status' => 'required|in:paid,unpaid',
            'status' => 'required|in:request,confirmed,cancel',
            'booking_date' => 'required|date',
            'payment_method' => 'required|string',
            'guest_info' => 'required|array',
            'sell_lines' => 'required|array|min:1',
            'sell_lines.*.product_id' => 'required|integer',
            'sell_lines.*.qty' => 'required|numeric|min:1',
            'sell_lines.*.discount_type' => 'required|in:percent,fix',
            'sell_lines.*.discount_amount' => 'required|numeric|min:0',
            'sell_lines.*.sub_total' => 'required|numeric|min:0',
            'sell_lines.*.final_total' => 'required|numeric|min:0',
        ];

        $validatedData = $request->validate($rules);

        try {
            DB::beginTransaction();

            $guestInfoJson = json_encode($validatedData['guest_info']);
            $invoiceNo = 'INV-' . strtoupper(uniqid());

            $transaction = Transaction::create([
                // 'user_id' => auth()->id(),
                'customer_id' => $validatedData['customer_id'],
                'guest_info' => $guestInfoJson,
                'sub_total' => $validatedData['sub_total'],
                'final_total' => $validatedData['final_total'],
                'invoice_no' => $invoiceNo,
                'booking_date' => $validatedData['booking_date'],
                'payment_method' => $validatedData['payment_method'],
                'payment_status' => $validatedData['payment_status'],
                'status' => $validatedData['status'],
                // 'created_by' => auth()->id(),
            ]);

            foreach ($validatedData['sell_lines'] as $line) {
                TransactionSellLine::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $line['product_id'],
                    'qty' => $line['qty'],
                    'discount_type' => $line['discount_type'],
                    'discount_amount' => $line['discount_amount'],
                    'sub_total' => $line['sub_total'],
                    'final_total' => $line['final_total'],
                    // 'created_by' => auth()->id(),
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => 1,
                'msg' => 'Transaction created successfully!',
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 0,
                'msg' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function edit($id)
    {
        $transaction = Transaction::with('transactionSellLines.product', 'customer')->findOrFail($id);
        // $user = User::pluck('name', 'id');
        $customers = Customer::all();
        $products = Products::select('id', 'product_name', 'price', 'status')->get();

        return view('pages.transactions.edit', compact('transaction', 'products', 'customers'));
    }
    public function update(Request $request, $id)
    {
        // Validation rules
        $rules = [
            'customer_id'      => 'required|integer',
            'sub_total'        => 'required|numeric',
            'final_total'      => 'required|numeric',
            'payment_status'   => 'required|in:paid,unpaid',
            'status'           => 'required|in:request,confirmed,cancel',
            'booking_date'     => 'required|date',
            'payment_method'   => 'required|string',
            'sell_lines'       => 'required|array|min:1',
            'sell_lines.*.product_id'      => 'required|integer',
            'sell_lines.*.qty'             => 'required|numeric|min:1',
            'sell_lines.*.discount_type'   => 'required|in:percent,fix',
            'sell_lines.*.discount_amount' => 'required|numeric|min:0',
            'sell_lines.*.sub_total'       => 'required|numeric|min:0',
            'sell_lines.*.final_total'     => 'required|numeric|min:0',
        ];

        // Validate the request
        $validatedData = $request->validate($rules);

        try {
            // Begin a database transaction
            DB::beginTransaction();

            // Find the transaction to update
            $transaction = Transaction::findOrFail($id);

            $customer = Customer::findOrFail($validatedData['customer_id']);
            $guestInfo = [
                'name' => $customer->name,
                'phone' => $customer->phone,
                'email' => $customer->email,
            ];

            // Update the transaction
            $transaction->update([
                'customer_id' => $validatedData['customer_id'],
                'guest_info'  => json_encode([$guestInfo]),
                'sub_total' => $validatedData['sub_total'],
                'final_total' => $validatedData['final_total'],
                'booking_date' => $validatedData['booking_date'],
                'payment_method' => $validatedData['payment_method'],
                'payment_status' => $validatedData['payment_status'],
                'status' => $validatedData['status'],
                // 'updated_by' => auth()->id(),
            ]);

            // Delete existing sell lines
            $transaction->transactionSellLines()->delete();

            // Add new sell lines
            foreach ($validatedData['sell_lines'] as $line) {
                TransactionSellLine::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $line['product_id'],
                    'qty' => $line['qty'],
                    'discount_type' => $line['discount_type'],
                    'discount_amount' => $line['discount_amount'],
                    'sub_total' => $line['sub_total'],
                    'final_total' => $line['final_total'],
                    // 'created_by' => auth()->id(),
                ]);
            }

            // Commit the transaction
            DB::commit();

            return response()->json([
                'status' => 1,
                'msg' => 'Transaction Updated successfully!',
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 0,
                'msg' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function destroy($id)
{
    try {
        DB::beginTransaction();
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        DB::commit();
        return redirect()->route('admin.transactions.index')->with('success', __('Deleted successfully'));
    } catch (Exception $e) {
        DB::rollBack();
        return redirect()->route('admin.transactions.index')->with('error', __('Something went wrong'));
    }
}

}
