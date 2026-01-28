<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransactionController extends Controller
{
    public function index()
    {
        return Inertia::render('transactions/Index', [
            'transactions' => auth()->user()
                ->transactions()
                ->latest()
                ->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', 'in:income,expense'],
            'description' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
        ]);

        $request->user()->transactions()->create($validated);

        return back();
    }

    public function destroy(Transaction $transaction)
    {
        abort_unless($transaction->user_id === auth()->id(), 403);

        $transaction->delete();

        return back();
    }
}
