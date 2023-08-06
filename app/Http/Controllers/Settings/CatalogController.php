<?php

namespace App\Http\Controllers\Settings;
use App\Models\Region;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index()
    {
        $regions = Region::paginate(10);
        $countries = Country::with('region')->paginate(10);
        $states = State::with('country')->paginate(10);
        $cities = City::with('state')->paginate(10);

        return Inertia::render('Settings/Catalog/Index', [
            'regions' => $regions,
            'countries' => $countries,
            'states' => $states,
            'cities' => $cities,
        ]);
    }
}
