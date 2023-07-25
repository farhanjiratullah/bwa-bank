<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Tip;
use Illuminate\Http\Request;

class TipController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->query('limit', 10);

        $tips = Tip::select(['id', 'title', 'thumbnail', 'url'])->paginate($limit);

        return response()->json($tips);
    }
}
