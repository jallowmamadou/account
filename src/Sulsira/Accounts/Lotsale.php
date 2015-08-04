<?php
/**
 * Created by mamadou.
 * User: mamadou
 * Date: 7/20/2015
 * Time: 10:37 PM
 */

namespace Sulsira\Accounts;


class Lotsale extends Plot{
// sub class of plot

    public function getPayment($args = []){ #yes // different implementation
        return [
            'total_paid' => $this->getAmountPaid(),
            'dateOfPayment' => $this->unix_flip($this->dataset['paid_date'],true, '-')
        ];
    }
} 