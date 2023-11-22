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

      /* DESDE AQUI SE PROCESO EL CRUE DE LA TABLA VUVIENDA */
    public function viewVivienda(Response $response)
    {
        $ViviendaEntry = $this->viviendaEntry->get();
        return $this->customResponse->is200Response($response,$ViviendaEntry); 
    }

    public function viewViviendaId(Response $response,$Id)
    {
        $ViviendaEntry = $this->viviendaEntry->where(["ID"=>$Id])->get();
        return $this->customResponse->is200Response($response,$ViviendaEntry);
    }

    public function deleteVivienda(Response $response,$Id)
    {
        $this->viviendaEntry->where(["ID"=>$Id])->delete();
        $responseMessage = "La Vivienda fue eliminada successfully";  
        return $this->customResponse->is200Response($response,$responseMessage);
    }

    public function createVivienda(Request $request,Response $response)
    {
       $data = json_decode($request->getBody(),true);
       $this->validator->validate($request,[
           "Id_jefe_hogar"=>v::notEmpty(),
           "Id_tipo_inmueble"=>v::notEmpty(),
           "Id_tenencia"=>v::notEmpty(),
           "Zona"=>v::notEmpty(),
           "Estado"=>v::notEmpty(),
         ]); 

        if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       } 

        try{
        $viviendaEntry = new ViviendaEntry;
        $viviendaEntry->id_jefe_hogar     =   $data['Id_jefe_hogar'];
        $viviendaEntry->id_tipo_inmueble  =   $data['Id_tipo_inmueble'];
        $viviendaEntry->id_tenencia       =   $data['Id_tenencia'];
        $viviendaEntry->zona              =   $data['Zona'];
        $viviendaEntry->estado            =   $data['Estado'];
        $viviendaEntry->save();
        $responseMessage = array('msg' => "Vivienda Guardada correctamente",'id' => $viviendaEntry->id);
        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
   }
   public function editVivienda(Request $request,Response $response, $Id)
   {
      $data = json_decode($request->getBody(),true);
      $this->validator->validate($request,[
           "Id_jefe_hogar"=>v::notEmpty(),
           "Id_tipo_inmueble"=>v::notEmpty(),
           "Id_tenencia"=>v::notEmpty(),
           "Zona"=>v::notEmpty(),
           "Estado"=>v::notEmpty(),
        ]); 

       if($this->validator->failed())
      {
          $responseMessage = $this->validator->errors;
          return $this->customResponse->is400Response($response,$responseMessage);
      } 

       try{
        $viviendaEntry = ViviendaEntry::find($Id);
        $viviendaEntry->id_jefe_hogar     =   $data['Id_jefe_hogar'];
        $viviendaEntry->id_tipo_inmueble  =   $data['Id_tipo_inmueble'];
        $viviendaEntry->id_tenencia       =   $data['Id_tenencia'];
        $viviendaEntry->zona              =   $data['Zona'];
        $viviendaEntry->estado            =   $data['Estado'];
        $viviendaEntry->save();
       $responseMessage = array('msg' => "Vivienda editada correctamente",'id' => $viviendaEntry->id);
       return $this->customResponse->is200Response($response,$responseMessage);
       }catch(Exception $err){
       $responseMessage = array("err" => $err->getMessage());
       return $this->customResponse->is400Response($response,$responseMessage);
      }
  }
  public function estadoVivienda(Request $request,Response $response, $Id)
  {
     $data = json_decode($request->getBody(),true);
     $this->validator->validate($request,[
         "Estado"=>v::notEmpty(),
       ]); 

      if($this->validator->failed())
     {
         $responseMessage = $this->validator->errors;
         return $this->customResponse->is400Response($response,$responseMessage);
     } 

      try{
      $viviendaEntry = ViviendaEntry::find($Id);
      $viviendaEntry->estado         =   $data['Estado'];
      $viviendaEntry->save();
      $responseMessage = array('msg' => "Estado vivienda cambiado correctamente",'id' => $viviendaEntry->id);
      return $this->customResponse->is200Response($response,$responseMessage);
      }catch(Exception $err){
      $responseMessage = array("err" => $err->getMessage());
      return $this->customResponse->is400Response($response,$responseMessage);
     }
 }
}