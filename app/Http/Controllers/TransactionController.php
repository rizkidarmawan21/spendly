<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = Account::with([
            'category' => fn($query) => $query->select(['id', 'type']),
        ])->get();

        return view('pages.transaction.index', [
            'transactions' => Transaction::with(['account', 'account.category'])->get(),
            'accounts' => $accounts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric',
            'date' => 'nullable|date',
            'description' => 'nullable|string'
        ]);

        $category = Account::find($request->account_id)->category;
        if (!$category) {
            session()->flash('notification', [
                'variant' => 'danger',
                'title' => 'Error',
                'message' => 'Account category not found.'
            ]);

            return redirect()->back();
        }

        try {
            $data = $request->only(['account_id', 'amount', 'date', 'description']);

            $data['type'] = $category->type;
            $data['date'] = $data['date'] ?? now();

            Transaction::create($data);

            session()->flash('notification', [
                'variant' => 'success',
                'title' => 'Success',
                'message' => 'Transaction has been created successfully.'
            ]);

            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('notification', [
                'variant' => 'danger',
                'title' => 'Error',
                'message' => 'Something went wrong in our server. Please try again later.'
            ]);
            Log::error($e->getMessage());

            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'description' => 'nullable|string'
        ]);

        $category = Account::find($request->id)->category;
        if (!$category) {
            session()->flash('notification', [
                'variant' => 'danger',
                'title' => 'Error',
                'message' => 'Account category not found.'
            ]);

            return redirect()->back();
        }

        try {
            $data = $request->only(['amount', 'date', 'description']);

            $data['type'] = $category->type;
            $data['date'] = $data['date'] ?? now();

            $transaction->update($data);

            session()->flash('notification', [
                'variant' => 'success',
                'title' => 'Success',
                'message' => 'Transaction has been updated successfully.'
            ]);

            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('notification', [
                'variant' => 'danger',
                'title' => 'Error',
                'message' => 'Something went wrong in our server. Please try again later.'
            ]);
            Log::error($e->getMessage());

            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        try {
            $transaction->delete();

            session()->flash('notification', [
                'variant' => 'success',
                'title' => 'Success',
                'message' => 'Transaction has been deleted successfully.'
            ]);

            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('notification', [
                'variant' => 'danger',
                'title' => 'Error',
                'message' => 'Something went wrong in our server. Please try again later.'
            ]);
            Log::error($e->getMessage());

            return redirect()->back();
        }
    }
}
