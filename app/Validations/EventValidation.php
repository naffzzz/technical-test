<?php 

namespace App\Validations;

class EventValidation
{
    public const eventRule = [
        'name'      => 'required',
        'price'     => 'required|numeric',
        'event_date'  => 'required',
        'is_open'  => 'required|boolean',
        'status'  => 'required',
        'open_order_date'  => 'required',
    ];
}

?>