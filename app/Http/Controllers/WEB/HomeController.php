<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Rating;

class HomeController extends Controller
{
    public function index()
    {
        $ratings = Rating::select('businesses.id', 'businesses.name', 'businesses.logo_id', 'service_requests.id', 'service_requests.business_id', 'ratings.service_request_id', DB::raw('SUM(ratings.rating) as total_rating'))
                                    ->join('service_requests', 'ratings.service_request_id', '=', 'service_requests.id')
                                    ->join('businesses', 'service_requests.business_id', '=', 'businesses.id')
                                    ->groupBy('service_requests.business_id')
                                    ->orderBy('total_rating')
                                    ->limit(4)
                                    ->get();
        return view('welcome', compact('ratings'));
    }
}
