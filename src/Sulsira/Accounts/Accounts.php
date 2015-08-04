<?php namespace Sulsira\Accounts;
/**
* 
*/
use Illuminate\Http\Request;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Config;
use Intervention\Image\ImageManagerStatic as Image;
use Session, Redirect, Input;
use Sulsira\Accounts\Mortgage as mortgage;



class Accounts extends AbstractAccounts
{
    public static function rent(){

    }

    /**
     * @return Mortgage
     */
    public static function mortgage(){
        return new Motgage();
    }

    /**
     * @return Plot
     */
    public static function plotSale(){
       return new Lotsale();
//        return new mortgage();
    }

    public function bank(){
        return new mortgage();
    }

    public function allExpenses(){

    }

    public function allCharges(){

    }

    public function allSalary(){

    }

}#end of class