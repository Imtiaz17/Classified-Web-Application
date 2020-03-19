<?php

namespace App\Http\Controllers\Admin;
use App\Models\Post;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Larapen\Admin\app\Http\Controllers\PanelController;

class RequestedpromotionController extends PanelController
{
	public function index()
	{
		$promotions=Promotion::where('status','requested')->orderBy('id', 'DESC')->get();
		return view('admin::Package.promotionaccept',compact('promotions'));
	}

	public function update(Request $request)
	{
		$promotion=Promotion::find($request->promoid);
		$promotiotionpostid=$promotion->post_id;
		$promotion->status='accept';
		$promotion->save();
		$post=Post::where('id',$promotiotionpostid)->first();
		$post->featured=1;
		if ($request->package=='Spotlight')
		{
			$post->spotlight='1';
		}
		if ($request->package='Topad') 
		{
			$post->topad='1';
		}
		if ($request->package='Bumpad')
		{
			$post->bumpad='1';
			$post->created_at=now();
		}
		$post->save();
		\Alert::success('Promotion request has been accepted')->flash();
		return redirect()->back();
	}
	public function destroy($id,$childId = NULL)
	{
		$package=Promotion::find($id)->delete();
		\Alert::success('Promotion request has been declined')->flash();
        return redirect()->back();
	}
	
}