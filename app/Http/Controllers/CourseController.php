<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseContentRequest;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $courses = [];

        $courses = Course::withTrashed();

        if (auth()->user()->role == 'teacher') {
            $courses = $courses->where('lecturer_id', '=', auth()->user()->id);
        }

        if ($request->search != "") {
            $keyword = $request->search;

            $courses = $courses->where(function ($query) use ($keyword) {
                foreach (app(Course::class)->getFillable() as $column) {
                    $query->orWhere($column, 'LIKE', '%' . $keyword . '%');
                }
            });
        }

        $courses = $courses->orderBy('updated_at', 'desc')->paginate(10);

        return view('course.index', [
            "courses" => $courses,
        ]);
    }

    public function create_view()
    {
        $teachers = User::where('role', '=', 'teacher')->get();

        return view('course.form', [
            "teachers" => $teachers,
            "editable" => false
        ]);
    }

    public function create(CourseRequest $request)
    {
        $teacher = $request->teacher;

        if (auth()->user()->role == 'teacher') {
            $teacher = auth()->user()->id;
        }

        Course::create([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'lecturer_id' => $teacher,
            'description' => $request->description,
        ]);

        return to_route('course.index');
    }

    public function update_view(string $course_id)
    {
        $teachers = User::where('role', '=', 'teacher')->get();

        $course = Course::find($course_id);

        if ($course == null) {
            abort(404);
        }

        return view('course.form', [
            'editable' => true,
            'course' => $course,
            "teachers" => $teachers,
        ]);
    }

    public function update(CourseRequest $request)
    {
        $course = Course::find($request->id);

        if ($course != null) {
            $course->name = $request->name;
            $course->start_date = $request->start_date;
            $course->end_date = $request->end_date;
            $course->description = $request->description;
            $course->lecturer_id = $request->teacher;

            $course->save();
        }


        return to_route('course.index');
    }

    public function deactivate(Request $request)
    {
        $course = Course::find($request->id);

        if ($course != null) {
            $course->delete();
        }

        return to_route('course.index');
    }

    public function activate(Request $request)
    {
        $course = Course::withTrashed()->find($request->id);

        if ($course != null) {
            $course->restore();
        }

        return to_route('course.index');
    }

    public function delete(Request $request)
    {
        $course = Course::find($request->id);

        if (count($course->users) > 0) {
            $student_count = count($course->users);

            return to_route('course.index')->with('error', [
                'message' => 'Course tidak dapat dihapus. Terdapat ' . $student_count . ' yang terhubung dengan course ini!'
            ]);
        }

        $course->forceDelete();

        return to_route('course.index')->with('success', [
            'message' => 'Course telah berhasil dihapus secara permanen!'
        ]);
    }

    public function details(string $id)
    {
        $course = Course::find($id);

        if (collect(['superadmin', 'admin', 'teacher'])->contains(Auth::user()->role))
            return view('course.back_details', [
                'course' => $course
            ]);
    }

    public function create_content_view(string $id)
    {
        $course = Course::find($id);

        return view('course.content.form', [
            'editable' => false,
            'course' => $course,
        ]);
    }

    public function create_content(CourseContentRequest $request)
    {
        $course_id = $request->course_id;

        $course = Course::find($course_id);

        $content = [
            'name' => $request->name,
            'description' => $request->description,
        ];

        if ($request->file) {
            $timestamp = time();
            $file_name = $timestamp . '_' . $request->file->getClientOriginalName();
            $file_path = $request->file('file')->storeAs('uploads', $file_name, 'local');
            $content['filename'] = $file_name;
        }

        $course->contents()->create($content);

        return to_route('course.details', ['id' => $course->id]);
    }

    public function update_content_view(string $id, string $content_id)
    {
        $course = Course::find($id);
        $content = $course->contents->find($content_id);

        return view('course.content.form', [
            'editable' => true,
            'course' => $course,
            'content' => $content,
        ]);
    }

    public function update_content(string $id, CourseContentRequest $request)
    {
        $course = Course::find($id);
        $content = $course->contents->find($request->id);

        if ($content) {
            $content->name = $request->name;
            $content->description = $request->description;
            if ($request->file) {
                $timestamp = time();
                $file_name = $timestamp . '_' . $request->file->getClientOriginalName();
                $file_path = $request->file('file')->storeAs('uploads', $file_name, 'local');
                $content->filename = $file_name;
            }
            $content->save();
        }

        return to_route('course.details', ['id' => $course->id]);
    }
}
