<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('profile.index',compact('users'));
    }
    
    public function edit(User $user)
    {
        $this->authorize('update',$user);
        
        return view('profile.edit',compact('user'));
    }
    
    public function update(User $user , Request $request)
    {
        $this->authorize('update', $user);
        
        $inputs = request()->validate([
            'name' => 'required|max:255',
            'email' => ['required','email','max:255', Rule::unique('users')->ignore($user->id)],
            'avatar' => 'image|max:2048',
            'password'=>'required|confirmed|max:255|min:8',
            'password_confirmation' => 'required|same:password'
            ]);
            
        $inputs['password'] = Hash::make($inputs['password']);
        
        
        if(request()->hasFile('avatar'))
        {
            //アバター画像を変更したら古い画像を消去するコード
            if($user->avatar !== 'user_default.jpg')
            {
                $old = 'public/avatar/'.$user->avatar;
                Storage::delete($old);
            }
            
            $uniq = uniqid(rand().'_');
            $name = request()->File('avatar')->getClientOriginalName();
            $avatar = $uniq.$name;
            request()->file('avatar')->storeAs('public/avatar/', $avatar);
            
            $inputs['avatar'] = $avatar;
        }
        $user->update($inputs);
        return back()->with('message', 'プロフィールを更新しました');
    }
}
