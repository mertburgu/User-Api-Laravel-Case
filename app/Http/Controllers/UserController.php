<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    use SoftDeletes;

    public function list()
    {
        $users = User::all();
        return response()->json(['data' => $users], 200);
    }

    public function insert(UserRequest $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);

        try {
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->username = $request->input('username');
            $user->password = bcrypt($request->input('password'));
            $user->save();

            return response()->json(['message' => 'Kullanıcı başarıyla oluşturuldu'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Kullanıcı oluşturulurken bir hata oluştu'], 500);
        }
    }

    public function update(UserRequest $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'username' => 'required|unique:users,username,' . $id,
            'password' => 'nullable|min:6',
        ]);

        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Kullanıcı bulunamadı'], 404);
        }

        try {
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->username = $request->input('username');
            if ($request->has('password')) {
                $user->password = bcrypt($request->input('password'));
            }
            $user->save();

            return response()->json(['message' => 'Kullanıcı başarıyla güncellendi'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Kullanıcı güncellenirken bir hata oluştu'], 500);
        }
    }

    public function delete($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Kullanıcı bulunamadı'], 404);
        }

        try {
            $user->delete();
            return response()->json(['message' => 'Kullanıcı başarıyla silindi'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Kullanıcı silinirken bir hata oluştu'], 500);
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Kullanıcı bulunamadı'], 404);
        }

        try {
            $user->forceDelete();
            return response()->json(['message' => 'Kullanıcı başarıyla kalıcı olarak silindi'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Kullanıcı kalıcı olarak silinirken bir hata oluştu'], 500);
        }
    }
}
