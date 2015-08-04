<?php
/**
 * Created by mamadou.
 * User: mamadou
 * Date: 7/17/2015
 * Time: 9:53 PM
 */

namespace Sulsira\Accounts;
use Sulsira\Accounts\Mortgage as mot;

class Account extends AbstractAccounts{
use Traits\Takes;


    public function __construct(){
//    $this->mortgage = $mortgage;
//        var_dump($mortgage);
    }

    public static function rent(){

//        var_dump("you are on rent");
        return new mot();
    }


    /**
     * @return Mortgage
     */
    public function mortgage(){
        return $this->mortgage;
    }
    public function plotSale(){

    }
    public function bank(){

    }

    public function allExpenses(){

    }

    public function allCharges(){

    }

    public function allSalary(){

    }
//    public function pay(){
//        return $this;
//    }
//    public static function __callStatic($name, $args){
//
//        $args = empty($args) ? [] : $args[0];
//        $instance = static::$instance;
//        if ( ! $instance) $instance = static::$instance = new static;
//        return $instance->$$name($args);
//    }
} 