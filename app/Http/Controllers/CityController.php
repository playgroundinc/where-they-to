<?php

namespace App\Http\Controllers;

use App\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($province)
    {
        //
        $cities = City::where('province', '=', $province)->get();
        return response()->json($cities);
    }
    /**
     * Pull the details for a single City.
     */
    public function single($province, $city) {
		$single_city = City::where('province', '=', $province)->where('name', '=', $city)->first();
		return response()->json(array('city' => $single_city));
    }

    /**
     * Create a new city entry in the DB.
     */
    public function store($province) {
		$name = request('name');
		$match = City::where('province', '=', $province)->where('name', '=', $name)->get();
		if (is_countable($match) && !count($match) > 0 && !empty($province)) {
			$attributes = array(
				'name' => $name,
				'province' => $province,
			);
			City::create($attributes);
			return response()->json(array('status' => 'created'));
		}
		return response()->json(gettype($match));
    }

    public function search($province, $term) {
		if (empty($term)) {
			return response()->json([], 200);
		}
		$cities = City::where('province', '=', $province)->where('name','LIKE','%'.$term.'%')->take(10)->get();
		if (!empty($cities)) {
			return response()->json(compact('cities'), 200);
		}
		return response()->json([], 200);
    }
}
