<?php

namespace App\Extensions\Http;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class RequestExtensions extends Request
{

    /**
     * Get a object containing the provided keys with values from the input data.
     *
     * @param  array|mixed  $keys
     * @return mixed
     */
    public function object($keys = null)
    {
        $results = $this->only($keys);
        return Arr::toObject($results);
    }
}
