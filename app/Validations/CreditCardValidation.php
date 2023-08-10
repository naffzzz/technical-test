<?php 

namespace App\Validations;

class CreditCardValidation
{
    public const creditCardRule = [
        'card_number'      => 'required',
        'cvv'      => 'required',
        'month'      => 'required',
        'year'      => 'required'
    ];
}

?>