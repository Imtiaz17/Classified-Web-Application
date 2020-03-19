<?php
/**
 * LaraClassified - Geo Classified Ads CMS
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: http://www.bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

namespace App\Http\Controllers\Search;

use App\Helpers\Search;
use App\Models\User;
use App\Models\Store;
use Torann\LaravelMetaTags\Facades\MetaTag;
use Carbon\Carbon;
class UserController extends BaseController
{
	public $isUserSearch = true;
	public $sUser;

    /**
     * @param $countryCode
     * @param null $userId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($userId)
    {
         $today=Carbon::now()->format('l');
         $storedetails=Store::where('user_id',$userId)->first();
         $data['days'] = ['Saturday', "Sunday", "Monday", 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
         $data['schedule']=$storedetails->schedule;
         return view('store.store',compact('storedetails','today'),$data);
        //    $oh = $storedetails->map(function($item,$key) {
        //    return $item->opening_hours;
        //     });
        // $arry=explode(",",$oh);
        // $array = [];
        // foreach ($arry as $string) {
        //    $data = explode(',', $string);
        //    if(isset($data[0]) && !empty($data[0])){
        //      $array[$data[0]] = $data[1];
        //    }
        // }
        // return $array;



        // $op = $storedetails->map(function($item,$key) {
        //    return $item->open_days;
        //     });
        // $arry2=explode(",",$op);

        // $result = array();
        // foreach($arry2 as $key=>$val){ // Loop though one array
        //     $val2 = $arry[$key]; // Get the values from the other array
        //     $result[$key] = $val + $val2; // combine 'em
        // }
        // return $result;


        return view('store.store',compact('storedetails','today'));
        // Check multi-countries site parameters
        if (!config('larapen.core.multiCountriesWebsite')) {
            $userId = $countryCode;
        }

        view()->share('isUserSearch', $this->isUserSearch);

        // Get User
        $this->sUser = User::findOrFail($userId);

        // Redirect to User's profile If username exists
        if (!empty($this->sUser->username)) {
            $url = lurl(trans('routes.v-search-username', ['countryCode' => $countryCode, 'username' => $this->sUser->username]));
            headerLocation($url);
        }

        return $this->searchByUserId($this->sUser->id);
    }

    /**
     * @param $countryCode
     * @param null $username
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile($countryCode, $username = null)
    {
        // Check multi-countries site parameters
        if (!config('larapen.core.multiCountriesWebsite')) {
            $username = $countryCode;
        }

        view()->share('isUserSearch', $this->isUserSearch);

        // Get User
        $this->sUser = User::where('username', $username)->firstOrFail();

        return $this->searchByUserId($this->sUser->id);
    }

    /**
     * @param $userId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function searchByUserId($userId)
    {
        // Search
        $search = new Search();
        $data = $search->setUser($userId)->setRequestFilters()->fetch();

        // Get Titles
        $bcTab = $this->getBreadcrumb();
        $htmlTitle = $this->getHtmlTitle();
        view()->share('bcTab', $bcTab);
        view()->share('htmlTitle', $htmlTitle);

        // Meta Tags
        $title = $this->getTitle();
        MetaTag::set('title', $title);
        MetaTag::set('description', $title);

        return view('search.serp', $data);
    }
}
