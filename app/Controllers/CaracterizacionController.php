<?php
namespace  App\Controllers;
use App\Models\CaracterizacionEntry;

use App\Response\CustomResponse;
use App\Validation\Validator;
use Respect\Validation\Exceptions\Exception;
use Respect\Validation\Validator as v;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class CaracterizacionController {

    protected $customResponse;

    protected $caracterizacionEntry;

    protected $validator;

    public function __construct()
    {
    $this->customResponse = new CustomResponse();
    $this->caracterizacionEntry = new CaracterizacionEntry();
    $this->validator = new Validator();

    }

}