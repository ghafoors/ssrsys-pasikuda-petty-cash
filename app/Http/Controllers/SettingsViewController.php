<?php

namespace App\Http\Controllers;

use App\Models\TransactionCategory;
use Illuminate\Http\Request;

class SettingsViewController extends Controller
{
    public function TransactionCategoriesListing() {
        $categories = TransactionCategory::query()
            ->orderBy('parent')
            ->orderBy('type')
            ->orderBy('category')
            ->paginate();
        return view('settings.transaction_categories.listing')
            ->with([
                'categories' => $categories
            ]);
    }

    public function TransactionCategoriesUpdateView($id) {
        $category = TransactionCategory::findOrFail($id);
        return view('settings.transaction_categories.edit')->with([
            'category' => $category
        ]);
    }
}
