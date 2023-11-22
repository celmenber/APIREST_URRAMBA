<?php

namespace  App\Controllers;

use App\Models\ParametricasEntry;
use App\Models\MunicipioEntry;
use App\Models\CorregimientoEntry;
use App\Models\Veredas_barriosEntry;
use App\Models\EscolaridadEntry;
use App\Models\ParentescoEntry;
use App\Models\Orientacion_sexualEntry;
use App\Models\TenenciaEntry;
use App\Models\TipoinmuebleEntry;
use App\Models\LogoEntry;
use App\Models\Tipo_documentoEntry;

use App\Response\CustomResponse;
use App\Validation\Validator;
use Respect\Validation\Exceptions\Exception;
use Respect\Validation\Validator as v;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ParametricasController
{
    protected $departamentoEntry;
    protected $municipioEntry;
    protected $corregimientoEntry;
    protected $veredas_barriosEntry;
    protected $escolaridadEntry;
    protected $parentescoEntry;
    protected $orientacion_sexualEntry;
    protected $tenenciaEntry;
    protected $tipoinmuebleEntry;
    protected $tipodocumentoEntry;
    protected $logoEntry;
    protected $customResponse;
    protected $validator;

    public function __construct()
    {
        $this->departamentoEntry = new ParametricasEntry();
        $this->municipioEntry = new MunicipioEntry;
        $this->corregimientoEntry = new CorregimientoEntry;
        $this->veredas_barriosEntry = new Veredas_barriosEntry;
        $this->escolaridadEntry = new EscolaridadEntry;
        $this->parentescoEntry = new ParentescoEntry;
        $this->orientacion_sexualEntry = new Orientacion_sexualEntry;
        $this->tenenciaEntry = new TenenciaEntry;
        $this->tipoinmuebleEntry  = new TipoinmuebleEntry;
        $this->tipodocumentoEntry  = new Tipo_documentoEntry;
        $this->logoEntry = new LogoEntry;
        $this->customResponse = new CustomResponse();
        $this->validator = new Validator();
    }

    /* DESDE AQUI SE PROCESO EL CRUE DE LA TABLA PARAMETRICA DEPARTAMENTO */
    public function viewDepartamento(Response $response)
    {
        $DepartamentoEntry = $this->departamentoEntry->get();
        return $this->customResponse->is200Response($response,$DepartamentoEntry);
    }

    public function estadoDepartamento(Request $request,Response $response,$Id)
    {
       $data = json_decode($request->getBody(),true);
       $this->validator->validate($request,[
            "Estado" =>v::notEmpty(),
         ]); 

     if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       } 

        try{
            $departamentoEntry = ParametricasEntry::find($Id);
            $departamentoEntry->Estado =   $data['Estado'];
            $departamentoEntry->save();

            $responseMessage = array('msg' 
                            => "Se cambio estado correctamente",'id' 
                            => $departamentoEntry->id);

        return $this->customResponse->is200Response($response,$responseMessage);

        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }


    /* DESDE AQUI SE PROCESO EL CRUE DE LA TABLA PARAMETRICA MUNICIPIO */
    public function viewMunicipio(Response $response)
    {
        $MunicipioEntry = $this->municipioEntry->get();
        return $this->customResponse->is200Response($response,$MunicipioEntry);
    }

    public function estadoMunicipio(Request $request,Response $response,$Id)
    {
       $data = json_decode($request->getBody(),true);
       $this->validator->validate($request,[
            "Estado" =>v::notEmpty(),
         ]); 

     if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       } 

        try{
            $municipioEntry = MunicipioEntry::find($Id);
            $municipioEntry->Estado =   $data['Estado'];
            $municipioEntry->save();

            $responseMessage = array('msg' 
                            => "Se cambio estado correctamente",'id' 
                            => $municipioEntry->id);

        return $this->customResponse->is200Response($response,$responseMessage);

        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }

    /* DESDE AQUI SE PROCESO EL CRUE DE LA TABLA PARAMETRICA CORREGIMIENTO */
    public function viewCorregimiento(Response $response)
    {
        $CorregimientoEntry = $this->corregimientoEntry->get();
        return $this->customResponse->is200Response($response,$CorregimientoEntry);
    }

    public function estadoCorregimiento(Request $request,Response $response,$Id)
    {
       $data = json_decode($request->getBody(),true);
       $this->validator->validate($request,[
            "Estado" =>v::notEmpty(),
         ]); 

     if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       } 

        try{
            $corregimientoEntry = CorregimientoEntry::find($Id);
            $corregimientoEntry->Estado =   $data['Estado'];
            $corregimientoEntry->save();

            $responseMessage = array('msg' 
                            => "Se cambio estado correctamente",'id' 
                            => $corregimientoEntry->id);

        return $this->customResponse->is200Response($response,$responseMessage);

        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }

    /* DESDE AQUI SE PROCESO EL CRUE DE LA TABLA PARAMETRICA VEREDAS BARRIO */
    public function viewVeredas_barrios(Response $response)
    {
        $Veredas_barriosEntry = $this->veredas_barriosEntry->get();
        return $this->customResponse->is200Response($response,$Veredas_barriosEntry);
    }

    public function estadoVeredas_barrios(Request $request,Response $response,$Id)
    {
       $data = json_decode($request->getBody(),true);
       $this->validator->validate($request,[
            "Estado" =>v::notEmpty(),
         ]); 

     if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       } 

        try{
            $veredas_barriosEntry = Veredas_barriosEntry::find($Id);
            $veredas_barriosEntry->Estado =   $data['Estado'];
            $veredas_barriosEntry->save();

            $responseMessage = array('msg' 
                            => "Se cambio estado correctamente",'id' 
                            => $veredas_barriosEntry->id);

        return $this->customResponse->is200Response($response,$responseMessage);

        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }

    /* DESDE AQUI SE PROCESO EL CRUE DE LA TABLA PARAMETRICA ESCOLARIDAD */
    public function viewEscolaridad(Response $response)
    {
        $EscolaridadEntry = $this->escolaridadEntry->get();
        return $this->customResponse->is200Response($response,$EscolaridadEntry);
    }
    public function estadoEscolaridad(Request $request,Response $response,$Id)
    {
       $data = json_decode($request->getBody(),true);
       $this->validator->validate($request,[
            "Estado" =>v::notEmpty(),
         ]); 

     if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       } 

        try{
            $escolaridadEntry = EscolaridadEntry::find($Id);
            $escolaridadEntry->Estado =   $data['Estado'];
            $escolaridadEntry->save();

            $responseMessage = array('msg' 
                            => "Se cambio estado correctamente",'id' 
                            => $escolaridadEntry->id);

        return $this->customResponse->is200Response($response,$responseMessage);

        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }
    /* DESDE AQUI SE PROCESO EL CRUE DE LA TABLA PARAMETRICA PARENTESCO */
    public function viewParentesco(Response $response)
    {
        $ParentescoEntry = $this->parentescoEntry->get();
        return $this->customResponse->is200Response($response,$ParentescoEntry);
    }

    public function estadoParentesco(Request $request,Response $response,$Id)
    {
       $data = json_decode($request->getBody(),true);
       $this->validator->validate($request,[
            "Estado" =>v::notEmpty(),
         ]); 

     if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       } 

        try{
            $parentescoEntry = ParentescoEntry::find($Id);
            $parentescoEntry->Estado =   $data['Estado'];
            $parentescoEntry->save();

            $responseMessage = array('msg' 
                            => "Se cambio estado correctamente",'id' 
                            => $parentescoEntry->id);

        return $this->customResponse->is200Response($response,$responseMessage);

        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }

    /* DESDE AQUI SE PROCESO EL CRUE DE LA TABLA PARAMETRICA Orientacion_sexual */
    public function viewOrientacion_sexual(Response $response)
    {
        $Orientacion_sexualEntry = $this->orientacion_sexualEntry->get();
        return $this->customResponse->is200Response($response,$Orientacion_sexualEntry);
    }
    public function estadoOrientacion_sexual(Request $request,Response $response,$Id)
    {
       $data = json_decode($request->getBody(),true);
       $this->validator->validate($request,[
            "Estado" =>v::notEmpty(),
         ]); 

     if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       } 

        try{
            $orientacion_sexualEntry = Orientacion_sexualEntry::find($Id);
            $orientacion_sexualEntry->Estado =   $data['Estado'];
            $orientacion_sexualEntry->save();

            $responseMessage = array('msg' 
                            => "Se cambio estado correctamente",'id' 
                            => $orientacion_sexualEntry->id);

        return $this->customResponse->is200Response($response,$responseMessage);

        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }


    /* DESDE AQUI SE PROCESO EL CRUE DE LA TABLA PARAMETRICA  TIPO INMUEBLE*/
    public function viewTipoinmueble(Response $response)
    {
        $TipoinmuebleEntry = $this->tipoinmuebleEntry->get();
        return $this->customResponse->is200Response($response,$TipoinmuebleEntry);
    }

    public function estadoTipoinmueble(Request $request,Response $response,$Id)
    {
       $data = json_decode($request->getBody(),true);
       $this->validator->validate($request,[
            "Estado" =>v::notEmpty(),
         ]); 

     if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       } 

        try{
            $tipoinmuebleEntry = TipoinmuebleEntry::find($Id);
            $tipoinmuebleEntry->Estado =   $data['Estado'];
            $tipoinmuebleEntry->save();

            $responseMessage = array('msg' 
                            => "Se cambio estado correctamente",'id' 
                            => $tipoinmuebleEntry->id);

        return $this->customResponse->is200Response($response,$responseMessage);

        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }


   /* DESDE AQUI SE PROCESO EL CRUE DE LA TABLA PARAMETRICA TENENCIAS */
    public function viewTenencia(Response $response)
    {
        $TenenciaEntry = $this->tenenciaEntry->get();
        return $this->customResponse->is200Response($response,$TenenciaEntry);
    }

    public function estadoTenencia(Request $request,Response $response,$Id)
    {
       $data = json_decode($request->getBody(),true);
       $this->validator->validate($request,[
            "Estado" =>v::notEmpty(),
         ]); 

     if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       } 

        try{
            $tenenciaEntry = TenenciaEntry::find($Id);
            $tenenciaEntry->Estado =   $data['Estado'];
            $tenenciaEntry->save();

            $responseMessage = array('msg' 
                            => "Se cambio estado correctamente",'id' 
                            => $tenenciaEntry->id);

        return $this->customResponse->is200Response($response,$responseMessage);

        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }



    /* DESDE AQUI SE PROCESO EL CRUE DE LA TABLA PARAMETRICA TIPO DOCUMENTO */
    public function viewTipodocumento(Response $response)
    {
        $Tipo_documentoEntry = $this->tipodocumentoEntry->get();
        return $this->customResponse->is200Response($response,$Tipo_documentoEntry);
    }

    public function estadoTipodocumento(Request $request,Response $response,$Id)
    {
       $data = json_decode($request->getBody(),true);
       $this->validator->validate($request,[
            "Estado" =>v::notEmpty(),
         ]); 

     if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       } 

        try{
            $tipodocumentoEntry = Tipo_documentoEntry::find($Id);
            $tipodocumentoEntry->Estado =   $data['Estado'];
            $tipodocumentoEntry->save();

            $responseMessage = array('msg' 
                            => "Se cambio estado correctamente",'id' 
                            => $tipodocumentoEntry->id);

        return $this->customResponse->is200Response($response,$responseMessage);

        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }

    /* DESDE AQUI SE PROCESO EL CRUE DE LA TABLA PARAMETRICA LOGO */
    public function viewLogo(Response $response)
    {
        $LogoEntry = $this->logoEntry->get();
        return $this->customResponse->is200Response($response,$LogoEntry);
    }
}