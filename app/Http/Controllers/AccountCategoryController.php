<?php

namespace App\Http\Controllers;

use App\Models\AccountCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AccountCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('pages.category.index', [
            'categories' => AccountCategory::paginate(10)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string',
            'type' => 'required|in:debit,credit'
        ]);

        try {
            AccountCategory::create($data);

            session()->flash('notification', [
                'variant' => 'success',
                'title' => 'Success',
                'message' => 'Category has been created successfully.'
            ]);

            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('notification', [
                'variant' => 'error',
                'title' => 'Error',
                'message' => 'Something went wrong in our server. Please try again later.'
            ]);
            Log::error($e->getMessage());

            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AccountCategory $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AccountCategory $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccountCategory $category)
    {
        try {
            $category->delete();

            session()->flash('notification', [
                'variant' => 'success',
                'title' => 'Success',
                'message' => 'Category has been deleted successfully.'
            ]);

            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('notification', [
                'variant' => 'error',
                'title' => 'Error',
                'message' => 'Something went wrong in our server. Please try again later.'
            ]);
            Log::error($e->getMessage());

            return redirect()->back();
        }
    }
}
