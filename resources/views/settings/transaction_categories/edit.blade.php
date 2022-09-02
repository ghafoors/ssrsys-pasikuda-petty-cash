@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')

    <div class="container-fluid mt--7">
        <div class="row mt-5">
            <div class="col-xl-12 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Update Transaction Category</h3>
                            </div>
                        </div>
                    </div>
                    <form action="{{route('settings.transaction.category.update.action', $category->id)}}" method="POST">
                        @csrf
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <h5>Parent Category</h5>
                                    <div class="form-group">
                                        <div class="custom-control-inline custom-radio pl-3">
                                            <input name="parent" class="custom-control-input" id="parent1" type="radio"
                                                   value="Debt/Loan"
                                                   required {{$category->parent == 'Debt/Loan' ? 'checked': ''}}>
                                            <label class="custom-control-label" for="parent1">Debt/Loan</label>
                                        </div>
                                        <div class="custom-control-inline custom-radio pl-3">
                                            <input name="parent" class="custom-control-input" id="parent2" type="radio"
                                                   value="Income"
                                                   required {{$category->parent == 'Income' ? 'checked': ''}}>
                                            <label class="custom-control-label" for="parent2">Income</label>
                                        </div>
                                        <div class="custom-control-inline custom-radio pl-3">
                                            <input name="parent" class="custom-control-input" id="parent3" type="radio"
                                                   value="Expense"
                                                   required {{$category->parent == 'Expense' ? 'checked': ''}}>
                                            <label class="custom-control-label" for="parent3">Expense</label>
                                        </div>
                                    </div>

                                    <h5>Type</h5>
                                    <div class="form-group">
                                        <div class="custom-control-inline custom-radio pl-3">
                                            <input name="type" class="custom-control-input" id="type1" type="radio"
                                                   value="credit"
                                                   required {{$category->type == 'credit' ? 'checked': ''}}>
                                            <label class="custom-control-label" for="type1">Credit</label>
                                        </div>
                                        <div class="custom-control-inline custom-radio pl-3">
                                            <input name="type" class="custom-control-input" id="type2" type="radio"
                                                   value="debit" required{{$category->type == 'debit' ? 'checked': ''}}>
                                            <label class="custom-control-label" for="type2">Debit</label>
                                        </div>
                                    </div>

                                    <h5>Category Name</h5>
                                    <div class="form-group">
                                        <input type="text" name="category" class="form-control" id="category"
                                               placeholder="category name" required minlength="3"
                                               value="{{$category->category}}">
                                    </div>

                                    <div class="form-group">
                                        <div class="form-group">
                                            <button type="submit"
                                                    class="btn btn-outline-success btn-lg btn-block text-center">SUBMIT
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
@endpush
