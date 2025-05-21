<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Actus;
use App\Models\Event;
use Carbon\Carbon;

class ActualitesController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $now = Carbon::today();

        // Actus à venir ou aujourd'hui
        $actusAvenir = Actus::whereDate('date', '>=', $now)
            ->orderBy('date', 'asc')
            ->get();

        // Actus passées
        $actusPassees = Actus::whereDate('date', '<', $now)
            ->orderBy('date', 'desc')
            ->get();

        // Events à venir ou aujourd'hui
        $eventsAvenir = Event::whereDate('date', '>=', $now)
            ->orderBy('date', 'asc')
            ->get();

        return view('actus', [
            'user'          => $user,
            'actusAvenir'   => $actusAvenir,
            'actusPassees'  => $actusPassees,
            'eventsAvenir'  => $eventsAvenir,
        ]);
    }
}
