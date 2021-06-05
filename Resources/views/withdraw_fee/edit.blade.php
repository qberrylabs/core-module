@can('fee-edit')

@extends('layouts.app_admin')


@section('content')

<div class="right_col" role="main">
    <div class="">
      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="x_panel">

              <div class="x_content">
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

                {!! Form::model($fee, ['method' => 'PATCH','route' => ['admin.withdraw.fees.update', $fee->id]]) !!}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Name :</strong>
                            <select  class="form-control select-builder" id="fee_input_name" data-width="100%" name="name" required="required" >
                                <option></option>
                                @foreach ($roles as $role)
                                    @if ( $role->name == "AgentA" || $role->name == "AgentB" || $role->name == "AgentC")
                                        <option  value="{{ $role->name }}" @if ($role->name == $fee->name) selected @endif>{{$role->display_name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            {{-- {!! Form::text('from_currency', null, array('placeholder' => 'From Currency','required'=>'required','class' => 'form-control')) !!} --}}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>country :</strong>
                            <select  class="form-control select-builder" id="fee_input_country" data-width="100%" name="country" placeholder="" required="required" >
                                <option></option>
                                @foreach ($countries as $country)

                                <option  value="{{ $country->name }}"  @if ($country->name == $fee->country) selected @endif> {{ $country->name }}</option>
                                @endforeach
                            </select>
                            {{-- {!! Form::text('to_currency', null, array('placeholder' => 'To Currency','required'=>'required','class' => 'form-control')) !!} --}}
                        </div>
                    </div>



                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>fee type :</strong>
                            <select  class="form-control select-builder" id="fee_input_type" data-width="100%" name="fee_type" placeholder="" required="required" >
                                <option></option>
                                <option  @if ($fee->fee_type == "Flat") selected @endif >Flat</option>
                                <option  @if ($fee->fee_type == "Percentage") selected @endif >Percentage</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Fee</strong>
                            {!! Form::number('price', null, array('placeholder' => '','required'=>'required','class' => 'form-control','step' => "any")) !!}

                        </div>
                    </div>



                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
                {!! Form::close() !!}


              </div>
            </div>
          </div>


      </div>
    </div>
  </div>




@endsection
@endcan

