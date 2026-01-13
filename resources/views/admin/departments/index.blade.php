@extends('layouts.admin')
@section('title', 'Departments')

@section('content')

{{-- Top row: title + search + add button --}}
<div class="flex items-center justify-between gap-6 mb-8">
    <div>
        <h1 class="text-2xl font-bold">Manage organization departments</h1>
        <p class="text-slate-300 mt-1">Create, edit and remove departments used in user registration.</p>
    </div>

    <div class="flex items-center gap-4">
        <!-- Search -->
        <form method="GET" action="{{ route('admin.departments.index') }}" class="w-[420px] max-w-full">
            <div class="relative">
                <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m21 21-4.3-4.3m1.3-5.2a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                    </svg>
                </span>

                <input type="text" name="q" value="{{ request('q') }}"
                       placeholder="Search departments..."
                       class="w-full rounded-xl
                              bg-white/5 border border-white/10
                              px-10 py-3 text-slate-100 placeholder:text-slate-400
                              focus:outline-none focus:ring-2 focus:ring-sky-400/30 focus:border-sky-400/40" />
            </div>
        </form>

        <!-- Add Department (straight corners) -->
        <button onclick="openCreateModal()"
                class="inline-flex items-center gap-2
                       rounded-xl px-6 py-3 font-semibold
                       bg-gradient-to-r from-sky-500 to-teal-400 text-slate-900
                       hover:from-sky-400 hover:to-teal-300 transition
                       border border-white/10">
            <span class="text-xl leading-none">+</span>
            Add Department
        </button>
    </div>
</div>

