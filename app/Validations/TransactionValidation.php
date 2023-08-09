<?php 

namespace App\Validations;

class TransactionValidation
{
    public const transactionRule = [
        'event_id'      => 'required|numeric',
    ];
}

?>