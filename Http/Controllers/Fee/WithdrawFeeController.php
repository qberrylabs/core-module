<?php

namespace Modules\CoreModule\Http\Controllers\Fee;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Traits\ApprovellTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\CoreModule\Entities\WithdrawFee;
use Spatie\Permission\Models\Role;

class WithdrawFeeController extends Controller
{
    use ApprovellTrait;

    private function getAgentDisplayName($type)
    {
        $role=Role::where('name',$type)->first();
        if ( $role) {
            return  $role->display_name;
        }else{
            return  " Agent Unknow ";
        }

    }

    public function index()
    {
        $countries=Country::where('is_active','1')->get();
        $fees=WithdrawFee::orderBy('id','DESC')->get();

        foreach ($fees as $fee) {
            $fee->setAttribute('display_name',$this->getAgentDisplayName($fee->name));
        }
        $roles = Role::all();

        return view('coremodule::withdraw_fee.index',['fees'=>$fees,'countries'=>$countries,'roles'=>$roles]);
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'name' => 'required | unique_with:withdraw_fees,country',
            'country' => 'required', 'string',
            'fee_type' => 'required', 'string',
            'price' => 'required | numeric',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $name=$this->getAgentDisplayName($request['name']);
        $country=$request['country'];
        $feeType=$request['fee_type'];
        $price=$request['price'];

        $input = serialize($request->all());
        try {
            $description="create new withdraw fee the name is {$name} and country is {$country} and type is {$feeType} and the price {$price}";

            $checkApprovell=$this->checkApprovell("withdraw fees","create",0,$description);

            if (!$checkApprovell) {
                $this->createApprovell("withdraw fees","create",0, $price,$description,0,$input);
            }else{
                return back()->with(['failed'=>'record exists']);
            }
        } catch (\Throwable $th) {
            return back()->with(['failed'=>'Error']);
        }
        return redirect()->route('admin.withdraw.fees')->with('success','Withdraw Fee Created successfully');

    }



    public function edit($id)
    {
        $fee = WithdrawFee::find($id);
        $countries = Country::where('is_active',1)->get();
        $roles = Role::all();
        return view('coremodule::withdraw_fee.edit',['fee'=>$fee,'countries' => $countries,'roles'=>$roles]);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required | unique_with:withdraw_fees,country,'.$id,
            'country' => 'required', 'string',
            'fee_type' => 'required', 'string',
            'price' => 'required | numeric',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $fee = WithdrawFee::find($id);
        if (!$fee) {
            return redirect()->route('admin.withdraw.fees')->with('failed','record not exists');
        }

        //$name=$request['name'];
        $fromName=$this->getAgentDisplayName($fee->name);
        $toName=$this->getAgentDisplayName($request['name']);
        $country=$request['country'];
        $feeType=$request['fee_type'];
        $price=$request['price'];

        $input = serialize($request->all());
        try {
            $description="There are an edit to the withdraw fee from name {$fromName} to {$toName} from country {$fee->country} to country $country from {$fee->price} to $price from type {$fee->fee_type} to type $feeType";
            $checkApprovell=$this->checkApprovell("withdraw fees","edit",$id,$description);

            if (!$checkApprovell) {
                $this->createApprovell("withdraw fees","edit",$fee->price, $price,$description,$id,$input);
            }else{
                return redirect()->route('admin.withdraw.fees')->with('failed','record exists');
            }

        } catch (\Throwable $th) {
            return redirect()->route('admin.withdraw.fees')->with('failed','Error');
        }
        return redirect()->route('admin.withdraw.fees')->with('success','Withdraw Fee updated successfully');

    }


    public function destroy($id)
    {
        $fee=WithdrawFee::find($id);

        $name=$this->getAgentDisplayName($fee->name);
        $country=$fee->country;
        $feeType=$fee->fee_type;
        $price=$fee->price;

        $description="There are an Delete to the withdraw fee name {$name} and country {$country} and price {$price} and type $feeType";

        $checkApprovell=$this->checkApprovell("withdraw fees","delete",$id,$description);
        if (!$checkApprovell) {
            $this->createApprovell("withdraw fees","delete",'', '',$description,$id,'');
        }else{
            return redirect()->route('admin.withdraw.fees')->with('failed','record exists');
        }

        return redirect()->route('admin.withdraw.fees')->with('success','Withdraw Fee Deleted successfully');
    }
}
