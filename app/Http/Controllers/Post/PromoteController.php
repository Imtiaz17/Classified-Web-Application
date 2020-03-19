<?php

namespace App\Http\Controllers\Post;
use App\Http\Controllers\FrontController;
use App\Models\BPackage;
use App\Models\Post;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Session;
class PromoteController extends FrontController
{
	public function index(Request $request)
	{
		$id=$request->route('id');
		$post=Post::where('id',$id)->first();
		$packages=BPackage::all();
		return view('promote.index',compact('packages','id','post'));
	}

	public function adpromote(Request $request)
	{
		$rules = [
            'totalprice' => 'required',
        ];
         $customMessages = [
        'required' => 'Please select add duration.'
    ];
      $this->validate($request, $rules, $customMessages);
		$count=count($request->package);
		$package= $request->package;
		$duration=array_filter($request->totalday);
		$price=$request->price;
		$totalprice= $request->totalprice;
		$post=Post::find($request->postid);
		$promotion=[];
		for ($i=0; $i<$count ; $i++) { 
			$promotion[] = new Promotion([
				'post_id'=>$request->postid,
				'package_id'=>$package[$i],
				'day'=>$duration[$package[$i]],
				'price'=>$price[$package[$i]],
				
			]);
		
		 }
		// $data=$post->promotions()->saveMany($promotion);
		 //Redirect::route('bkashpayment',array('title' =>$post->title,'id' =>$post->id));
		
		Session::put('promotion',$promotion);
		Session::put('post',$post);
		Session::put('tp',$totalprice);
		return redirect()->route('bkashpayment',array('title' =>slugify($post->title),'id' =>$post->id));
		
		
	}
	public function payment()
	{
		$promotions=Session::get('promotion');
		$totalprice=Session::get('tp');
		$post=Session::get('post');
		return view('promote.bkashpayment',compact('promotions','post','totalprice'));
	}
	public function bkashpayment(Request $request)
	{

		$promotions=Session::get('promotion');
		$count= count($promotions);
		$totalprice=Session::get('tp');
		$post=Session::get('post');
		$bkash_number=$request->bkashnumber;
		$transaction_id=$request->transactionid;
		foreach ($promotions as $key => $promotion) {
			$promotions=new Promotion();
			$promotions->post_id=$promotion->post_id;
			$promotions->package_name=$promotion->package_id;
			$promotions->duration=$promotion->day;
			$promotions->duration_price=$promotion->price;
			$promotions->total_price=$totalprice;
			$promotions->bkash_number=$bkash_number;
			$promotions->transaction_id=$transaction_id;
			$promotions->save();
		}
		$post->save();
		Session::forget('promotion');
		Session::forget('tp');
		Session::forget('post');
		return redirect()->route('paymentcomplete');
		
	}

	public function paymentcomplete()
	{
		return view('promote.paymentcomplete');
	}

}