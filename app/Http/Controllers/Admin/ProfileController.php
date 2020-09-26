<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Profile;

class ProfileController extends Controller
{
  
    public $genders = [
      'female' => '女',
      'male' => '男',
      'other' => 'その他',
      'none' => '未回答',
      ];
  
    //
    public function add()
    {
      return view('admin.profile.create', ['genders' => $this->genders]);
    }
    
    public function create(Request $request)
    {
      
      $this->validate($request, Profile::$rules);
  
      $profile = new Profile;
      $form = $request->all();

      unset($form['_token']);

      $profile->fill($form);
      $profile->save();
      
      return redirect('admin/profile/create');
    }
    
    public function index(Request $request)
    {
      $cond_title = $request->cond_title;
      if ($cond_title != '') {
          $posts = Profile::where('title', $cond_title)->get();
      } else {
          $posts = Profile::all();
      }
      return view('admin.profile.index', ['posts' => $posts, 'cond_title' => $cond_title, 'genders' => $this->genders]);
    }
    
    
    public function edit(Request $request)
    {
      
      $profile = Profile::find($request->id);
      // dd($profile);
      return view('admin.profile.edit', ['profile_form' => $profile, 'genders' => $this->genders]);
    }
    
    
    public function update(Request $request)
    {
      // Validationをかける
      $this->validate($request, Profile::$rules);
      // Profile Modelからデータを取得する
      $profile = Profile::find($request->id);
      // 送信されてきたフォームデータを格納する
      $profile_form = $request->all();
      
      unset($profile_form['_token']);

      // 該当するデータを上書きして保存する
      $profile->fill($profile_form)->save();

      return redirect('admin/profile/');
    }
    
    public function delete(Request $request)
    {
      // 該当するProfile Modelを取得
      $profile = Profile::find($request->id);
      // 削除する
      $profile->delete();
      return redirect('admin/profile/');
    }
    
}
