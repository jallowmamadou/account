<?php
/**
 * Created by PhpStorm.
 * User: mamadou
 * Date: 4/22/2015
 * Time: 3:54 PM
 */

namespace Sulsira\Accounts\Traits;


trait Payments {

    private $rate = 3;
    public function rent($amount){
        return $amount * $this->rate;
    }
} 