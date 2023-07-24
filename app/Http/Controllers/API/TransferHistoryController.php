<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TransferHistory;
use Illuminate\Http\Request;

class TransferHistoryController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->query('limit', 10);

        $transferHistories = TransferHistory::with('receiverUser:id,name,username,email_verified_at,profile_picture')
            ->select('receiver_id')
            ->whereSenderId(auth()->id())
            ->groupBy('receiver_id')
            ->paginate($limit);

        return response()->json($transferHistories);
    }
}
