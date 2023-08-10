<?php 

namespace App\Validations;

class BankAccountValidation
{
    public const bankAccountRule = [
        'full_name'      => 'required',
        'account_number'      => 'required',
        'bank_id'      => 'required'
    ];
}

?>