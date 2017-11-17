<?php

namespace GroceryCrud\Core\Validate;


interface ValidateInterface
{
    public function set_data($data);

    public function validate();
}