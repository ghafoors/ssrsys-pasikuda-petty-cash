@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')

    <div class="container-fluid mt--7">
        <div class="row mt-5">
            <div class="col-xl-12 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-md">
                                <h3 class="mb-0">Transactions</h3>
                            </div>
                            <div class="col-md">
                                <form action="" method="GET">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <h5>Date</h5>
                                            <input type="date" class="form-control" id="date" name="date" required value="{{request()->date}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <h5>&nbsp;</h5>
                                            <button type="submit" class="btn btn-success">Filter</button>
                                            <a href="{{route('transaction.listing')}}" class="btn btn-warning">Clear</a>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @if(!empty($transactions))
                        @foreach($transactions as $key => $currency)

                            @if(count($currency) > 0)
                                <div class="row">
                                    <div class="col">
                                        <h4 class="ml-4">{{$key}}</h4>
                                    </div>
                                    <div class="col text-right">
                                        <h5 class="mr-4">Balance:&nbsp;
                                            @if($balances[$key] >=0)
                                                <span class="text-success">{{number_format($balances[$key], 2)}}</span>
                                            @else
                                                <span class="text-danger">{{number_format($balances[$key], 2)}}</span>
                                            @endif
                                        </h5>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col">
                                        <div class="table-responsive">
                                            <!-- Projects table -->
                                            <table class="table align-items-center table-flush" id="listing-table">
                                                <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">Reference</th>
                                                    <th scope="col">Category</th>
                                                    <th scope="col">Currency</th>
                                                    <th scope="col">Amount</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Posted By</th>
                                                    <th scope="col">Type</th>
                                                    <th scope="col"></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if(!empty($currency))
                                                    @foreach($currency as $transaction)
                                                        <tr data-toggle="tooltip" data-placement="top"
                                                            title="{{$transaction->note}}">
                                                            <td>{{$transaction->reference}}</td>
                                                            <td>{{$transaction->category->parent}}
                                                                - {{$transaction->category->category}}</td>
                                                            <td>{{$transaction->currency}}</td>
                                                            <td>{{number_format($transaction->amount, 2)}}</td>
                                                            <td>{{$transaction->date->format('d/m/Y')}}</td>
                                                            <td>{{$transaction->postedBy->name}}</td>
                                                            <td>
                                                                @if($transaction->category->type == 'credit')
                                                                    <i class="ni ni-fat-add text-success"></i>
                                                                @endif
                                                                @if($transaction->category->type == 'debit')
                                                                    <i class="ni ni-fat-delete text-danger"></i>
                                                                @endif
                                                            </td>
                                                            <td class="text-right">

                                                                <a class="btn btn-icon btn-outline-primary btn-sm {{!$transaction->attachment_path ? 'disabled' : ''}}"
                                                                   href="{{route('transaction.attachment.view', $transaction->id)}}"
                                                                   target="_blank">
                                                                    <span class="btn-inner--icon"><i
                                                                            class="ni ni-single-copy-04"></i></span>
                                                                </a>
                                                                <a class="btn btn-icon btn-outline-warning btn-sm"
                                                                   href="{{route('transaction.update.view', $transaction->id)}}">
                                                                    <span class="btn-inner--icon"><i
                                                                            class="ni ni-ruler-pencil"></i></span>
                                                                </a>
                                                                <a class="btn btn-icon btn-danger btn-sm prompt-confirmation"
                                                                   href="{{route('transaction.delete.action', $transaction->id)}}">
                                                                    <span class="btn-inner--icon"><i
                                                                            class="ni ni-fat-remove"></i></span>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="ml-3">
                                            {{ $currency->links() }}
                                        </div>
                                    </div>
                                </div>
                            @endif

                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')

    <script>
        $('.prompt-confirmation').on('click', function () {
            return confirm("You're about to permanently delete an entry, are you sure?");
        });
    </script>

@endpush
