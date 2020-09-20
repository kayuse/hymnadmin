<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function get(Request $request, $id)
    {
        $user = User::with('appUser')->find($id);
        return response()->json($user);
    }

    public function authUser(Request $request)
    {
        $user = User::with('appUser')->find(auth()->user()->id);
        return response()->json($user);
    }

    public function authenticate(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required'
        ]);
        $user = User::with('appUser')->where('email', $validatedData['email'])->first();
        return response()->json($user);
    }

    //
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'mobile' => 'required',
            'dcc' => 'required',
            'lcb' => 'required',
            'language' => 'required'
        ]);

        $user = $this->repository->create($validatedData);
        return response()->json($user);
    }

    public function hasLatestUpdate(Request $request, $id)
    {
        $user = User::find($id);
        $user->appUser->has_latest_updates = 1;
        $user->appUser->save();
        return response()->json($user);
    }
}
