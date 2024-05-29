<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Auth;

class UserController extends Controller
{
    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $users = $this->user->withTrashed()->paginate(10);

        return view('admin.users.index')
                ->with('users', $users);
    }

    public function softdelete($id)
    {
        $user = $this->user->findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users');
    }

    public function restore($id)
    {
        $user = $this->user->onlyTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('admin.users');
    }
}
