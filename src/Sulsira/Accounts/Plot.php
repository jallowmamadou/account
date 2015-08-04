<?php
/**
 * Created by mamadou.
 * User: mamadou
 * Date: 7/20/2015
 * Time: 3:12 PM
 */

namespace Sulsira\Accounts;


abstract class Plot {
    use Traits\CalculatorTrait;
    protected  $absClass;
    private   $input;
    public $dataset;
    protected $process;

    public function getAmountPaid(){ #yes
        return $this->dataset['amount_paid'];
    }

    public  function pay(array $input){
        $this->dataset = $input;

//        dd($input);
        return  $this;

    }

    public function whenthereisnodownpayment(){

    }

    public function whenthereisnoduepayment(){

    }
    public function whenthereisnoperiodinmonths(){

    }

    public function whenthereisnocommencementdate($generateanewcommencementdate){

    }
    public function whenthereisnodateofpayment(){

    }
} 