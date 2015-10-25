<?php
/**
 * Created by mamadou.
 * User: mamadou
 * Date: 10/24/2015
 * Time: 2:25 PM
 */

namespace Sulsira\Accounts;


class FirstRentPayment extends Rent {

    private $data_template;
    private $input_template;

    public function init(array $data)
    {
        $this->input_template = $data;


        if(!empty($data)){
            extract($data);

            if( ( !isset($amount_paid) or empty($amount_paid) ) and (!isset($security_deposit) or empty($security_deposit)) ){
                return null;
            }


            if( (!isset($move_in_date) or (boolean)$move_in_date == false) or (!isset($date_of_payment) or (boolean)$date_of_payment == false) ){
                return $data_template = [
                    'response' => 'failed',
                    'data' => $data
                ];
            }

            if(!isset($house_price_per_month) or !(int)$house_price_per_month){
                if((int)$number_of_months_paid){

                    $this->calculate_house_price_with_months($number_of_months_paid);

                }else{

                    return $data_template = [
                        'response' => 'failed',
                        'data' => $data
                    ];
                }

            }

            $this->calculate();
        }

        return $this->details();
    }

    public function calculate()
    {
        //get total months paid for
         $number_of_months_paid = $this->getNumberOfMonthsPaid();

        // get the get the balance
         $over_payment = $this->getOverPay();

        // get the total accumulative payment
            $cummulative_total = $this->accumulativeTotal();

        // get the next payment date
            $next_pay_date = $this->getNextPaidDate();

        // get the first payment date
        $firstdate = (isset($this->input_template['move_in_date']))? $this->input_template['move_in_date'] : $this->input_template['date_of_payment'];
        // get the monthly fee

        $monthly_fee = $this->getMonthlyFeePayment();

        $rent_paid_without_overpay = $this->input_template['amount_paid'] - $this->getOverPay();

        $this->data_template = compact('number_of_months_paid', 'over_payment', 'cummulative_total', 'next_pay_date', 'firstdate', 'monthly_fee', 'rent_paid_without_overpay');
    }

    public function accumulativeTotal(){
        return $this->input_template['amount_paid'] + $this->getSecurityDeposit();
    }
    public function getSecurityDeposit()
    {
        return $this->input_template['security_deposit'];
    }

    public function getOverPay()
    {

       if(!$this->getMonthlyFeePayment()) return 0;
       return $this->input_template['amount_paid'] % $this->getMonthlyFeePayment();

    }


    public function getNumberOfMonthsPaid()
    {
        if($this->getMonthlyFeePayment() == null ) return 0;

        return ( $this->input_template['amount_paid'] - $this->getOverPay() ) / $this->getMonthlyFeePayment();

    }


    public function getNextPaidDate()
    {
        // next paid date is
        $date = (isset($this->input_template['move_in_date']))? $this->input_template['move_in_date'] : $this->input_template['date_of_payment'];

        return $this->add_dates($this->unix_flip($date, true),$this->getNumberOfMonthsPaid());
    }

    public function pay($data)
    {
       return $this->init($data);
    }

    private function calculate_house_price_with_months($number){

        if(!(int) $number ) return 0;
        $this->input_template['house_price_per_month'] = $this->input_template['amount_paid'] / $number;

    }

    private function getMonthlyFeePayment(){
        // total paid divided by house price
       if( !$this->input_template['house_price_per_month'] ) return 0;
       return $this->input_template['house_price_per_month'];

    }

    public function details(){
        return $this->data_template;
    }
}

//        $this->input_template = [
//            'amount_paid' => 450,
//            'date_of_payment' => '10-24-2015' ,
//            'house_price_per_month' => 200,
//            'move_in_date' => '10-24-2015',
//            'security_deposit' => 600 ,
//            'number_of_months_paid' => 2
//        ];