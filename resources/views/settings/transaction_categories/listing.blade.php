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
                                <h3 class="mb-0">Transaction Categories</h3>
                            </div>
                            <div class="col text-right">
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#newCategory">
                                    ADD NEW
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush" id="listing-table">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">Parent Category</th>
                                <th scope="col">Category</th>
                                <th scope="col">Type</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($categories))
                                @foreach($categories as $category)
                                    <tr>
                                        <td>{{$category->parent}}</td>
                                        <td>{{$category->category}}</td>
                                        <td>{{$category->type}}</td>
                                        <td class="text-right">
                                            <a class="btn btn-icon btn-outline-warning btn-sm"
                                               href="{{route('settings.transaction.category.update.view', $category->id)}}">
                                                                    <span class="btn-inner--icon"><i
                                                                            class="ni ni-ruler-pencil"></i></span>
                                            </a>
                                        </td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12 text-center">
                {{ $categories->links() }}
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="newCategory" tabindex="-1" role="dialog" aria-labelledby="newCategoryLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <form action="{{route('settings.transaction.category.new')}}" method="POST">
                    @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ADD NEW CATEGORY</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <h5>Parent Category</h5>
                                    <div class="form-group">
                                        <div class="custom-control-inline custom-radio pl-3">
                                            <input name="parent" class="custom-control-input" id="parent1" type="radio" value="Debt/Loan" required>
                                            <label class="custom-control-label" for="parent1">Debt/Loan</label>
                                        </div>
                                        <div class="custom-control-inline custom-radio pl-3">
                                            <input name="parent" class="custom-control-input" id="parent2" type="radio" value="Income" required>
                                            <label class="custom-control-label" for="parent2">Income</label>
                                        </div>
                                        <div class="custom-control-inline custom-radio pl-3">
                                            <input name="parent" class="custom-control-input" id="parent3" type="radio" value="Expense" required>
                                            <label class="custom-control-label" for="parent3">Expense</label>
                                        </div>
                                    </div>

                                    <h5>Type</h5>
                                    <div class="form-group">
                                        <div class="custom-control-inline custom-radio pl-3">
                                            <input name="type" class="custom-control-input" id="type1" type="radio" value="credit" required>
                                            <label class="custom-control-label" for="type1">Credit</label>
                                        </div>
                                        <div class="custom-control-inline custom-radio pl-3">
                                            <input name="type" class="custom-control-input" id="type2" type="radio" value="debit" required>
                                            <label class="custom-control-label" for="type2">Debit</label>
                                        </div>
                                    </div>

                                    <h5>Category Name</h5>
                                    <div class="form-group">
                                        <input type="text" name="category" class="form-control" id="category"
                                               placeholder="category name" required minlength="3">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">SUBMIT</button>
                    </div>
                </div>
                </form>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
@endpush
