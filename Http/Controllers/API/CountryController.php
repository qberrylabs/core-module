<?php

namespace Modules\CoreModule\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\CoreModule\Entities\Country;

class CountryController extends Controller
{

    public function getCountries()
    {
        $countries = Country::where('is_active',1)->get();

        return response()->json(['countries' => $countries], 200);
    }


}
