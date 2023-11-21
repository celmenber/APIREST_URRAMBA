<?php
namespace  App\Controllers;
use App\Models\ViviendaEntry;
use App\Models\EnceresEntry;
use App\Models\ImgInmuebleEntry;

use App\Response\CustomResponse;
use App\Validation\Validator;
use Respect\Validation\Exceptions\Exception;
use Respect\Validation\Validator as v;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ViviendaController {

    protected $customResponse;

    protected $viviendaEntry;

    protected $enceresEntry;

    protected $imgInmuebleEntry;

    protected $validator;

    public function __construct()
    {
    $this->customResponse = new CustomResponse();
    $this->viviendaEntry = new ViviendaEntry();
    $this->enceresEntry = new EnceresEntry();
    $this->imgInmuebleEntry = new ImgInmuebleEntry();
    $this->validator = new Validator();

    }

}