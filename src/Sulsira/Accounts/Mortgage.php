<?php
/**
 * Created by PhpStorm.
 * User: mamadou
 * Date: 6/14/2015
 * Time: 3:44 AM
 */

namespace Sulsira\Accounts;


class Mortgage extends AbstractAccounts{
    use Traits\CalculatorTrait;
    protected  $absClass;
    private  static $input;
    protected  static $instance;
    public $dataset;
    protected $process;
    function __construct($args = null){
    }

    // get the total ammount paid
    //monthly payment calculator
    public function monthlyPaymentCalculator(){

        // plot price - downpayment / period in months
        if($this->dataset['payment_duration_in_months'] == 0){

            $this->process = false;

            return;
        }
        return ($this->dataset['plot_price'] - $this->dataset['down_payment']) / $this->dataset['payment_duration_in_months'];

    }

    public function chargableAmount()
    {
        return ( ( $this->dataset['amount_paid'] + $this->dataset['balance'] ) - $this->dataset['arrears'] );
    }
    public function payableBalance()
    {
        return $this->chargableAmount() %  $this->calculatedMonthlyPaymentFee();
    }
    public function amountPayble()
    {
       return $this->chargableAmount() - $this->payableBalance();
        // this is adding the total amount he paid
        // pluss his previous over payment
        //minus his owing
//        return
    }
    public function getAmountPaid(){

        return $this->dataset['amount_paid'] ;
    }

    // number of months payable
    public function getMonthsPayable(){
//        dd( $this->amountPayble());
        // amount paid / calculated_monthly_fee

       // ( amount paid - (amount paid % calculated monthly fee)) / calculated monthly fee;
       return ceil($this->amountPayble() / $this->calculatedMonthlyPaymentFee());
    }

    // next pay date
    public function getNextPayDate(){

        // if the last payment date was not then take the payment
        // the last paid next paid date + ( number of months paid )
       $next_payment_date = (! $this->dataset['next_payment_date'] )? $this->dataset['commencement_date'] : $this->dataset['next_payment_date'];



       return $this->add_dates($next_payment_date, $this->getMonthsPayable());

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

        // plot price - downpayment * payment_duration
        if(! $this->dataset['calculated_monthly_fee']){

           return round( ($this->dataset['plot_price']) / $this->dataset['payment_duration_in_months'], 2 ,PHP_ROUND_HALF_UP);
        }

        return $this->dataset['calculated_monthly_fee'];

    }
    public static function pay(array $input){

        $instance = static::$instance;

        if ( ! $instance ) $instance = static::$instance = new static;

        $instance->dataset = $input;

        return  $instance;

    }

    public function getPayment($args = []){

        return [
            'next_payment_date'  =>  $this->getNextPayDate(),
            'calculated_monthly_fee' => $this->calculatedMonthlyPaymentFee(),
            'number_of_months_paid' => $this->numberOfMonthsPaid(),
            'unhindered_closing_payment_date' => null,
            'arrears' => $this->getBalanceOwing(),
            'balance' => $this->getBalanceOwed(),
            'total_paid' => $this->getTotalAmountPaid(),
            "total_due_paid" => $this->total_due_paid()

        ];
    }

    /**
     * calculates the amount of money paid for the due payment
     *
     * @return float
     */
    public function total_due_paid()
    {
        return $this->dataset['total_due_paid'] +  $this-> amountPayble();
    }
    protected function getTotalAmountPaid(){
        // ( balance + down_payment + total_paid + amount_paid ) - arrears
        if((int)$this->dataset['total_paid']){

            return ($this->chargableAmount() +  $this->dataset['total_paid'] );
        }
       return ($this->dataset['balance'] +  $this->dataset['down_payment'] + $this->dataset['total_paid'] + $this->dataset['amount_paid']) - $this->dataset['arrears'];
    }

    protected function getDuePaymentAmount(){
     return $this->dataset['plot_price'] -  $this->getTotalAmountPaid();
    }
    // we want to know

    // when is the next pay dates
    // how many months are left to finish

    // a flag showing finish or not
    //calculate the owining

    // calculate the owned

    //recalculation and knowing of new closing date
    /**
     * unhinded closing date is wrong
     *
     *
     */
} 