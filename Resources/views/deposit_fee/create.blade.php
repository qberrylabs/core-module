@can('fee-create')
<button type="button" class="btn btn-success" data-toggle="modal" data-target=".bs-example-modal-lg"> Create New Deposit Fee</button>

<div id="modal" class="modal fade bs-example-modal-lg" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">

    <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Create New Deposit Fee</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
    </div>
    <form id="deposit-fee-form" class="form-horizontal form-label-left" method="POST" action="{{ route('admin.deposit.fees.store') }}" novalidate>
        @csrf
    <div class="modal-body">


        <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">Payment Method <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
            {{-- <input  class="form-control" id="name"  name="name" placeholder="" required="required" type="text"> --}}

            <select  class="form-control select-builder" id="name" data-width="100%" name="payment_method" required="required" >
                <option></option>
                @foreach ($paymentMethods as $paymentMethod)
                <option  value="{{ $paymentMethod->name }}"> {{ $paymentMethod->name }}</option>
                @endforeach
            </select>
            </div>
        </div>

        <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="country"> Country <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6">
            {{-- <input  class="form-control" id="country"  name="country" placeholder="" required="required" type="text"> --}}
            <select  class="form-control select-builder" id="country" data-width="100%" name="country" placeholder="" required="required" >
                <option></option>
                @foreach ($countries as $country)
                {{-- <option  value="{{ $country->name }}" @if ($country->name == $userApplication->country) selected @endif> {{ $country->name }}</option> --}}
                <option  value="{{ $country->name }}"> {{ $country->name }}</option>
                @endforeach
            </select>
            </div>
        </div>

        <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">Fee Type<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6">
                <select  class="form-control select-builder" id="fee_type" data-width="100%" name="fee_type" placeholder="" required="required" >
                    <option></option>
                    <option>Flat</option>
                    <option>Percentage</option>
                </select>
            </div>
        </div>

        <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">Fee <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6">
                <input  class="form-control" id="price"  name="price" placeholder="" required="required" type="number">
            </div>
        </div>





    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button"  id="ajaxAddDepositFee" class="btn btn-primary">Save changes</button>
    </div>
    @push('AjaxScript')

    <script type="text/javascript">

        $('#ajaxAddDepositFee').click(function() {
            $("#deposit-fee-form").submit();
        });
    </script>
    @endpush
    </form>

    </div>
</div>
</div>
@endcan


