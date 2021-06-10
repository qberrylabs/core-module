<?php

namespace Modules\CoreModule\Http\Controllers;

use Modules\CoreModule\Entities\Country;
use Modules\PaymentMethodeModule\Entities\PaymentMethod;
use Modules\TransactionModule\Entities\TransactionType;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\CoreModule\Enum\FeeTypesEnum;

class FeeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($type)
    {
        $fee=(new FeeTypesEnum())->getFeeClass($type);
        if(!$fee){
            return;
        }
        $fees=$fee->all();
        $countries=Country::where('is_active','1')->get();

        $paymentMethods=PaymentMethod::all();

        $transactionTypes=TransactionType::all()->reject(function ($transactionType) {
            if ($transactionType->transaction_type_name == "withdraw" || $transactionType->transaction_type_name == "deposit" ) {
                return $transactionType;
            }
        });


        return view('coremodule::fee.index',compact('fees','countries','type','transactionTypes','paymentMethods'));
    }
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request,$type)
    {
        $ErrorsValidator=[
            'country' => 'required', 'string',
            'fee_type' => 'required', 'string',
            'price' => 'required | numeric',
        ];
        $fessValidator=[
            FeeTypesEnum::DEPOSIT =>['payment_method' => 'required | unique_with:deposit_fees,country,']
        ];
        $ErrorsValidator += $fessValidator[$type];


        $validator = Validator::make($request->all(),$ErrorsValidator);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        dd($request,$type);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('coremodule::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('coremodule::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
