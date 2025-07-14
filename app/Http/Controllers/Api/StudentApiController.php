<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentApiController extends Controller
{
    // GET /api/students
    public function index()
    {
        $students = Student::all();

        return response()->json([
            'status' => 'success',
            'count' => $students->count(),
            'data' => $students
        ], 200);
    }

    // GET /api/students/{id}
    public function show($id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['status' => 'error', 'message' => 'Student not found'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $student], 200);
    }

    // POST /api/students
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:students',
            'phone' => 'nullable|string|max:20',
        ]);

        $student = Student::create($validated);

        return response()->json(['status' => 'success', 'data' => $student], 201);
    }

    // PUT /api/students/{id}
    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['status' => 'error', 'message' => 'Student not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:students,email,'.$id,
            'phone' => 'sometimes|string|max:20',
        ]);

        $student->update($validated);

        return response()->json(['status' => 'success', 'data' => $student], 200);
    }

    // DELETE /api/students/{id}
    public function destroy($id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['status' => 'error', 'message' => 'Student not found'], 404);
        }

        $student->delete();

        return response()->json(['status' => 'success', 'message' => 'Student deleted'], 200);
    }
}
