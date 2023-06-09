<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $user = User::find($id);
        $user->fill($input)->save();
        toastr()->success('Your details have been updated successfully');
        return back();
    }
}
