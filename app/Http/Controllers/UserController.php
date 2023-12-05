<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = [];

        if ($request->search != "") {
            $keyword = $request->search;

            $users = User::withTrashed()->where('role', '!=', 'student')->where(function ($query) use ($keyword) {
                foreach (app(User::class)->getFillable() as $column) {
                    $query->orWhere($column, 'LIKE', '%' . $keyword . '%');
                }
            })->orderBy('updated_at', 'desc')->paginate(10);
        } else
            $users = User::withTrashed()->where('role', '!=', 'student')->orderBy('updated_at', 'desc')->paginate(10);

        return view('user.index', [
            "users" => $users,
        ]);
    }

    public function create_view()
    {
        return view('user.form', [
            'editable' => false,
        ]);
    }

    public function create(UserRequest $request)
    {
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->username),
        ]);

        return to_route('user.index');
    }

    public function update_view(string $user_id)
    {
        $user = User::find($user_id);

        if ($user == null) {
            abort(404);
        }

        return view('user.form', [
            'editable' => true,
            'user' => $user
        ]);
    }

    public function update(UserRequest $request)
    {
        $user = User::find($request->id);

        if ($user != null) {
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->role = $request->role;

            $user->save();
        }


        return to_route('user.index');
    }

    public function deactivate(Request $request)
    {
        $user = User::find($request->id);

        if ($user != null) {
            $user->delete();
        }

        return to_route('user.index');
    }

    public function activate(Request $request)
    {
        $user = User::withTrashed()->find($request->id);

        if ($user != null) {
            $user->restore();
        }

        return to_route('user.index');
    }
}
