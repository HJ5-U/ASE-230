<?php
namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::orderBy('id', 'asc')->get();
        return view('students.index', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'major' => 'required|string|max:255',
            'year' => 'required|integer|min:1|max:5',
        ]);

        Student::create($validated);
        return redirect()->route('students.index')->with('success', 'Student added successfully.');
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'major' => 'required|string|max:255',
            'year' => 'required|integer|min:1|max:5',
        ]);

        $student->update($validated);
        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted.');
    }

    public function destroyAll()
    {
        Student::truncate();
        return redirect()->route('students.index')->with('success', 'All students deleted.');
    }

    // API filtering methods
    public function show($id)
    {
        $student = Student::findOrFail($id);
        return response()->json($student);
    }

    public function getByName($name)
    {
        $students = Student::where('name', 'LIKE', '%' . $name . '%')
                          ->orderBy('id', 'asc')
                          ->get();
        return response()->json($students);
    }

    public function getByCourse($course)
    {
        $students = Student::where('course', 'LIKE', '%' . $course . '%')
                          ->orderBy('id', 'asc')
                          ->get();
        return response()->json($students);
    }

    public function getByMajor($major)
    {
        $students = Student::where('major', 'LIKE', '%' . $major . '%')
                          ->orderBy('id', 'asc')
                          ->get();
        return response()->json($students);
    }

    public function getByYear($year)
    {
        $students = Student::where('year', $year)
                          ->orderBy('id', 'asc')
                          ->get();
        return response()->json($students);
    }
}



