<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    private array $equipmentOptions = ['Projector', 'TV Screen', 'Video Conference'];

    public function index()
    {
        $rooms = Room::orderBy('room_id', 'desc')->get();
        $equipmentOptions = $this->equipmentOptions;

        return view('admin.rooms.index', compact('rooms', 'equipmentOptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_name' => ['required', 'string', 'max:255'],
            'room_type' => ['required', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:1'],
            'floor' => ['required', 'string', 'max:255'],
            'equipment' => ['nullable', 'array'],
            'equipment.*' => ['in:Projector,TV Screen,Video Conference'],
        ]);

        Room::create([
            'room_name' => $validated['room_name'],
            'room_type' => $validated['room_type'],
            'capacity' => $validated['capacity'],
            'floor' => $validated['floor'],
            'equipment' => $validated['equipment'] ?? [],
            'is_active' => 1,
        ]);

        return redirect()->route('admin.rooms.index')->with('success', 'Room created successfully.');
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_name' => ['required', 'string', 'max:255'],
            'room_type' => ['required', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:1'],
            'floor' => ['required', 'string', 'max:255'],
            'equipment' => ['nullable', 'array'],
            'equipment.*' => ['in:Projector,TV Screen,Video Conference'],
        ]);

        $room->update([
            'room_name' => $validated['room_name'],
            'room_type' => $validated['room_type'],
            'capacity' => $validated['capacity'],
            'floor' => $validated['floor'],
            'equipment' => $validated['equipment'] ?? [],
        ]);

        return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully.');
    }
}
