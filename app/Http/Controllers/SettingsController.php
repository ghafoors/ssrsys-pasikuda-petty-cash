<?php

namespace App\Http\Controllers;

use App\Models\TransactionCategory;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function AddNewTransactionCategory(Request $request) {
        $newCategory = new TransactionCategory();
        $newCategory->parent = $request->get('parent');
        $newCategory->category = $request->get('category');
        $newCategory->type = $request->get('type');
        $newCategory->save();
        return redirect()->route('settings.transaction.category.listing');
    }
}
