@can('exchange-rate-edit')

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

                {!! Form::model($exchangeRate, ['method' => 'PATCH','route' => ['admin.exchange-rates.update', $exchangeRate->id]]) !!}
                <div class="row">

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>From Currency:</strong>
                            <select name="from_currency" id="from_currency" required="required"  data-width="100%"  class="select-builder  form-control ">
                                <option></option>
                                @foreach ($countries as $country)
                                <option value="{{ $country->currency_code }}" @if ($country->currency_code == $exchangeRate->from_currency) selected @endif>{{ $country->currency_code }}</option>
                                @endforeach
                            </select>
                            {{-- {!! Form::text('from_currency', null, array('placeholder' => 'From Currency','required'=>'required','class' => 'form-control')) !!} --}}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>To Currency :</strong>
                            <select name="to_currency" id="to_currency" required="required"  data-width="100%"  class="select-builder  form-control ">
                                <option></option>
                                @foreach ($countries as $country)
                                <option value="{{ $country->currency_code }}" @if ($country->currency_code == $exchangeRate->to_currency) selected @endif>{{ $country->currency_code }}</option>
                                @endforeach

                            </select>
                            {{-- {!! Form::text('to_currency', null, array('placeholder' => 'To Currency','required'=>'required','class' => 'form-control')) !!} --}}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Exchange Rate :</strong>
                            {!! Form::text('exchange_rate', null, array('placeholder' => 'Exchange Rate','required'=>'required','class' => 'form-control')) !!}
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

