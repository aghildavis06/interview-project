<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Models\UserInformation;
use App\Models\UserCategory;
use App\Models\UserHobbies;
use App\Models\UserHobby;


class UserController extends Controller
{
    public function create()
    {
        return view('pages.userinfo');
    }
    public function store(StoreUserRequest $request)
    {
        if ($request->hasFile('profile_pic')) {
            $profilePicName = time() . '.' . $request->profile_pic->extension();
            $request->profile_pic->move(public_path('images'), $profilePicName);
        }

        $userInfo = new UserInformation();
        $userInfo->name = $request->name;
        $userInfo->contact_no = $request->contact_no;
        $userInfo->profile_pic = $profilePicName;
        $userInfo->save();

        $userCategory = new UserCategory();
        $userCategory->user_id = $userInfo->id;
        $userCategory->category = $request->category;
        $userCategory->save();

        if ($request->has('hobbies')) {
            $userHobby = new UserHobby();
            $userHobby->user_id = $userInfo->id;
            $userHobby->hobby = implode(',', $request->hobbies); // Convert array to comma-separated string
            $userHobby->save();
        }

        return redirect('/')->with('success', 'User information added successfully');
    }
    public function index()
    {
        $users = UserInformation::with('categories', 'hobbies')->get();

        return response()
            ->view('welcome', compact('users'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function edit($id)
    {
        $userInfo = UserInformation::findOrFail($id);
        $userCategory = UserCategory::where('user_id', $id)->first();
        $userHobby = UserHobby::where('user_id', $id)->first();

        // Pass user data to the edit view
        return view('pages.updatepage', compact('userInfo', 'userCategory', 'userHobby'));
    }
    public function update(UpdateUserRequest $request, $id)
    {

        $userInfo = UserInformation::findOrFail($id);

        if ($request->hasFile('profile_pic')) {
            $profilePicName = time() . '.' . $request->profile_pic->extension();
            $request->profile_pic->move(public_path('images'), $profilePicName);

            if ($userInfo->profile_pic) {
                $oldPicPath = public_path('images') . '/' . $userInfo->profile_pic;
                if (file_exists($oldPicPath)) {
                    unlink($oldPicPath);
                }
            }

            $userInfo->profile_pic = $profilePicName;
        }

        $userInfo->name = $request->input('name', $userInfo->name);
        $userInfo->contact_no = $request->input('contact_no', $userInfo->contact_no);
        $userInfo->save();

        $userCategory = UserCategory::where('user_id', $userInfo->id)->first();
        if ($userCategory) {
            $userCategory->category = $request->input('category', $userCategory->category);
            $userCategory->save();
        } else {

            if ($request->filled('category')) {
                $newCategory = new UserCategory();
                $newCategory->user_id = $userInfo->id;
                $newCategory->category = $request->category;
                $newCategory->save();
            }
        }

        $userHobby = UserHobby::where('user_id', $userInfo->id)->first();
        if ($userHobby) {
            $userHobby->hobby = $request->filled('hobbies') ? implode(',', $request->hobbies) : $userHobby->hobby;
            $userHobby->save();
        } else {

            if ($request->filled('hobbies')) {
                $newHobby = new UserHobby();
                $newHobby->user_id = $userInfo->id;
                $newHobby->hobby = implode(',', $request->hobbies);
                $newHobby->save();
            }
        }

        return redirect('/')->with('success', 'User information updated successfully');
    }

    public function destroy($id)
    {

        $user = UserInformation::find($id);

        if ($user) {

            UserCategory::where('user_id', $user->id)->delete();

            UserHobby::where('user_id', $user->id)->delete();

            $user->delete();

            return response()->json(['success' => 'User and related information deleted successfully']);
        }

        return response()->json(['error' => 'User not found'], 404);
    }
}
