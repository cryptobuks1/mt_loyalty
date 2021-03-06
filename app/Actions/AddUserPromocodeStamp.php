<?php


namespace App\Actions;

use App\UserStampCollect,
    App\UserPointCollect,
    App\GeneratePromocodeToken,
    App\UserCouponCollect;

use Illuminate\Support\Facades\Auth;

/**
 * Response represents an HTTP response.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class AddUserPromocodeStamp
{

    protected $UserStampCollect;

    public function __construct(UserStampCollect $UserStampCollect)
    {
        $this->UserStampCollect = $UserStampCollect;
    }

    public function execute(array $data){
        $unique_token = $data['unique_token'];
        $user = Auth::user();

        $GeneratePromocodeToken = GeneratePromocodeToken::where('unique_token',$unique_token)
                                    ->with( [ "promocode_detail" ])->first();
        if($GeneratePromocodeToken->type == "point"){
            $UserPointCollectData = [
                "promocode_id" => $GeneratePromocodeToken->promocode_id,
                "store_id" =>  $GeneratePromocodeToken->promocode_detail->store_id,
                "user_id" => $user->id,
                "count" => $GeneratePromocodeToken->count,
                "is_redeem" => 0
            ];
            $UserStampCollect = UserPointCollect::create($UserPointCollectData);
        }elseif($GeneratePromocodeToken->type == "stamp"){
            $UserStampCollectData = [
                "promocode_id" => $GeneratePromocodeToken->promocode_id,
                "store_id" =>  $GeneratePromocodeToken->promocode_detail->store_id,
                "user_id" => $user->id,
                "count" => $GeneratePromocodeToken->count,
            ];
            $UserStampCollect = $this->UserStampCollect->create($UserStampCollectData);
        }else{
            $UserStampCollectData = [
                "store_id" => $GeneratePromocodeToken->store_id,
                "coupon_id" =>  $GeneratePromocodeToken->coupon_id,
                "user_id" => $user->id,
                "count" => $GeneratePromocodeToken->coupon_detail->amount,
                "is_reward" => 0,
            ];
            $UserStampCollect = UserCouponCollect::create($UserStampCollectData);
        }

        $UserStampCollect->type = $GeneratePromocodeToken->type;
        $GeneratePromocodeToken->delete();
        return $UserStampCollect;
    }

}
