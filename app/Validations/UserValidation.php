<?php 

namespace App\Validations;

class UserValidation
{
    public const userRule = [
        'name'      => 'required',
        'email'     => 'required|email',
        'password'  => 'required|min:8|confirmed'
    ];

    public const loginRule = [
        'email'     => 'required|email',
        'password'  => 'required|min:8'
    ];
}

?>