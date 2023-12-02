<?php

use Illuminate\Support\Facades\Storage;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;




function returnData(array $errors, int $code, $data = null, array $message = []): array
{
    return [
        'errors' => $errors,
        'code' => $code,
        'data' => $data,
        'messages' => $message,
    ];
}

