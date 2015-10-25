<?php
/**
 * Created by PhpStorm.
 * User: mamadou
 * Date: 4/22/2015
 * Time: 3:46 PM
 */

namespace Sulsira\Accounts;


class Rent extends AbstractAccounts{

    use Traits\CalculatorTrait;
    protected  $absClass;

    function __construct($args = null){


    }

    public function firstPayment()
    {
        return new FirstRentPayment();
    }

    public function monthly(){
        return new Morthly();;
    }
    /*
     *
     * return array
     *
     * returns t
     *
     */
    public function payment(array $pay){
        $results = array();
        $fee = true;
        extract($pay);

        if(!empty($pay)){
            // check to see for the zero
            if($payment == 0 or $month_fee == 0){
                $fee = false;
            }else{

                //
                $owing_months = $this->subtract_dates([$previouly_assigned_payment_date,$current_payment_date]);
                // add the balance withe the
                $payment_with_balance = $balance + $payment;

                $money_without_owing_months = ($payment_with_balance) - ($owing_months * $month_fee);

                $fee =  $money_without_owing_months;

                $paid_months = $money_without_owing_months / $month_fee;

                $new_balance = $money_without_owing_months % $month_fee;

                $total_payable_monthly_fee = $fee - $new_balance;

                $number_of_months_paid = ($money_without_owing_months - $new_balance) / $month_fee;


                $next_pay_date = $this->add_dates($previouly_assigned_payment_date,$number_of_months_paid);

                $owing_months = $this->getOwingMonths([$current_payment_date,$next_pay_date]);
                return   compact('owing_months','payment_with_balance','money_without_owing_months','paid_months','new_balance','number_of_months_paid','next_pay_date');
            }


        }

        return $fee;
    }

    protected function getOwingMonths(array $dates){

        $date1 = ((boolean)$dates[0])? new \DateTime( $this->unix_flip($dates[0], true) ) : new \DateTime( '0-0-0000' );
        $date2 = ((boolean)$dates[1])?  new \DateTime( $this->unix_flip($dates[1], true) ) : new \DateTime( '0-0-0000' );
        if($date1 >  $date2){

           return $this->subtract_dates([$dates[0],$dates[1]]);

        }else{
            return 0;
        }
    }

    protected  function getPreviousPayments(){
        // check to see if there is any previous payment

        // if there is then return the last payment or else return zero

    }
    protected  function getBalancePaid(){

        // check to see if there a balance in the database if yes
            //return the balance

        // else return zero
    }

    protected  function getOwingBalance(){
        // get the owing balance from the database

        // if not return zero
    }
    protected  function getOwedBalance(){
        //get the balance that is owed to the customer

        //return zero if not
    }
    protected  function getRecentPayments(){
        // get the recent payment from the user input

        // check if its not zero if its zero

        // publish a stop calculation flag
    }
    protected  function getLastPaidDate(){
        //check and see if there is a last paid date

        // if not create one using the recent payment for date

        // else just return from the database
    }
    protected  function getMonthlyPayments(){
            // get the house monthly payment
    }
    protected  function getNextPayDate(){
            // check the flag if its true then proceed if not stop

        // check if last paid data is true and not empty if not

        // add the months payable to the last paid date
    }
    protected  function getNumMonthsPayable(){
        // new money - new balance / monthly payment
    }

    protected  function getNewBalance(){
        // (old balance + get recent payment - old owed) % monthly fee
    }

    protected  function getNewOwing(){

    }
    protected  function getNewOwed(){

    }
    protected function getPaymentForDate(){
        // return the date user entered as the date to considering the tenant payment
    }
    protected function newMoney(){
        //old balance + recent payment - owing
    }
} 