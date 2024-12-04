<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.account.index', [
            'accounts' => Account::with('category')->get(),
            'categories' => AccountCategory::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'code' => 'nullable|numeric|unique:accounts,code',
            'category_id' => 'required|exists:account_categories,id',
        ]);

        try {
            $data = $request->only(['name', 'code', 'category_id']);

            if (empty($request->code)) {
                $data['code'] = $this->generateCode($data['category_id']);
            }

            Account::create($data);

            session()->flash('notification', [
                'variant' => 'success',
                'title' => 'Success',
                'message' => 'Account has been created successfully.'
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
    public function update(Request $request, Account $account)
    {
        $request->validate([
            'name' => 'required|string',
            'code' => 'required|numeric|unique:accounts,code,' . $account->id,
            'category_id' => 'required|exists:account_categories,id',
        ]);

        try {
            $data = $request->only(['name', 'code', 'category_id']);

            $account->update($data);

            session()->flash('notification', [
                'variant' => 'success',
                'title' => 'Success',
                'message' => 'Account has been updated successfully.'
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
    public function destroy(Account $account)
    {
        try {
            $account->delete();

            session()->flash('notification', [
                'variant' => 'success',
                'title' => 'Success',
                'message' => 'Account has been deleted successfully.'
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

    private function generateCode($category)
    {
        $category = AccountCategory::find($category);

        $initCode = $category->type === 'debit' ? 6 : 4;

        $count =
            Account::with('category')->whereHas('category', function ($query) use ($category) {
                $query->where('type', $category->type);
            })->count();


        $code = 0;

        if ($count === 0) {
            $code = (int) $initCode . '01';
        } else {
            do {
                // Fetch the last account with the same category type
                $lastAccount = Account::with('category')->whereHas('category', function ($query) use ($category) {
                    $query->where('type', $category->type);
                })
                    ->orderBy('code', 'desc')
                    ->first();

                // Get the last code, increment it and prepare the new code
                $lastCode = $code ?: $lastAccount->code;
                $lastCode = (int) $lastCode;
                $lastCode = $lastCode + 1;

                $code = $lastCode;

                // Set the code for the new account
            } while (Account::where('code', $code)->exists()); // Check if the generated code already exists
        }

        return $code;
    }
}
