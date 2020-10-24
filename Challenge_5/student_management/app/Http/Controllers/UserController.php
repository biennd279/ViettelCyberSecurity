<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //View
    public function getIndex()
    {
        if (!\Auth::user()->can('viewAny', User::class)) {
            return response(null)->setStatusCode(304);
        }
        $users = User::all();
        return view('user.index', ['users' => $users]);
    }

    public function getUser(int $id)
    {
        $user = User::find($id);
        if (!\Auth::user()->can('view', $user)) {
            return response(null)->setStatusCode(304);
        }
        return view('user.show', ['user' => $user]);
    }

    public function getCreateUser()
    {
        if (!\Auth::user()->can('create', User::class)) {
            return redirect()->back();
        }
        $roles = Role::all();
        return view('user.create', ['roles' => $roles]);
    }

    public function getEditUser(int $id)
    {
        $user = User::find($id);
        if (!\Auth::user()->can('update', $user)) {
            return response(null)->setStatusCode(304);
        }
        $roles = Role::all();
        return view('user.edit', ['user' => $user, 'roles' => $roles]);
    }

    //API
    public function postCreate(Request $request)
    {
        if (!\Auth::user()->can('create', User::class)) {
            return response(null)->setStatusCode(304);
        }

        if (!\Auth::user()->can('createAny', User::class)) {
            if (Role::find($request->input('role_id'))->name != 'student') {
                return response(null)->setStatusCode(304);
            }
        }

        $user = new User([
            'user_name' => $request->input('user_name'),
            'name' => $request->input('name'),
            'password' => $request->input('password'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'role_id' => $request->input('role_id')
        ]);
        $user->save();
        return redirect()->route('user.index');
    }

    public function postEditUser(Request $request)
    {
        $user = User::find($request->input('id'));

        if (!\Auth::user()->can('update', $user)) {
            return response(null)->setStatusCode(304);
        }

        if (\Auth::user()->can('updateAny', User::class)) {
            $user->role_id = $request->input('role_id');
        }
        elseif ($request->input('role_id')) {
            return response(null)->setStatusCode(304);
        }

        if (\Auth::user()->can('updateBaseInfo', User::class)) {

            $user->user_name = $request->input('user_name');
            $user->name = $request->input('name');
        }
        elseif ($request->input('user_name') || $request->input('name')) {
                return response(null)->setStatusCode(304);
        }

        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        if ($request->input('password')) {
            $user->password = $request->input('password');
        }
        $user->save();
        return redirect()->route('user.index');
    }

    public function getDelete(int $id)
    {
        $user = User::find($id);

        if (!\Auth::user()->can('delete', $user)) {
            return redirect()->back();
        }

        $user->delete();
        return redirect()->route('user.index');
    }

    public function getStudent()
    {
        $student_role_id = Role::where('name', 'student')->first()->id;
        $students = User::where('role_id', $student_role_id)->get();
        return view('user.index', ['users' => $students]);
    }

    public function getTeacher()
    {
        $teacher_role_id = Role::where('name', 'teacher')->first()->id;
        $teachers = User::where('role_id', $teacher_role_id)->get();
        return view('user.index', ['users' => $teachers]);
    }
}
