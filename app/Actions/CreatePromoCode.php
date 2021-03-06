<?php


namespace App\Actions;

use App\StorePromocode;
use Illuminate\Support\Str;
/**
 * Response represents an HTTP response.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class CreatePromoCode
{

    protected $StorePromocode;
    public function __construct(StorePromocode $StorePromocode)
    {
        $this->StorePromocode = $StorePromocode;
    }

    public function execute(array $data){
        if(!empty($data['promocode_id'])){
            $StorePromocode = StorePromocode::find($data['promocode_id']);
            $StorePromocode->fill($data);
            $StorePromocode->save();
        }else{
            $data['unique_number'] = Str::random(30);
            $StorePromocode = $this->StorePromocode->create($data);
        }
        return $StorePromocode;
    }
}