{{-- Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
@forelse($departments as $d)
    @php
        $badgeText = $d->badge_text ?: strtoupper(substr($d->depart_name,0,1));
        $color = $d->badge_color ?: 'teal';
        $colorMap = [
            'sky' => 'bg-sky-500',
            'teal' => 'bg-teal-500',
            'pink' => 'bg-pink-500',
            'amber' => 'bg-amber-500',
            'emerald' => 'bg-emerald-500',
            'violet' => 'bg-violet-500',
        ];
        $badgeClass = $colorMap[$color] ?? 'bg-teal-500';
    @endphp

    <div class="rounded-3xl bg-white/5 border border-white/10 shadow-xl overflow-hidden">
        <div class="p-6 text-center">
            <div class="mx-auto h-16 w-16 rounded-full {{ $badgeClass }} text-white flex items-center justify-center text-xl font-bold">
                {{ $badgeText }}
            </div>

            <h3 class="mt-5 text-xl font-bold text-slate-100">{{ $d->depart_name }}</h3>

            <p class="mt-2 text-xs tracking-widest uppercase text-slate-400">Head of dept</p>
            <p class="mt-1 text-slate-200">
                {{ $d->head_of_department ?: '—' }}
            </p>
        </div>

        <div class="border-t border-white/10 px-6 py-4 flex items-center justify-center gap-8 text-sm">
            <button
                onclick='openEditModal(@json($d))'
                class="inline-flex items-center gap-2 text-slate-300 hover:text-sky-300 transition">
                <span>✎</span> Edit
            </button>

            <button
                onclick='openDeleteModal(@json($d))'
                class="inline-flex items-center gap-2 text-rose-300 hover:text-rose-200 transition">
                <span>🗑</span> Delete
            </button>
        </div>
    </div>
@empty
    <div class="rounded-3xl bg-white/5 border border-white/10 p-10 text-center text-slate-400 col-span-full">
        No departments found.
    </div>
@endforelse
</div>

{{-- TOAST --}}
@if(session('toast'))
    @php($t = session('toast')) {{-- ['type'=>'success'|'error','message'=>'...'] --}}
    <div id="toast"
         class="fixed bottom-20 right-8 z-[70]
                flex items-center gap-3 rounded-2xl border border-white/10
                bg-slate-900/90 backdrop-blur-xl px-5 py-3 shadow-2xl
                translate-x-6 opacity-0 transition duration-300">
        <div class="h-9 w-1 rounded-full {{ $t['type'] === 'success' ? 'bg-emerald-400' : 'bg-rose-400' }}"></div>
        <div class="text-slate-100 font-medium">{{ $t['message'] }}</div>
    </div>

    <script>
        // slide in
        requestAnimationFrame(() => {
            const el = document.getElementById('toast');
            if (!el) return;
            el.classList.remove('translate-x-6','opacity-0');
        });

        // slide out
        setTimeout(() => {
            const el = document.getElementById('toast');
            if (!el) return;
            el.classList.add('translate-x-6','opacity-0');
            setTimeout(() => el.remove(), 300);
        }, 2500);
    </script>
@endif


{{-- CREATE MODAL --}}
<div id="createModal" class="hidden fixed inset-0 z-50">
    <div class="absolute inset-0 bg-black/60" onclick="closeCreateModal()"></div>
    <div class="relative mx-auto mt-20 w-[92%] max-w-xl rounded-3xl bg-slate-900 border border-white/10 p-8 shadow-2xl">
        <h3 class="text-2xl font-bold text-slate-100 mb-6">Add Department</h3>

        <form method="POST" action="{{ route('admin.departments.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="text-slate-300 font-semibold">Department Name</label>
                <input name="depart_name" required
                       class="mt-2 w-full rounded-2xl bg-white/5 border border-white/10 px-4 py-3 text-slate-100
                              placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-teal-300/40"
                       placeholder="e.g. Engineering">
            </div>

            <div>
                <label class="text-slate-300 font-semibold">Head of Department</label>
                <input name="head_of_department"
                       class="mt-2 w-full rounded-2xl bg-white/5 border border-white/10 px-4 py-3 text-slate-100
                              placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-teal-300/40"
                       placeholder="e.g. Alice Smith">
            </div>

            {{-- Badge preview / choose --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="text-slate-300 font-semibold">Badge Text</label>
                    <input name="badge_text"
                           class="mt-2 w-full rounded-2xl bg-white/5 border border-white/10 px-4 py-3 text-slate-100
                                  placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-teal-300/40"
                           placeholder="Auto (HR / IT / M)">
                </div>

                <div>
                    <label class="text-slate-300 font-semibold">Badge Color</label>
                   <select
    name="badge_color"
    class="mt-2 w-full rounded-2xl
           bg-slate-800 text-slate-100
           border border-white/10
           px-4 py-3
           focus:outline-none focus:ring-2 focus:ring-teal-400"
>
    <option value="auto" class="bg-slate-800 text-white">Auto</option>
    <option value="teal" class="bg-slate-800 text-teal-300">Teal</option>
    <option value="sky" class="bg-slate-800 text-sky-300">Sky</option>
    <option value="pink" class="bg-slate-800 text-pink-300">Pink</option>
    <option value="amber" class="bg-slate-800 text-amber-300">Amber</option>
    <option value="emerald" class="bg-slate-800 text-emerald-300">Emerald</option>
    <option value="violet" class="bg-slate-800 text-violet-300">Violet</option>
</select>
                </div>
            </div>

            <div class="pt-4 flex justify-end gap-3">
                <button type="button" onclick="closeCreateModal()"
                        class="rounded-2xl px-6 py-3 bg-white/10 border border-white/10 text-slate-200 hover:bg-white/15">
                    Cancel
                </button>
                <button type="submit"
                        class="rounded-2xl px-6 py-3 bg-gradient-to-r from-sky-500 to-teal-400 text-slate-900 font-semibold
                               hover:from-sky-400 hover:to-teal-300">
                    Save Department
                </button>
            </div>
        </form>
    </div>
</div>

{{-- EDIT MODAL --}}
<div id="editModal" class="hidden fixed inset-0 z-50">
    <div class="absolute inset-0 bg-black/60" onclick="closeEditModal()"></div>
    <div class="relative mx-auto mt-20 w-[92%] max-w-xl rounded-3xl bg-slate-900 border border-white/10 p-8 shadow-2xl">
        <h3 class="text-2xl font-bold text-slate-100 mb-6">Edit Department</h3>

        <form id="editForm" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="text-slate-300 font-semibold">Department Name</label>
                <input id="edit_depart_name" name="depart_name" required
                       class="mt-2 w-full rounded-2xl bg-white/5 border border-white/10 px-4 py-3 text-slate-100
                              focus:outline-none focus:ring-2 focus:ring-teal-300/40">
            </div>

            <div>
                <label class="text-slate-300 font-semibold">Head of Department</label>
                <input id="edit_head" name="head_of_department"
                       class="mt-2 w-full rounded-2xl bg-white/5 border border-white/10 px-4 py-3 text-slate-100
                              focus:outline-none focus:ring-2 focus:ring-teal-300/40">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="text-slate-300 font-semibold">Badge Text</label>
                    <input id="edit_badge_text" name="badge_text"
                           class="mt-2 w-full rounded-2xl bg-white/5 border border-white/10 px-4 py-3 text-slate-100
                                  focus:outline-none focus:ring-2 focus:ring-teal-300/40">
                </div>

                <div>
                    <label class="text-slate-300 font-semibold">Badge Color</label>
                    <select id="edit_badge_color" name="badge_color"
                            class="appearance-none mt-2 w-full rounded-2xl
       bg-slate-800/80 border border-white/10 px-4 py-3 pr-10
       text-slate-100
       focus:outline-none focus:ring-2 focus:ring-teal-300/40
       [&>option]:bg-slate-900 [&>option]:text-slate-100"
>
                        <option value="">Auto</option>
                        <option value="teal">Teal</option>
                        <option value="sky">Sky</option>
                        <option value="pink">Pink</option>
                        <option value="amber">Amber</option>
                        <option value="emerald">Emerald</option>
                        <option value="violet">Violet</option>
                    </select>
                </div>
            </div>

            <div class="pt-4 flex justify-end gap-3">
                <button type="button" onclick="closeEditModal()"
                        class="rounded-2xl px-6 py-3 bg-white/10 border border-white/10 text-slate-200 hover:bg-white/15">
                    Cancel
                </button>
                <button type="submit"
                        class="rounded-2xl px-6 py-3 bg-gradient-to-r from-sky-500 to-teal-400 text-slate-900 font-semibold
                               hover:from-sky-400 hover:to-teal-300">
                    Save Department
                </button>
            </div>
        </form>
    </div>
</div>

{{-- DELETE CONFIRM MODAL --}}
<div id="deleteModal" class="hidden fixed inset-0 z-50">
    <div class="absolute inset-0 bg-black/60" onclick="closeDeleteModal()"></div>
    <div class="relative mx-auto mt-28 w-[92%] max-w-md rounded-3xl bg-slate-900 border border-white/10 p-8 shadow-2xl text-center">
        <div class="mx-auto h-14 w-14 rounded-full bg-rose-500/15 border border-rose-500/30 flex items-center justify-center text-rose-300 text-3xl">
            !
        </div>

        <h3 class="mt-5 text-2xl font-bold text-slate-100">Delete Department?</h3>
        <p class="mt-2 text-slate-400">
            Are you sure you want to remove <span id="deleteName" class="font-semibold text-slate-200"></span>?
            This action cannot be undone.
        </p>

        <div class="mt-7 flex items-center justify-center gap-4">
            <button type="button" onclick="closeDeleteModal()"
                    class="rounded-2xl px-6 py-3 bg-white/10 border border-white/10 text-slate-200 hover:bg-white/15">
                Cancel
            </button>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button
                    class="rounded-2xl px-6 py-3 bg-rose-500/20 border border-rose-500/30 text-rose-200
                           hover:bg-rose-500/30 transition">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    const createModal = document.getElementById('createModal');
    const editModal   = document.getElementById('editModal');
    const deleteModal = document.getElementById('deleteModal');

    const editForm = document.getElementById('editForm');
    const deleteForm = document.getElementById('deleteForm');

    function openCreateModal(){ createModal.classList.remove('hidden'); }
    function closeCreateModal(){ createModal.classList.add('hidden'); }

    function openEditModal(dep){
        editModal.classList.remove('hidden');
        editForm.action = `/admin/departments/${dep.depart_id}`;

        document.getElementById('edit_depart_name').value = dep.depart_name ?? '';
        document.getElementById('edit_head').value = dep.head_of_department ?? '';
        document.getElementById('edit_badge_text').value = dep.badge_text ?? '';
        document.getElementById('edit_badge_color').value = dep.badge_color ?? '';
    }
    function closeEditModal(){ editModal.classList.add('hidden'); }

    function openDeleteModal(dep){
        deleteModal.classList.remove('hidden');
        document.getElementById('deleteName').innerText = dep.depart_name ?? '';
        deleteForm.action = `/admin/departments/${dep.depart_id}`;
    }
    function closeDeleteModal(){ deleteModal.classList.add('hidden'); }
</script>

@endsection
