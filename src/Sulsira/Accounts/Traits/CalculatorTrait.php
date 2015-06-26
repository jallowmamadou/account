<?php
/**
 * Created by PhpStorm.
 * User: mamadou
 * Date: 6/3/2015
 * Time: 4:14 PM
 */

namespace Sulsira\Accounts\Traits;


trait CalculatorTrait {

    /*
     * void uses a given string as a formula and calculates
     * return number
     *
     */
    public function formular($equation){

    }
    public function add(array $array){

    }

    public function substract(array $array){

    }

    public function divide(array $array){

    }


    //
    public function round_down($number){

    }

    public function round_up($number){

    }

    public function flat_number($number, $squence){

    }
    public function remainder(array $array, $moder){

    }

    public function subtract_dates(array $dates, $date_letter = 'm'){
        $first = strtotime($dates[0]);
        $second = strtotime($dates[1]);

        $one = strftime('%F',$first);
        $two = strftime('%F',$second);
        $datetime1 = new \DateTime($one);
        $datetime2 = new \DateTime($two);
        $interval = $datetime2->diff($datetime1);

        $difference =  $interval->format("%$date_letter");

        return $difference;
    }

    public function add_dates($date, $month){

       if(! $date ) return 0;
        $month = (int) $month;
        $date = new \DateTime($date);

        $interval = new \DateInterval("P$month".'M');

        $date->add($interval);

        $next_pay_date =  $date->format('Y-m-d');

        return $next_pay_date ;
    }
} 