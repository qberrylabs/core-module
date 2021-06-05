@extends('layouts.app_admin')

@section('content')
<div class="right_col" role="main">
    <div class="">
      <div class="clearfix"></div>

      <div class="row">

        <div class="col-md-12 col-sm-12 ">
          <div class="x_panel">
            <div class="x_title">
              <h2>Deposit Fees</h2>

              <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                      <div class="card-box table-responsive">
              <p class="text-muted font-13 m-b-30"></p>


              @include('coremodule::deposit_fee.create')

              @if ($message = Session::get('success'))
                <div class="alert alert-success">
                <p>{{ $message }}</p>
                </div>
              @endif
              @if ($message = Session::get('failed'))
                <div class="alert alert-danger">
                <p>{{ $message }}</p>
                </div>
              @endif
              @if (count($errors) > 0)
                <div class="alert alert-danger">
                  <strong>Whoops!</strong> There were some problems with your input.<br><br>
                  <ul>
                     @foreach ($errors->all() as $error)
                       <li>{{ $error }}</li>
                     @endforeach
                  </ul>
                </div>
                @endif

              <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>

                  <tr>
                    <th>id</th>
                    <th>Country</th>
                    <th>Payment Methods</th>
                    <th>Fee Type</th>
                    <th>Fee</th>
                    @if(auth()->user()->can('fee-edit'))
                    <th>Action</th>
                    @endif


                  </tr>
                </thead>
                <tbody id="fees_items">
                    @forelse ($fees as $fee)
                    <tr class="fee_{{ $fee->id }} ">
                        <td>#{{$fee->id}}</td>
                        <td class="fee_country">{{$fee->country}}</td>
                        <td class="fee_payment_method">{{$fee->payment_method}}</td>

                        <td class="fee_type">{{$fee->fee_type}}</td>
                        <td class="fee_price">{{$fee->price}}@if($fee->fee_type == "Percentage")%@endif</td>

                        @if(auth()->user()->can('fee-edit'))
                        <td>
                            @can('fee-edit')
                            <a class="btn btn-primary" href="{{ route('admin.deposit.fees.edit', ['id'=>$fee->id]) }}">Edit</a>
                            @endcan

                            <a href="{{ route('admin.deposit.fees.destroy', ['id'=>$fee->id]) }}" class="btn btn-danger">Delete</a>


                        </td>
                        @endif

                    </tr>

                    @empty

                    @endforelse
                </tbody>
              </table>


            </div>
          </div>
        </div>
      </div>
          </div>
        </div>
      </div>
    </div>
  </div>

    @push('QuantumAlertCSS')
    <script src="{{ url('backend/vendors/quantum-alert/quantumalert.css') }}"></script>
    @endpush

    @push('QuantumAlertJS')
    <script src="{{ url('backend/vendors/quantum-alert/quantumalert.js') }}"></script>
    @endpush

@endsection

