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
                                <h3 class="mb-0">New Transaction</h3>
                            </div>
                        </div>
                    </div>
                    <form action="{{route('transaction.new.action')}}" method="POST">
                        @csrf
                        <div class="container">
                            <div class="row">
                                <div class="col-lg">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <h5>Reference</h5>
                                            <input type="text" class="form-control" id="reference" name="reference" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <h5>Currency</h5>
                                        <select class="form-control" id="currency" name="currency">
                                            @foreach($currencies as $currency)
                                                <option value="{{$currency}}">{{$currency}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg">
                                    <div class="form-group">
                                        <h5>Category</h5>
                                        <select class="form-control" id="category_id" name="category_id" required>
                                            @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->parent}} | {{$category->category}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <h5>Date</h5>
                                        <input type="date" class="form-control" id="date" name="date" required>
                                    </div>
                                </div>
                                <div class="col-lg">
                                    <div class="form-group">
                                        <h5>Amount</h5>
                                        <input type="number" class="form-control" id="amount" name="amount" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <h5>Note</h5>
                                        <textarea class="form-control" id="note" name="note" rows="3" ></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-outline-success btn-lg btn-block text-center">SUBMIT</button>
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
