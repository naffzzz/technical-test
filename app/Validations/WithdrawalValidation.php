<?php 

namespace App\Validations;

class WithdrawalValidation
{
    public const withdrawalRule = [
        'bank_account_id'      => 'required',
        'value'      => 'required'
    ];
}

?>