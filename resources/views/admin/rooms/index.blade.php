@extends('layouts.admin')

@section('title', 'Room Management')

@section('content')
@php
  // If you don't have $types from controller, you can fallback:
  $types = $types ?? ['MEETING ROOM', 'TRAINING', 'CONFERENCE'];
@endphp

<div class="flex items-start justify-between gap-6 mb-8">

  <button type="button"
    onclick="openRoomModal()"
    class="inline-flex items-center gap-2 rounded-2xl px-6 py-3
           bg-gradient-to-r from-sky-500 to-teal-400 text-slate-900 font-semibold
           hover:from-sky-400 hover:to-teal-300 transition">
    <span class="text-lg">+</span> Add Room
  </button>
</div>

{{-- Rooms grid --}}
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
  @foreach($rooms as $room)
    <div class="rounded-3xl bg-white/5 border border-white/10 shadow-xl overflow-hidden">
      <div class="p-6">
        <div class="flex items-start justify-between gap-4">
          <div class="h-12 w-12 rounded-2xl bg-teal-400/15 border border-teal-400/20 flex items-center justify-center">
            <span class="text-teal-200">💬</span>
          </div>

          <div class="flex items-center gap-2">
            {{-- Edit --}}
            <button type="button"
              onclick="openRoomModal(@js($room))"
              class="h-10 w-10 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition flex items-center justify-center"
              title="Edit">
              ✏️
            </button>

            {{-- Delete --}}
            <button type="button"
              onclick="openDeleteModal({{ $room->room_id }}, @js($room->room_name))"
              class="h-10 w-10 rounded-2xl bg-rose-500/10 border border-rose-400/20 hover:bg-rose-500/20 transition flex items-center justify-center"
              title="Delete">
              🗑️
            </button>
          </div>
        </div>

        <div class="mt-5">
          <div class="text-2xl font-bold text-slate-100">{{ $room->room_name }}</div>
          <div class="text-teal-300 text-xs font-semibold tracking-widest mt-1 uppercase">
            {{ $room->room_type ?? 'MEETING ROOM' }}
          </div>

          <div class="mt-4 space-y-2 text-slate-300">
            <div class="flex items-center gap-2">
              <span class="text-pink-300">📍</span>
              <span class="text-slate-300">{{ $room->floor ?? '—' }}</span>
            </div>
            <div class="flex items-center gap-2">
              <span class="text-purple-300">👥</span>
              <span class="text-slate-300">{{ $room->capacity ?? '—' }} seats</span>
            </div>
          </div>

          <div class="mt-5 flex items-center justify-between">
            <div class="flex flex-wrap gap-2">
              @php
                $eq = $room->equipment ?? [];
                if (is_string($eq)) $eq = json_decode($eq, true) ?: [];
              @endphp

              @foreach($eq as $tag)
                <span class="px-3 py-1 rounded-full text-xs bg-white/5 border border-white/10 text-slate-200">
                  {{ $tag }}
                </span>
              @endforeach
            </div>

            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-teal-500/15 border border-teal-400/20 text-teal-200">
              {{ ($room->is_active ?? 1) ? 'ACTIVE' : 'INACTIVE' }}
            </span>
          </div>
        </div>
      </div>
    </div>
  @endforeach
</div>

{{-- =========================
     CENTER MODAL: CREATE/EDIT
   ========================= --}}
<div id="roomModal"
  class="fixed inset-0 z-50 hidden">
  {{-- overlay --}}
  <div class="absolute inset-0 bg-slate-950/70 backdrop-blur-sm" onclick="closeRoomModal()"></div>

  {{-- ✅ PERFECT CENTER --}}
  <div class="relative h-full w-full flex items-center justify-center p-6">
    <div class="w-full max-w-2xl rounded-3xl bg-slate-900/60 border border-white/10 shadow-2xl overflow-hidden">
      <div class="px-8 py-6 border-b border-white/10 bg-gradient-to-r from-sky-500/10 to-teal-400/10">
        <div class="flex items-center justify-between">
          <h2 id="modalTitle" class="text-2xl font-bold text-slate-100">Add New Room</h2>
          <button type="button"
            onclick="closeRoomModal()"
            class="h-10 w-10 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition flex items-center justify-center text-slate-200">
            ✕
          </button>
        </div>
      </div>

      <form id="roomForm" method="POST" action="{{ route('admin.rooms.store') }}" class="p-8 space-y-6">
        @csrf
        <input type="hidden" name="_method" id="methodField" value="POST">

        <div>
          <label class="text-slate-300 font-semibold">Room Name</label>
          <input id="room_name" name="room_name" required
            class="mt-2 w-full rounded-2xl bg-white/5 border border-white/10 px-4 py-3 text-white
                   focus:outline-none focus:ring-2 focus:ring-teal-300/40"
            placeholder="e.g. Meeting Room 1">
        </div>

        <div>
          <label class="text-slate-300 font-semibold">Room Type</label>

          {{-- ✅ Cool-tone select + dark options --}}
          <select id="room_type" name="room_type"
            class="mt-2 w-full rounded-2xl bg-slate-950/40 border border-white/10 px-4 py-3 text-slate-100
                   focus:outline-none focus:ring-2 focus:ring-teal-300/40">
            @foreach($types as $t)
              <option class="bg-slate-900 text-slate-100" value="{{ $t }}">{{ $t }}</option>
            @endforeach
          </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="text-slate-300 font-semibold">Capacity</label>
            <input id="capacity" type="number" name="capacity" min="1"
              class="mt-2 w-full rounded-2xl bg-white/5 border border-white/10 px-4 py-3 text-white
                     focus:outline-none focus:ring-2 focus:ring-teal-300/40"
              placeholder="10">
          </div>

          <div>
            <label class="text-slate-300 font-semibold">Floor</label>
            <input id="floor" name="floor"
              class="mt-2 w-full rounded-2xl bg-white/5 border border-white/10 px-4 py-3 text-white
                     focus:outline-none focus:ring-2 focus:ring-teal-300/40"
              placeholder="Floor 1">
          </div>
        </div>

        <div>
          <label class="text-slate-300 font-semibold">Equipment</label>
          <div class="mt-3 grid grid-cols-1 md:grid-cols-3 gap-3">
            @foreach(['Projector','TV Screen','Video Conference'] as $eq)
              <label class="flex items-center gap-3 rounded-2xl bg-white/5 border border-white/10 px-4 py-3 text-slate-200 hover:bg-white/10 transition">
                <input type="checkbox" name="equipment[]" value="{{ $eq }}"
                  class="h-4 w-4 accent-teal-400">
                <span>{{ $eq }}</span>
              </label>
            @endforeach
          </div>
        </div>

        <div class="pt-2 flex justify-end gap-3">
          <button type="button"
            onclick="closeRoomModal()"
            class="rounded-2xl px-6 py-3 bg-white/10 border border-white/10 text-slate-200 hover:bg-white/15">
            Cancel
          </button>

          <button id="saveBtn" type="submit"
            class="rounded-2xl px-6 py-3 bg-gradient-to-r from-sky-500 to-teal-400 text-slate-900 font-semibold
                   hover:from-sky-400 hover:to-teal-300">
            Create
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- =========================
     COOL DELETE CONFIRM MODAL
   ========================= --}}
