@extends('layouts.table_layout',['titel'=>'Foreign Exchange'])
@section('table')
@include('backend.exchange_rates.create')
<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>id</th>
            <th>From Currency</th>
            <th>To Currency</th>
            <th>Exchange Rate</th>
            <th>Deleted At</th>
            @if(auth()->user()->can('exchange-rate-edit') || auth()->user()->can('exchange-rate-delete'))
            <th>Action</th>
            @endif


        </tr>
    </thead>
    <tbody id="exchangeRates_items">
        @forelse ($exchangeRates as $exchangeRate)
        <tr class="exchangeRates_{{ $exchangeRate->id }}">
            <td>#{{$exchangeRate->id}}</td>
            <td>{{$exchangeRate->from_currency}}</td>
            <td>{{$exchangeRate->to_currency}}</td>
            <td>{{$exchangeRate->exchange_rate}}</td>
            <td>{{$exchangeRate->deleted_at}}</td>

            @if(auth()->user()->can('exchange-rate-edit') || auth()->user()->can('exchange-rate-delete'))
            <td>
                @can('exchange-rate-edit')
                <a class="btn btn-primary" href="/exchange-rates/edit/{{ $exchangeRate->id }}">Edit</a> @endcan @can('exchange-rate-delete')
                <a href="javascript:;" onclick="deleteExchangeRate({{$exchangeRate->id}})" class="btn btn-danger">Delete</a> @endcan
            </td>
            @endif
        </tr>

        @empty @endforelse

    </tbody>
</table>
@include('coremodule::exchange_rates.js.exchange_rates_js') @endsection
