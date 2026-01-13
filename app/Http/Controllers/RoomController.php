<?php

namespace App\Http\Controllers;

use App\Models\Room;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::query()
            ->where('is_active', 1)
            ->orderBy('room_name')
            ->get();

        return view('rooms.index', compact('rooms'));
    }
}
