<?php

namespace Modules\CoreModule\Http\Controllers\Fee;

use App\Models\Country;
use Modules\PaymentMethodeModule\Entities\PaymentMethod;
use App\Models\TransactionType;
use App\Traits\ApprovellTrait;
use App\Traits\CountryTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Modules\CoreModule\Entities\Fee;

class FeeController extends Controller
{
    use ApprovellTrait , CountryTrait;
    public function index()
    {
        $fees=Fee::orderBy('id','DESC')->get();
        $countries=Country::where('is_active','1')->get();
        $transactionTypes=TransactionType::all()->reject(function ($transactionType) {
            if ($transactionType->transaction_type_name == "withdraw" || $transactionType->transaction_type_name == "deposit" ) {
                return $transactionType;
            }
        });


        return view('coremodule::fees.index',['fees'=>$fees,'countries'=>$countries,'transactionTypes'=>$transactionTypes]);
    }



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => ['required', 'string'],
            'country' => 'required', 'string',
            'price' => 'required | numeric',
            'fee_type' => 'required', 'string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if(Fee::where('name',$request['name'])->where('country',$request['country'])->count() == 0){


            $input = serialize($request->all());

            $name = $request['name'];
            $price = $request['price'];
            $country =$request['country'];
            $fee_type = $request['fee_type'];

            try {
                $description="create new fess the name is {$name} and country is {$country} and type is {$fee_type}";

                $checkApprovell=$this->checkApprovell("fees","create",0,$description);
                if (!$checkApprovell) {
                    $this->createApprovell("fees","create",0, $price,$description,0,$input);
                }else{
                    echo "<script>Qual.warning('Warning', 'record exists');</script>";
                    return null;
                }

            } catch (\Throwable $th) {
                echo "<script>Qual.warningd('Warning', 'Error');</script>";
            }
            echo "<script>Qual.success('Success', 'Fees Created Successfully');</script>";


        }else{
            echo "<script>Qual.warningd('Warning', 'This Fee Already Exists');</script>";

        }
    }

    public function edit($id)
    {
        $fee = Fee::find($id);
        $countries = Country::where('is_active',1)->get();

        $transactionTypes=TransactionType::all()->reject(function ($transactionType) {
            if ($transactionType->transaction_type_name == "withdraw" || $transactionType->transaction_type_name == "deposit" ) {
                return $transactionType;
            }
        });

        return view('coremodule::fees.edit',['fee'=>$fee,'countries' => $countries,'transactionTypes'=>$transactionTypes]);
    }

    public function update(Request $request,$id)
    {

        $validator = Validator::make($request->all(),[
            'name' => 'required | unique_with:fees,country,'.$id,
            'country' => 'required', 'string',
            'fee_type' => 'required', 'string',
            'price' => 'required | numeric',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $fee = Fee::find($id);
        $name = $request['name'];
        $price = $request['price'];
        $country = $request['country'];
        $fee_type = $request['fee_type'];

        $input = serialize($request->all());

        try {
            $description="There are an edit to the $name fee from country {$fee->country} to country $country from {$fee->price} to $price from type {$fee->fee_type} to type $fee_type";


            $checkApprovell=$this->checkApprovell("fees","edit",$id,$description);
            if (!$checkApprovell) {
                $this->createApprovell("fees","edit",$fee->price, $price,$description,$id,$input);
            }else{
                return redirect()->route('admin.fees')->with('failed','record exists');

            }

        } catch (\Throwable $th) {
            Session::flash('failed', 'Error');
        }
        return redirect()->route('admin.fees')->with('success','Fee updated successfully');

    }

    public function destroy($id)
    {

        Fee::find($id)->delete();
        return redirect()->route('admin.fees')->with('success','Fee deleted successfully');
    }
}
