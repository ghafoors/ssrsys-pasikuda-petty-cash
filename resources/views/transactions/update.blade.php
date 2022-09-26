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
                    <form action="{{route('transaction.update.action', $transaction->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="container">
                            <div class="row">
                                <div class="col-lg">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <h5>Reference</h5>
                                            <input type="text" class="form-control" id="reference" name="reference" required value="{{$transaction->reference}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <h5>Currency</h5>
                                        <select class="form-control" id="currency" name="currency">
                                            @foreach($currencies as $currency)
                                                <option value="{{$currency}}" {{$transaction->currency == $currency ? 'selected' : ''}}>{{$currency}}</option>
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
                                        <h5>Date: {{$transaction->date->format('d/m/Y')}}</h5>
                                        <input type="date" class="form-control" id="date" name="date" id="date-picker">
                                    </div>
                                </div>
                                <div class="col-lg">
                                    <div class="form-group">
                                        <h5>Amount</h5>
                                        <input type="number" class="form-control" id="amount" name="amount" step="0.01" required value="{{$transaction->amount}}">
                                    </div>
                                    <div class="form-group">
                                        <h5>
                                            Attachment
                                            @if($transaction->attachment_path)
                                                <a class="btn btn-icon btn-outline-primary btn-sm" href="{{route('transaction.attachment.view', $transaction->id)}}" target="_blank">
                                                    <span class="btn-inner--icon"><i class="ni ni-single-copy-04"></i></span>
                                                </a>
                                            @endif
                                        </h5>
                                        <input type="file" class="form-control" id="attachment" name="attachment">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <h5>Note</h5>
                                        <textarea class="form-control" id="note" name="note" rows="3">{{$transaction->note}}</textarea>
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
    <script>
        $(document).ready( function() {

            $('#date-picker').value(new Date({{$transaction->date->format('Y')}},{{$transaction->date->format('m')}},{{$transaction->date->format('d')}}));
        });
    </script>
@endpush
