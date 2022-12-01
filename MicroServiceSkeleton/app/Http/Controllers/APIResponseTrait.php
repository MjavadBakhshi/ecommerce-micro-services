<?php

namespace App\Http\Controllers;

trait APIResponseTrait
{

    function success()
    {
        return ['ok' => true];
    }

    function failed()
    {
        return ['ok' => false];
    }

    function data($data)
    {
        # Maybe later do some preprocessing or adding some headers.
        return  ['ok' => true, 'data' => $data];
    }
}
