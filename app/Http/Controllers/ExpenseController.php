<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Expense::with('user')->orderBy('date', 'desc');

        // Employees only see their own expenses unless they are admin
        if (!Auth::user()->hasRole('super_admin|admin|manager')) {
            $query->where('user_id', Auth::id());
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $expenses = $query->paginate(15);
        return view('crm.crud.expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('crm.crud.expenses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string',
            'vendor_gstin' => 'nullable|string|max:15',
            'tax_percent' => 'nullable|numeric|min:0|max:100',
            'tax_amount' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'receipt' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $expense = new Expense();
        $expense->date = $request->date;
        $expense->amount = $request->amount;
        $expense->vendor_gstin = $request->vendor_gstin;
        $expense->tax_percent = $request->tax_percent ?? 0;
        $expense->tax_amount = $request->tax_amount ?? 0;
        $expense->category = $request->category;
        $expense->description = $request->description;
        $expense->user_id = Auth::id();
        $expense->status = 'Pending'; // Default status

        if ($request->hasFile('receipt')) {
            $path = $request->file('receipt')->storeOnCloudinary('expenses/receipts')->getSecurePath();
            $expense->receipt_path = $path;
        }

        $expense->save();

        notify()->success('Expense logged successfully. Waiting for approval.');
        return redirect()->route('expenses.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        // Check authorization
        if (!Auth::user()->hasRole('super_admin|admin|manager') && $expense->user_id != Auth::id()) {
            abort(403);
        }

        return view('crm.crud.expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        if (!Auth::user()->hasRole('super_admin|admin|manager') && $expense->user_id != Auth::id()) {
            abort(403);
        }

        return view('crm.crud.expenses.edit', compact('expense'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        if (!Auth::user()->hasRole('super_admin|admin|manager') && $expense->user_id != Auth::id()) {
            abort(403);
        }

        $request->validate([
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string',
            'vendor_gstin' => 'nullable|string|max:15',
            'tax_percent' => 'nullable|numeric|min:0|max:100',
            'tax_amount' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'receipt' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $expense->date = $request->date;
        $expense->amount = $request->amount;
        $expense->vendor_gstin = $request->vendor_gstin;
        $expense->tax_percent = $request->tax_percent ?? 0;
        $expense->tax_amount = $request->tax_amount ?? 0;
        $expense->category = $request->category;
        $expense->description = $request->description;

        // Admin can update status
        if (Auth::user()->hasRole('super_admin|admin|manager')) {
            if ($request->has('status')) {
                $expense->status = $request->status;
            }
        } else {
            // If user updates it, reset to pending
            $expense->status = 'Pending';
        }

        if ($request->hasFile('receipt')) {
            // Delete old receipt
            if ($expense->receipt_path) {
                Storage::disk('public')->delete($expense->receipt_path);
            }
            $path = $request->file('receipt')->storeOnCloudinary('expenses/receipts')->getSecurePath();
            $expense->receipt_path = $path;
        }

        $expense->save();

        notify()->success('Expense updated successfully.');
        return redirect()->route('expenses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        if (!Auth::user()->hasRole('super_admin|admin|manager') && $expense->user_id != Auth::id()) {
            abort(403);
        }

        if ($expense->receipt_path) {
            Storage::disk('public')->delete($expense->receipt_path);
        }

        $expense->delete();

        notify()->success('Expense deleted successfully.');
        return redirect()->route('expenses.index');
    }
}
