<?php

namespace Modules\CoreModule\Http\Controllers;

use App\Models\Country;
use App\Services\ApproveService;
use App\Traits\ApprovellTrait;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\CoreModule\Entities\ExchangeRate;

class ExchangeRateController extends Controller
{
    use ApprovellTrait;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $exchangeRates=ExchangeRate::orderBy('created_at','DESC')->get();
        $countries=Country::where('is_active','1')->get();
        return view('coremodule::exchange_rates.index',compact('exchangeRates','countries'));
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'from_currency' => 'required',
            'to_currency' => 'required',
            'exchange_rate' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if(ExchangeRate::where('from_currency',$request['from_currency'])->where('to_currency',$request['to_currency'])->count() != 0){
             echo "<script>Qual.warningd('Warning', 'This Exchange Rate Already Exists');</script>";
             return;
        }

        $fromCurrency=$request['from_currency'];
        $toCurrency=$request['to_currency'];
        $exchangeRateValue=$request['exchange_rate'];

        $description="There are an Create to the exchange rate from currency $fromCurrency to currency $toCurrency exchange_rate $exchangeRateValue";
        $approveService = new ApproveService();
        $approveService->setName('exchange_rates');
        $approveService->setAction("create");
        $approveService->setOldValue(0);
        $approveService->setNewValue($exchangeRateValue);
        $approveService->setDescription($description);
        $approveService->setRecordID(0);
        $approveService->setRequest(serialize($request->all()));

        if ($approveService->save() == null) {
            echo "<script>Qual.warning('Warning', 'record exists');</script>";
            return null;
        }

        echo "<script>Qual.success('Success', 'Exchange Rate Created Successfully');</script>";
    }



    public function edit($id)
    {
        $exchangeRate = ExchangeRate::find($id);
        $countries = Country::where('is_active',1)->get('currency_code');

        return view('coremodule::exchange_rates.edit',['exchangeRate'=>$exchangeRate,'countries' => $countries]);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'from_currency' => 'required|unique_with:exchange_rates,to_currency,'.$id,
            //'from_currency' => 'required',
            'to_currency' => 'required',
            'exchange_rate' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $exchangeRate = ExchangeRate::find($id);


        $fromCurrency=$request['from_currency'];
        $toCurrency=$request['to_currency'];
        $exchangeRateValue=$request['exchange_rate'];

        $description="There are an edit to the exchange rate from currency {$exchangeRate->from_currency} to currency $toCurrency from {$exchangeRate->exchange_rate} to $exchangeRateValue";


        $approveService = new ApproveService();
        $approveService->setName('exchange_rates');
        $approveService->setAction("edit");
        $approveService->setOldValue($exchangeRate->exchange_rate);
        $approveService->setNewValue($exchangeRateValue);
        $approveService->setDescription($description);
        $approveService->setRecordID($id);
        $approveService->setRequest(serialize($request->all()));

        if ($approveService->save() == null) {
            echo "<script>Qual.warning('Warning', 'record exists');</script>";
            return null;
        }

        return redirect()->route('admin.exchange.rates')->with('success','ExchangeRate updated successfully');

    }


    public function destroy($id)
    {
        $exchangeRate = ExchangeRate::find($id);

        $description="There are an delete to the exchange rate from currency {$exchangeRate->from_currency} to currency {$exchangeRate->to_currency} exchange rate {$exchangeRate->exchange_rate} ";

        $approveService = new ApproveService();
        $approveService->setName('exchange_rates');
        $approveService->setAction("delete");
        $approveService->setOldValue('');
        $approveService->setNewValue('');
        $approveService->setDescription($description);
        $approveService->setRecordID($id);
        $approveService->setRequest('');

        if ($approveService->save() == null) {
            echo "<script>Qual.warning('Warning', 'record exists');</script>";
            return null;
        }

        echo "<script>Qual.success('Success', 'Exchange Rate Delete Successfully');</script>";

    }
}
