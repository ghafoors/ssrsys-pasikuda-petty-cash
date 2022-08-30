<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionCategory;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function listTransactions() {

        $usdQuery = Transaction::query()->where('currency','USD');
        $lkrQuery = Transaction::query()->where('currency','LKR');
        $mvrQuery = Transaction::query()->where('currency','MVR');
        $transactionsUSD = $usdQuery->orderBy('date', 'desc')->paginate(10);
        $transactionsLKR = $lkrQuery->orderBy('date', 'desc')->paginate(10);
        $transactionsMVR = $mvrQuery->orderBy('date', 'desc')->paginate(10);
        return view('transactions.listing')->with([
            'transactions' => [
                'LKR' => $transactionsLKR,
                'USD' => $transactionsUSD,
                'MVR' => $transactionsMVR
            ],
            'balances' => [
                'LKR' => $this->calcuateBalance($usdQuery),
                'USD' => $this->calcuateBalance($lkrQuery),
                'MVR' => $this->calcuateBalance($mvrQuery)
            ]
        ]);
    }

    private function calcuateBalance($query) {
        $amounts = [];
        $items = $query->get();
        foreach ($items as $item) {
            if($item->category->type == 'debit') {
                array_push($amounts, $item->amount);
            } else {
                array_push($amounts, -$item->amount);
            }
        }
        return array_sum($amounts);
    }

    public function newTransactionView() {
        $currencies = config('app.currency_accounts');
        $categories = TransactionCategory::query()
            ->orderBy('parent')
            ->orderBy('type')
            ->orderBy('category')
            ->get();
        return view('transactions.new')->with([
            'currencies' => $currencies,
            'categories' => $categories
        ]);
    }

    public function newTransactionAction(Request $request) {
        $data = $request->only([
            'reference',
            'note',
            'amount',
            'date',
            'posted_by',
            'category_id',
            'budget_id',
            'currency'
        ]);
        $data['posted_by'] = auth()->user()->id;
        Transaction::create($data);
        return redirect()->route('transaction.listing');
    }

    public function deleteTransactionAction($id) {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        return redirect()->route('transaction.listing');
    }
}
