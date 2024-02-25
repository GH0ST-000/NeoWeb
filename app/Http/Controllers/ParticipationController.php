<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Participation;
use Illuminate\Http\Request;

class ParticipationController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json( Participation::with('campaign')->latest()->paginate(20));
    }
}
