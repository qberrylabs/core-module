@can('exchange-rate-create')
<button type="button" class="btn btn-success" data-toggle="modal" data-target=".bs-example-modal-lg"> Create New Exchange Rates</button>

<div id="modal" class="modal fade bs-example-modal-lg"  role="dialog" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">

    <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Create New Exchange Rates</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
    </div>
    <form class="form-horizontal form-label-left" novalidate>
        @csrf
    <div class="modal-body">


        <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">From Currency <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">

                <select name="from_currency" id="from_currency" required="required"  data-width="100%"  class="select-builder  form-control ">
                    <option></option>
                    @foreach ($countries as $country)
                    <option value="{{ $country->currency_code }}">{{ $country->currency_code }}</option>
                    @endforeach

                </select>
            {{-- <input  class="form-control" id="from_currency"  name="from_currency" placeholder="" required="required" type="text"> --}}
            </div>
        </div>

        <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">To Currency <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
                <select name="to_currency" id="to_currency" required="required"  data-width="100%"  class="select-builder  form-control ">
                    <option></option>
                    @foreach ($countries as $country)
                    <option value="{{ $country->currency_code }}">{{ $country->currency_code }}</option>
                    @endforeach

                </select>
                {{-- <input  class="form-control" id="to_currency"  name="to_currency" placeholder="" required="required" type="text"> --}}
            </div>
            </div>

            <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="number">Exchange Rate <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
                <input type="number"  id="exchange_rate" name="exchange_rate" required="required"  class="form-control">
            </div>
            </div>



    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button"  id="ajaxAddExchangeRate" class="btn btn-primary">Save changes</button>
    </div>
    @push('AjaxScript')

    <script type="text/javascript">

            $('#ajaxAddExchangeRate').click(function(e) {
                //var id=$(this).data("id");
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'get'
                    , url: "/exchange-rates/store"
                    , cache: false
                    , data: {
                        from_currency: $('#from_currency').val(),
                        to_currency: $('#to_currency').val(),
                        exchange_rate: $('#exchange_rate').val()
                    , }
                    , success: function(result) {
                        console.log("success");
                        $("#exchangeRates_items").prepend(result);
                        // $('#modal').modal('toggle');
                        $('#modal').modal('hide');

                    }
                    , error: function(result) {
                        console.log("error");
                        // $('.alert').show();
                        // $('.alert').html("هناك خطاء");
                    }

                });
            });


    </script>
    @endpush
    </form>

    </div>
</div>
</div>
@endcan


