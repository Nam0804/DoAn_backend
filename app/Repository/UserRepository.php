<?php

namespace App\Repository;

use App\Models\Admin;
use App\Repository\interface\BaseUserRepository;
use Illuminate\Support\Facades\DB;

class UserRepository implements BaseUserRepository
{
    public function all()
    {
        //kết hợp bảng admin với băng user để lấy ra tất cả thông tin
        $allData = DB::table('admins')->get();
        return $allData;
    }
    public function create(array $data)
    {
        $user = new Admin();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        $user->type = $data['type'];
        $user->password = bcrypt($data['password']);
        $user->address = $data['address'];
        $user->save();
        return $user;
    }
    public function update(array $data, $id)
    {
        $user = Admin::findOrFail($id);
        $user->update($data);
        return $user;
    }
    public function delete($id)
    {
        $user = Admin::findOrFail($id);
        $user->delete();
        return $user;
    }
    public function show($id)
    {
        return Admin::findOrFail($id);
    }

}
