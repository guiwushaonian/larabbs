<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

    // show
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    // edit
    public function edit(User $user)
    {
        // 验证授权策略
        $this->authorize('update', $user);

        return view('users.edit', compact('user'));
    }

    // update
    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $this->authorize('update', $user);

        $data = $request->all();
        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 362);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }
        $user->update($data);

        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功');
    }
}