<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $departments = Department::query()
            ->when($q, fn ($query) => $query->where('depart_name', 'like', "%{$q}%"))
            ->orderBy('depart_name')
            ->get();

        return view('admin.departments.index', compact('departments', 'q'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'depart_name' => ['required', 'string', 'max:255'],
            'head_of_department' => ['nullable', 'string', 'max:255'],
            'badge_color' => ['nullable', 'string', 'max:30'],
            'badge_text' => ['nullable', 'string', 'max:5'],
        ]);


        if (empty($data['badge_text'])) {
            $data['badge_text'] = $this->makeBadgeText($data['depart_name']);
        }
        if (empty($data['badge_color'])) {
            $data['badge_color'] = $this->guessColor($data['depart_name']);
        }

        Department::create($data);

        return redirect()
            ->route('admin.departments.index')
            ->with('toast', ['type' => 'success', 'message' => 'Department created']);
    }

    public function update(Request $request, Department $department)
    {
        $data = $request->validate([
            'depart_name' => ['required', 'string', 'max:255'],
            'head_of_department' => ['nullable', 'string', 'max:255'],
            'badge_color' => ['nullable', 'string', 'max:30'],
            'badge_text' => ['nullable', 'string', 'max:5'],
        ]);

        if (empty($data['badge_text'])) {
            $data['badge_text'] = $this->makeBadgeText($data['depart_name']);
        }
        if (empty($data['badge_color'])) {
            $data['badge_color'] = $this->guessColor($data['depart_name']);
        }

        $department->update($data);

        return redirect()
            ->route('admin.departments.index')
            ->with('toast', ['type' => 'success', 'message' => 'Department updated']);
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()
            ->route('admin.departments.index')
            ->with('toast', ['type' => 'success', 'message' => 'Department deleted']);
    }

    private function makeBadgeText(string $name): string
    {
        $upper = strtoupper(trim($name));
        // Common abbreviations
        $map = [
            'HUMAN RESOURCES' => 'HR',
            'INFORMATION TECHNOLOGY' => 'IT',
            'TECHNOLOGY' => 'IT',
            'MARKETING' => 'M',
            'ENGINEERING' => 'E',
            'SALES' => 'S',
            'FINANCE' => 'F',
        ];

        foreach ($map as $key => $val) {
            if (str_contains($upper, $key)) {
                return $val;
            }
        }

        // First 1-2 letters
        $words = preg_split('/\s+/', $upper);
        if (count($words) >= 2) {
            return substr($words[0], 0, 1).substr($words[1], 0, 1);
        }

        return substr($upper, 0, 1);
    }

    private function guessColor(string $name): string
    {
        $upper = strtoupper($name);
        if (str_contains($upper, 'MARKET')) {
            return 'pink';
        }
        if (str_contains($upper, 'HUMAN') || str_contains($upper, 'HR')) {
            return 'amber';
        }
        if (str_contains($upper, 'ENGINEER')) {
            return 'sky';
        }
        if (str_contains($upper, 'SALES')) {
            return 'emerald';
        }
        if (str_contains($upper, 'IT') || str_contains($upper, 'TECH')) {
            return 'violet';
        }

        return 'teal';
    }
}