<div id="deleteModal" class="fixed inset-0 z-50 hidden">
  <div class="absolute inset-0 bg-slate-950/70 backdrop-blur-sm" onclick="closeDeleteModal()"></div>

  <div class="relative h-full w-full flex items-center justify-center p-6">
    <div class="w-full max-w-md rounded-3xl bg-slate-900/60 border border-white/10 shadow-2xl overflow-hidden">
      <div class="px-6 py-5 border-b border-white/10">
        <div class="flex items-start justify-between gap-4">
          <div>
            <div class="text-xl font-bold text-slate-100">Delete Room</div>
            <div class="text-slate-400 mt-1">This action cannot be undone.</div>
          </div>
          <button type="button"
            onclick="closeDeleteModal()"
            class="h-10 w-10 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition flex items-center justify-center text-slate-200">
            ✕
          </button>
        </div>
      </div>

      <div class="p-6">
        <div class="rounded-2xl bg-rose-500/10 border border-rose-400/20 px-4 py-3 text-rose-200">
          Are you sure you want to delete <span id="deleteRoomName" class="font-semibold"></span>?
        </div>

        <div class="pt-5 flex justify-end gap-3">
          <button type="button"
            onclick="closeDeleteModal()"
            class="rounded-2xl px-6 py-3 bg-white/10 border border-white/10 text-slate-200 hover:bg-white/15">
            Cancel
          </button>

          <form id="deleteForm" method="POST" action="#">
            @csrf
            @method('DELETE')
            <button type="submit"
              class="rounded-2xl px-6 py-3 bg-rose-500/20 border border-rose-400/30 text-rose-200 hover:bg-rose-500/30">
              Delete
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  const roomModal = document.getElementById('roomModal');
  const deleteModal = document.getElementById('deleteModal');

  function openRoomModal(room = null) {
    // reset checkboxes
    document.querySelectorAll('#roomForm input[type="checkbox"]').forEach(cb => cb.checked = false);

    if (!room) {
      document.getElementById('modalTitle').innerText = 'Add New Room';
      document.getElementById('saveBtn').innerText = 'Create';

      document.getElementById('roomForm').action = @json(route('admin.rooms.store'));
      document.getElementById('methodField').value = 'POST';

      document.getElementById('room_name').value = '';
      document.getElementById('room_type').value = document.getElementById('room_type').options[0].value;
      document.getElementById('capacity').value = '';
      document.getElementById('floor').value = '';
    } else {
      document.getElementById('modalTitle').innerText = 'Edit Room';
      document.getElementById('saveBtn').innerText = 'Save';

      // IMPORTANT: change this route name if yours is different
      const updateUrl = @json(url('/admin/rooms')) + '/' + room.room_id;
      document.getElementById('roomForm').action = updateUrl;
      document.getElementById('methodField').value = 'PUT';

      document.getElementById('room_name').value = room.room_name ?? '';
      document.getElementById('room_type').value = room.room_type ?? document.getElementById('room_type').options[0].value;
      document.getElementById('capacity').value = room.capacity ?? '';
      document.getElementById('floor').value = room.floor ?? '';

      let eq = room.equipment ?? [];
      if (typeof eq === 'string') {
        try { eq = JSON.parse(eq) } catch(e) { eq = [] }
      }

      document.querySelectorAll('#roomForm input[type="checkbox"]').forEach(cb => {
        cb.checked = Array.isArray(eq) && eq.includes(cb.value);
      });
    }

    roomModal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
  }

  function closeRoomModal() {
    roomModal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
  }

  function openDeleteModal(roomId, roomName) {
    document.getElementById('deleteRoomName').innerText = roomName;

    // IMPORTANT: change this base path if yours is different
    document.getElementById('deleteForm').action = @json(url('/admin/rooms')) + '/' + roomId;

    deleteModal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
  }

  function closeDeleteModal() {
    deleteModal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
  }
</script>
@endsection
