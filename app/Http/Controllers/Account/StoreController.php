<?php

namespace App\Http\Controllers\Account;
use App\Models\Store;
use App\Models\StoreSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Image;
class StoreController extends AccountBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['usershop'] = Store::where('user_id', Auth::user()->id)->get();
        $data['days'] = ['Saturday', "Sunday", "Monday", 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $data['member'] = auth()->user()->id;
        return view('account.myshop', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
         $request->validate([
            'name'=>'required',
            'address'=>'required',
            'phone'=>'required',
            'storelogo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',  
            'storecp' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024'     
    ]);
        $image = $request->file('storelogo');
        $logo_name = time().'.'.request()->storelogo->getClientOriginalExtension();
        $destinationPath = public_path('/storeimage');
        $resize_image = Image::make($image->getRealPath());
        $resize_image->resize(200,150, function($constraint){
          $constraint->aspectRatio();
         })->save($destinationPath . '/' . $logo_name);

        $cpimage = $request->file('storecp');
        $cp_name = time().'.'.request()->storecp->getClientOriginalExtension();
        $cpdestinationPath = public_path('/storeimage');
        $resize_cpimage = Image::make($cpimage->getRealPath());
        $resize_cpimage->resize(979,362, function($constraint){
          $constraint->aspectRatio();
         })->save($cpdestinationPath . '/' . $cp_name);
        //  $day_time="";
        //  $day_time.=$value.':'.$request->opentime[$value].'-'.$request->closetime[$value] .',';
         
      
        $shop = new Store();
        $shop->store_name = $request->name;
        $shop->store_details = $request->details;
        $shop->address = $request->address;
        $shop->phone = $request->phone;
        $shop->email = $request->email;
        $shop->store_logo = $logo_name;
        $shop->store_cphoto = $cp_name;
        // $shop->open_days = implode($request->days, ',');
        // $shop->opening_hours = implode($request->opentime, ',');
        // $shop->closing_hours = implode($request->closetime, ',');
        // $shop->day_time = $day_time;
        $shop->user_id = auth()->user()->id;
        $shop->store_id=substr(md5(uniqid(rand(1,9))), 0, 4);
        $shop->save();
        foreach ($request->days as $value) {
            $ss=new StoreSchedule();
            $ss->store_id=$shop->id;
            $ss->open_days=$value;
            $ss->opening_hours=$request->opentime[$value];
            $ss->closing_hours=$request->closetime[$value];
            $ss->save();   
        }
        flash("Your store has been added successfully.")->success();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
 
        $shop = Store::find($request->store_id);
        if ($request->has('name')) {
            $shop->store_name = $request->name;
        }
        if ($request->has('details')) {
            $shop->store_details = $request->details;
        }
        if ($request->has('address')) {
            $shop->address = $request->address;
        }
        if ($request->has('email')) {
            $shop->email = $request->email;
        }
        if ($request->has('phone')) {
            $shop->phone = $request->phone;
        }
         if( $request->hasFile('storelogo'))
         {
              $prevlogo = public_path('/storeimage/').$shop->store_logo; 
                if (file_exists($prevlogo)) { 
                    @unlink($prevlogo);
                }
            $image = $request->file('storelogo');
            $logo_name = time().'.'.request()->storelogo->getClientOriginalExtension();
            $destinationPath = public_path('/storeimage');
            $resize_image = Image::make($image->getRealPath());
            $resize_image->resize(200,150, function($constraint){
              $constraint->aspectRatio();
             })->save($destinationPath . '/' . $logo_name);
              $shop->store_logo = $logo_name;

         }
        if( $request->hasFile('storecp'))
        {
             $prevcp = public_path('/storeimage/').$shop->store_cphoto; 
            if (file_exists($prevcp)) { 
                @unlink($prevcp);
            } 
            $cpimage = $request->file('storecp');
            $cp_name = time().'.'.request()->storecp->getClientOriginalExtension();
            $cpdestinationPath = public_path('/storeimage');
            $resize_cpimage = Image::make($cpimage->getRealPath());
            $resize_cpimage->resize(979,362, function($constraint){
              $constraint->aspectRatio();
             })->save($cpdestinationPath . '/' . $cp_name);
            $shop->store_cphoto = $cp_name;
        }
        foreach ($request->days as $value) {
            $old=StoreSchedule::where('store_id',$request->store_id)->where('open_days',$value)->first();
            if($old)
            {
                $old->update(
                [
                    'store_id'=>$shop->id,
                    'open_days'=>$value,
                    'opening_hours'=>$request->opentime[$value],
                    'closing_hours'=>$request->closetime[$value], 
                ]
            );}
            else
            {
                $ss=new StoreSchedule();
                $ss->store_id=$shop->id;
                $ss->open_days=$value;
                $ss->opening_hours=$request->opentime[$value];
                $ss->closing_hours=$request->closetime[$value];
                $ss->save();
           
            }
               
        }
        // StoreSchedule::where('store_id',$request->store_id)->updateOrCreate(
        //         [
        //             'store_id'=>$shop->id,
        //             'open_days'=>$value,
        //             'opening_hours'=>$request->opentime[$value],
        //             'closing_hours'=>$request->closetime[$value],
        //         ]);
        // }
        $shop->save();
        flash("Your store details has been updated successfully.")->success();
        return redirect()->back();
    }

    public function getMembership()
    {
        $user = auth()->user();
        return view('account.bemember', $user);
    }
    public function beMember(Request $request,$id)
    {
         $data= User::find($request->id);
         if ($request->has('member')) {
            $data->member_request=1;
         }
         $data->save();
        return redirect()->back();
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy(Store $store)
    {
        //
    }
}
