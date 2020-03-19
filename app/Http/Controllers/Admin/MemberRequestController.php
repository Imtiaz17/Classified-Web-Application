<?php

namespace App\Http\Controllers\Admin;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Larapen\Admin\app\Http\Controllers\PanelController;

class MemberRequestController extends PanelController
{
	public function index()
	{
		$users=User::where('member_request',1)->get();
		return view('admin::Members.Storerequest', compact('users') );
	}
	public function acceptstore(Request $request, $id)
	{
		$user=User::find($id);
		$user->member_request=2;
		if ($user->is_member==0) {
			$user->is_member=1;
		}
		$user->save();
		return redirect()->back();
	}
	public function declinestore(Request $request, $id)
	{
		$user=User::find($id);
		$user->member_request=0;
		$user->save();
		return redirect()->back();
	}
	public function allstores(Request $request)
	{
		$stores=Store::all();
		return view('admin::Members.Allstores', compact('stores') );
	}
}