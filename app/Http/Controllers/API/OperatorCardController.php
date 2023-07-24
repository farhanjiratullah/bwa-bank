<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\OperatorCard;
use Illuminate\Http\Request;

class OperatorCardController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->query('limit', 10);

        $operatorCards = OperatorCard::with('dataPlans')
            ->whereStatus('active')
            ->paginate($limit);

        return response()->json($operatorCards);
    }
}
