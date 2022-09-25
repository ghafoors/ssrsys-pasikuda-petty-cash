<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransactionsController extends Controller
{
    public function listTransactions()
    {

        $usdQuery = Transaction::query()->where('currency', 'USD');
        $lkrQuery = Transaction::query()->where('currency', 'LKR');
        $mvrQuery = Transaction::query()->where('currency', 'MVR');
        $date = request()->date;
        if(!empty($date)) {
            $usdQuery->where('date', $date);
            $lkrQuery->where('date', $date);
            $mvrQuery->where('date', $date);
        }

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
                'USD' => $this->calcuateBalance($usdQuery),
                'LKR' => $this->calcuateBalance($lkrQuery),
                'MVR' => $this->calcuateBalance($mvrQuery)
            ]
        ]);
    }

    private function calcuateBalance($query)
    {
        $balance = 0;
        $items = $query->get();
        foreach ($items as $item) {
            if ($item->category->type == 'credit') {
                $balance += $item->amount;
            } else {
                $balance -= $item->amount;
            }
        }
        return $balance;
    }

    public function newTransactionView()
    {
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

    public function updateTransactionView($id)
    {
        $transaction = Transaction::findOrFail($id);
        $currencies = config('app.currency_accounts');
        $categories = TransactionCategory::query()
            ->orderBy('parent')
            ->orderBy('type')
            ->orderBy('category')
            ->get();
        return view('transactions.update')->with([
            'currencies' => $currencies,
            'categories' => $categories,
            'transaction' => $transaction
        ]);
    }

    public function viewAttachment($id)
    {
        $transaction = Transaction::findOrFail($id);
        return response()->file(base_path('storage/app/'.$transaction->attachment_path));
    }

    public function newTransactionAction(Request $request)
    {
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
        $transaction = Transaction::create($data);
        $this->UploadDocument($request, $transaction->id);
        return redirect()->route('transaction.listing');
    }

    public function updateTransactionAction(Request $request, $id)
    {
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
        $transaction = Transaction::findOrFail($id);
        $transaction->update(array_filter($data));
        $this->UploadDocument($request, $transaction->id);
        return redirect()->route('transaction.listing');
    }

    public function UploadDocument(Request $request, $id)
    {

        if ($request->hasFile('attachment')) {
            $transaction = Transaction::findOrFail($id);
            $file = $request->file('attachment');
            $originalFilename = Str::slug($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
            $filename = $file->storeAs('documents', $originalFilename);
            $transaction->attachment_path = $filename;
            $transaction->attachment_file_name = $originalFilename;
            $transaction->save();

        }
    }

    public function deleteTransactionAction($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        return redirect()->route('transaction.listing');
    }
}
