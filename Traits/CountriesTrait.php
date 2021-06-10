<?php

namespace Modules\CoreModule\Traits;

use Modules\CoreModule\Entities\Country;

trait CountriesTrait {

    public function getActiveCountries()
    {
        $countries=Country::where('is_active',1)->get();
        return $countries;
    }
}
