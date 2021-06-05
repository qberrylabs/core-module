<?php

namespace Modules\CoreModule\Http\Controllers\Fee;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Traits\ApprovellTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\CoreModule\Entities\DepositFee;
use Modules\PaymentMethodeModule\Entities\PaymentMethod;

class DepositFeeController extends Controller
{
    use ApprovellTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries=Country::where('is_active','1')->get();
        $fees=DepositFee::orderBy('id','DESC')->get();
        $paymentMethods=PaymentMethod::all();

        return view('coremodule::deposit_fee.index',['fees'=>$fees,'countries'=>$countries,'paymentMethods'=>$paymentMethods]);
    }



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'payment_method' => 'required | unique_with:deposit_fees,country,',
            'country' => 'required', 'string',
            'fee_type' => 'required', 'string',
            'price' => 'required | numeric',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        $paymentMethod=$request['payment_method'];
        $country=$request['country'];
        $feeType=$request['fee_type'];
        $price=$request['price'];

        $input = serialize($request->all());
        try {
            $description="create new deposit fee the payment Method is {$paymentMethod} and country is {$country} and type is {$feeType} and the price {$price}";

            $checkApprovell=$this->checkApprovell("deposit fees","create",0,$description);

            if (!$checkApprovell) {
                $this->createApprovell("deposit fees","create",0, $price,$description,0,$input);
            }else{
                return back()->with(['failed'=>'record exists']);
            }
        } catch (\Throwable $th) {
            return back()->with(['failed'=>'Error']);
        }
        // DepositFee::create($input);
        return redirect()->route('admin.deposit.fees')->with('success','Deposit Fee Created successfully');
    }


    public function edit($id)
    {
        $fee = DepositFee::find($id);
        $countries = Country::where('is_active',1)->get();
        $paymentMethods=PaymentMethod::all();
        return view('coremodule::deposit_fee.edit',['fee'=>$fee,'countries' => $countries,'paymentMethods'=>$paymentMethods]);
    }


    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(),[
            'payment_method' => 'required | unique_with:deposit_fees,country,'.$id,
            'country' => 'required', 'string',
            'fee_type' => 'required', 'string',
            'price' => 'required | numeric',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $paymentMethod=$request['payment_method'];
        $country=$request['country'];
        $feeType=$request['fee_type'];
        $price=$request['price'];

        $fee = DepositFee::find($id);
        if (!$fee) {
            return redirect()->route('admin.deposit.fees')->with('failed','record not exists');
        }
        $input = serialize($request->all());

        try {
            $description="There are an edit to the Deposit fee from country {$fee->country} to country $country from {$fee->price} to $price from type {$fee->fee_type} to type $feeType from payment method {$fee->payment_method} to {$paymentMethod}";
            $checkApprovell=$this->checkApprovell("deposit fees","edit",$id,$description);

            if (!$checkApprovell) {
                $this->createApprovell("deposit fees","edit",$fee->price, $price,$description,$id,$input);
            }else{
                return redirect()->route('admin.deposit.fees')->with('failed','record exists');
            }

        } catch (\Throwable $th) {
            return redirect()->route('admin.deposit.fees')->with('failed','Error');

        }

        return redirect()->route('admin.deposit.fees')->with('success','Fee updated successfully');
    }


    public function destroy($id)
    {
        $fee=DepositFee::find($id);

        $paymentMethod=$fee->payment_method;
        $country=$fee->country;
        $feeType=$fee->fee_type;
        $price=$fee->price;

        $description="There are an delete to the deposit fee payment method {$paymentMethod} and country {$country} and price {$price} and type $feeType";

        $checkApprovell=$this->checkApprovell("deposit fees","delete",$id,$description);
        if (!$checkApprovell) {
            $this->createApprovell("deposit fees","delete",'', '',$description,$id,'');
        }else{
            return redirect()->route('admin.deposit.fees')->with('failed','record exists');
        }
        return redirect()->route('admin.deposit.fees')->with('success','deposit Fee Deleted successfully');
    }
}
