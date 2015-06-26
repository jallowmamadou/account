<?php namespace Sulsira\Accounts;
/**
* 
*/
use Illuminate\Http\Request;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Config;
use Intervention\Image\ImageManagerStatic as Image;
use Session, Redirect, Input;


defined('DS') ? NULL :define('DS',DIRECTORY_SEPARATOR);
class Accounts extends AbstractAccounts
{
    use Traits\CalculatorTrait;


    public function standart_date($date){

    }

    public function is_dates_equal($date){

    }
}#end of class