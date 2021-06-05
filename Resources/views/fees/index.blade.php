@extends('layouts.app_admin')

@section('content')
<div class="right_col" role="main">
    <div class="">
      <div class="clearfix"></div>

      <div class="row">

        <div class="col-md-12 col-sm-12 ">
          <div class="x_panel">
            <div class="x_title">
              <h2>Fees & Rates</h2>

              <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                      <div class="card-box table-responsive">
              <p class="text-muted font-13 m-b-30"></p>


              @include('coremodule::fees.create')

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
                    <th>Name</th>
                    <th>Country</th>
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
                        <td class="fee_name">{{$fee->name}}</td>
                        <td class="fee_country">{{$fee->country}}</td>
                        <td class="fee_type">{{$fee->fee_type}}</td>

                        <td class="fee_price">{{$fee->price}}@if($fee->fee_type == "Percentage")%@endif</td>
                        @if(auth()->user()->can('fee-edit'))
                        <td>
                            @can('fee-edit')
                            <a class="btn btn-primary" href="/fees/edit/{{ $fee->id }}">Edit</a>
                            @endcan

                            <a href="{{ route('admin.fees.destroy', ['id'=>$fee->id]) }}" class="btn btn-danger">Delete</a>


                        </td>
                        @endif

                    </tr>

                    @empty

                    @endforelse
                    @push('AjaxScript')

                    <script  type="text/javascript">
                    function editFee(id) {
                            $('#editFeeModal').modal('show');
                            var currentName=$(".fee_"+id+" .fee_name").text();
                            var currentPrice=parseFloat($(".fee_"+id+" .fee_price").text());
                            var currentCountry=$(".fee_"+id+" .fee_country").text();
                            var currentType=$(".fee_"+id+" .fee_type").text();

                            $("#fee_input_name").val(currentName);
                            $("#fee_input_price").val(currentPrice);
                            $("#fee_input_country").val(currentCountry);
                            $("#fee_input_type").val(currentType);
                            $("#fee_input_id").val(id);

                            $('#ajaxEditFee').click(function(e) {
                                e.preventDefault();
                                $.ajax({
                                    type : 'get',
                                    url: "/fees/edit",
                                    cache: false,
                                    data: {
                                        id: id,
                                        name:$("#fee_input_name").val(),
                                        price:$("#fee_input_price").val(),
                                        country:$("#fee_input_country").val(),
                                        fee_type: $('#fee_input_type').val()

                                    },

                                    success: function(result) {
                                        console.log("success");
                                        let retResult=result.split(" ");

                                        //console.log(retResult);
                                        $(".fee_"+id+" .fee_name").text(retResult[0]);
                                        $(".fee_"+id+" .fee_price").text(retResult[1]);
                                        $(".fee_"+id+" .fee_country").text(retResult[2]);
                                        $('#editFeeModal').modal('hide');
                                        location.reload(false);

                                    },
                                    error: function(result) {
                                        console.log("error");
                                    }

                                });

                            });
                            }

                        // function deleteFee(id) {
                        //     $.ajax({
                        //         type : 'get',
                        //             url: "/fees/destroy/"+id,
                        //             cache: false,
                        //             data: {
                        //             id: id
                        //             },

                        //             success: function(result) {
                        //             console.log("success");
                        //             $(".fee_"+id).hide(1000);

                        //         },
                        //             error: function(result) {
                        //             console.log("error");
                        //             //$('.alert').show();
                        //             //$('.alert').html("هناك خطاء");
                        //         }

                        //     });
                        // }
                    </script>
                    @endpush


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

