<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;
use Laravel\Lumen\Routing\Controller as BaseController;

#[OA\Info(title: "Lemen", contact: new OA\Contact(name: 'Gordon',email: 'dengxuan@mail.com'), description: "Lemen", version: "1.0", license: new OA\License(name: 'MIT',url: 'http://mit.com'))]
abstract class Controller extends BaseController
{
    //
}
