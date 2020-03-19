<?php

namespace App\Http\Controllers\Admin;
use App\Models\Bpackage;
use App\Models\Duration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Larapen\Admin\app\Http\Controllers\PanelController;

class BpackageController extends PanelController
{
	public function index()
	{
		$packages=BPackage::get();
		return view('admin::Package.packageindex',compact('packages'));
	}

	public function create()
	{
		return view('admin::Package.packagecreate');
	}

	public function store(Request $request)
	{
       
		$request->validate([
            'name' => 'required',
            'picture' => 'required'
        ]);
        $data = $request->picture;
	    $png_url = time().".png";
	    $path = public_path().'/uploads/' . $png_url;
    	\Image::make(file_get_contents($data))->save($path);     


        Bpackage::create([
        	'name' => $request['name'],
        	'picture'=>$png_url,
        	'description' => $request['description'],
        ]);
         flash('Created successfully')->important()->success();
       return redirect()->route('package.index');
	}
	public function edit($id,$childId = NULL)
	{
		$package=Bpackage::find($id);
		$durations=Duration::where('package_name',$package->name)->get();
		return view('admin::Package.editpackage',compact('package','durations'));
	}
	public function update($id,Request $request)
	{
		// return $request;
		$request->validate([
            'name' => 'required'
        ]);
		$package=Bpackage::find($id);
		$packagename=$package->name;
		
		if( $request->has('name'))
		{
			$package->name=$request->name;
		}
		if( $request->has('description'))
		{
			$package->description=$request['description'];
		}
		if( $request->has('active'))
		{
			$package->active=$request['active'];
		}

		if( $request->get('picture'))
		{
			 $data = $request->picture;
		    $png_url = time().".png";
		    $path = public_path().'/uploads/' . $png_url;
	    	\Image::make(file_get_contents($data))->save($path);
	    	$package->picture=$png_url;
		}
		
		if( $request->has('day'))
		{
			 foreach ($request->day as $key1=>$val) 
			 {
			 	foreach ($request->durationid as $key2=>$id)
		 	 {
			 	$duration=Duration::where('id',$id)->first();
			 	$duration->duration=$val;
		 		if ($key1==$key2) {
		 	 		break;
		 	 	}
		 	}
		 	$duration->save();
		 	
		 	}

		}
		if( $request->has('price'))
		{
			 foreach ($request->price as $key1=>$val) 
			 {
			 	foreach ($request->durationid as $key2=>$id)
		 	 {
			 	$duration=Duration::where('id',$id)->first();
			 	$duration->price=$val;
		 		if ($key1==$key2) {
		 	 		break;
		 	 	}
		 	}
		 	$duration->save();
		 	
		 	}

		}
		$package->save();
		return redirect()->route('package.index');

	}
	public function destroy($id,$childId = NULL)
	{
		$package=Bpackage::find($id)->delete();
		 flash('Deleted successfully')->important()->success();
        return redirect()->back();
	}
	public function addtimelimit()
	{
		return view('admin::Package.addtime');
	}

	public function storetimelimit( Request $request)
	{
		$pack=Bpackage::where('name',$request->name)->first();
		$packageid=$pack->id;
		 foreach ($request->day as $key=>$day) {
		 		$duration=new Duration();
			 	$duration->package_id=$packageid;
			 	$duration->package_name=$request->name;
			 	$duration->duration=$day;
		 	 foreach ($request->price as $key2=> $price)
		 	 {
		 	 	$duration->price=$price;
		 	 	if ($key==$key2) {
		 	 		break;
		 	 	}
		 	 }
		 	 $duration->save();
		 	 
		 }
		 return redirect()->back();
	}
}