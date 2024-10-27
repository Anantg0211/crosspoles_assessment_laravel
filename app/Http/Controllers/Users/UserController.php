<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::query()->with('role');
            return DataTables::eloquent($users)
                ->addIndexColumn()
                ->editColumn('profile_picture', function ($user) {
                    return '<img src="' . asset('storage/profile_pictures/' . $user->profile_picture) . '" class="img-fluid" width="100" height="100" alt="profile picture">';
                })
                ->editColumn('created_at', function ($user) {
                    return $user->created_at->diffForHumans();
                })
                ->rawColumns(['profile_picture'])
                ->make(true);
        }
        $roles = Role::all();
        return view('welcome', compact('roles'));
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $data = $request->only(['role_id', 'name', 'email', 'phone_number', 'description']);
            if ($request->hasFile('profile_picture')) {
                $filename = $request->file('profile_picture')->store('public/profile_pictures');
                $data['profile_picture'] = basename($filename);
            }
            User::create($data);
            return response()->json(['message' => 'User created successfully']);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
