<?php
/**
 * Created by mamadou.
 * User: mamadou
 * Date: 7/20/2015
 * Time: 10:38 PM
 */

namespace Sulsira\Accounts;


class Motgage  extends Plot{
private  $default_payment_duration_in_months = 36;
// sub class of plot
    public function monthlyPaymentCalculator(){

        // plot price - downpayment / period in months
        if($this->dataset['payment_duration_in_months'] == 0){

            $this->process = false;

            return;
        }
        return ($this->dataset['plot_price'] - $this->dataset['down_payment']) / $this->dataset['payment_duration_in_months'];

    }

    public function getAmountPaid(){ #yes
        return $this->dataset['amount_paid'];
    }
    public  function pay(array $input){
        $this->dataset = $input;

        return  $this;

    }
    // number of months payable
    public function getMonthsPayable(){
       if(! $this->getAmountPaid()){
           return 0;
       }
        // amount paid / calculated_monthly_fee

        // ( amount paid - (amount paid % calculated monthly fee)) / calculated monthly fee;
        return ( $this->getAmountPaid() - ( $this->getAmountPaid() % $this->calculatedMonthlyPaymentFee())) / $this->calculatedMonthlyPaymentFee();
    }

    // next pay date
    public function getNextPayDate(){
       if(! $this->getMonthsPayable()){
           return  $this->dataset['commencement_date'];
       }
        // the last paid next paid date + ( number of months paid )
        $next_payment_date = (! $this->dataset['next_payment_date'] )? $this->dataset['commencement_date'] : $this->dataset['next_payment_date'];

        return $this->add_dates($this->unix_flip( $next_payment_date), $this->getMonthsPayable());

    }

    /**
     *  the amount of money the business owes the customer {balance}
     * @params void
     * @return array
     */
    // get balance owed
    public function getBalanceOwed(){
        // amount paid % monthly fee + previous balance
        // if it was +
        $result = ( $this->dataset['amount_paid'] % $this->calculatedMonthlyPaymentFee() ) + $this->dataset['balance'];
        //# stop here
        if( $result < 0){

            $result = 0;
        }

        return $result;
    }

    /**
     *  the amount of money cusotmer owes the business {arrears}
     * @params void
     * @return array
     */
    // get the balance owing
    public function getBalanceOwing(){
        // amount paid % monthly fee + previous balance
        // if it was -

        $result = $this->getBalanceOwed() + $this->dataset['arrears'];
        //# stop here
        if( $result > 0){

            $result = 0;

        }

        return $result;

    }
    //commencement date
    public function getCommencementDate(){
        return $this->dataset['commencement_date'];
    }
    // priode of payment duration
    public function numberOfMonthsPaid(){
        //payment duration - months fully paid

        return  ((int)ceil(  $this->dataset['payment_duration_in_months'] - ($this->dataset['payment_duration_in_months'] - ($this->getMonthsPayable() + $this->dataset['number_of_months_paid'] )) ));
    }
    public function calculatedMonthlyPaymentFee(){

        // calculated monthly fee is
            // remaining balance / months payable



        // plot price - downpayment * payment_duration
        if(! $this->dataset['calculated_monthly_fee']){

            if(isset($this->dataset['payment_due']) and isset($this->dataset['payment_duration_in_months'])){

                if(!empty($this->dataset['payment_due']) and !empty($this->dataset['payment_duration_in_months'])){

                    return round( ($this->dataset['payment_due']) / $this->dataset['payment_duration_in_months'], 2 ,PHP_ROUND_HALF_UP);

                }
            }else{
                // get the default months
                return round( ($this->dataset['plot_price'] - $this->dataset['down_payment']) / $this->default_payment_duration_in_months, 2 ,PHP_ROUND_HALF_UP);
            }

        }

        return $this->dataset['calculated_monthly_fee'];

    }



    protected function getTotalAmountPaid($inclusive = false){
        if(! $inclusive ){
            return ($this->dataset['balance'] + $this->dataset['total_paid'] + $this->dataset['amount_paid']) - $this->dataset['arrears'];

        }
        // ( balance + down_payment + total_paid + amount_paid ) - arrears

        return ($this->dataset['balance'] +  $this->dataset['down_payment'] + $this->dataset['total_paid'] + $this->dataset['amount_paid']) - $this->dataset['arrears'];
    }

    protected function getDuePaymentAmount(){
        // if there is a due payment already then you dont need to calculate it
        // also plot price is not allways set
        // formula is return due payment when set if not then plot price - down payment

        if(isset($this->dataset['payment_due']) and !empty($this->dataset['payment_due'])){
            return $this->dataset['payment_due'];
        }
        if(isset($this->dataset['plot_price'])){

            return $this->dataset['plot_price'] -  $this->dataset['down_payment'];
        }

        return 0;

    }

    public function getPayment($args = []){ #yes // different implementation

        return [
            'next_payment_date'  =>  $this->getNextPayDate(),
            'calculated_monthly_fee' => $this->calculatedMonthlyPaymentFee(),
            'number_of_months_paid' => $this->numberOfMonthsPaid(),
            'unhindered_closing_payment_date' => $this->unhindered_closing_payment_date(),
            'arrears' => $this->getBalanceOwing(),
            'balance' => $this->getBalanceOwed(),
            'total_paid' => $this->getTotalAmountPaid(),
            "payment_due" => $this->getDuePaymentAmount(),
            "dateOfPayment"=> $this->dataset['paid_date'],
            'paymentCommencementDate'=>$this->dataset['commencement_date']

        ];
    }

    public function unhindered_closing_payment_date(){
        return $this->add_dates($this->unix_flip($this->getCommencementDate()),(int)$this->dataset['payment_duration_in_months'] );
    }
} 