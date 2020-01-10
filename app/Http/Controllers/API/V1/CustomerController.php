<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Constants\ResponseMessage;

use App\Http\Resources\StoreResource;

use App\Store,
    App\User;

class CustomerController extends Controller
{
    /*
		customer store wallet(Favorite Store) listing
    */
    public function listWallet(User $user){
       return response()->success(ResponseMessage::COMMON_MESSAGE,replace_null_with_empty_string($user->wallets));
    }

    /*
        Add Store in customer wallet (Favorite Store)

    */
    public function addWallet(User $user, Request $request){
        if(! $user->wallets->contains($request->store_id)){
            $user->wallets()->attach($request->store_id);
        }
        return response()->success(ResponseMessage::COMMON_MESSAGE,replace_null_with_empty_string($user));
    }

    /*
		Remove Store in Favorite list
    */
    public function removeWallet(User $user, Request $request){
        $user->wallets()->detach($request->store_id);
        return response()->success(ResponseMessage::COMMON_MESSAGE,replace_null_with_empty_string($user));
    }

    /*
		Store Detail Api
    */
     public function storeDetail(Store $store){
        return response()->success(ResponseMessage::COMMON_MESSAGE,replace_null_with_empty_string(StoreResource::make($store)));
     }
}
