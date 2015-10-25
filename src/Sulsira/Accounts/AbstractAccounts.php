<?php
/**
 * Created by PhpStorm.
 * User: mamadou
 * Date: 4/22/2015
 * Time: 3:31 PM
 */

namespace Sulsira\Accounts;


use Sulsira\Accounts\Traits\Payments;
defined('DS') ? NULL :define('DS',DIRECTORY_SEPARATOR);
abstract class AbstractAccounts {
    use Traits\CalculatorTrait;

} 