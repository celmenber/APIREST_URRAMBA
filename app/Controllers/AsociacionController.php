<?php
namespace  App\Controllers;
use App\Models\AsociacionEntry;

use App\Response\CustomResponse;
use App\Validation\Validator;
use Respect\Validation\Exceptions\Exception;
use Respect\Validation\Validator as v;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AsociacionController {

    protected $customResponse;

    protected $asociacionEntry;

    protected $validator;

    public function __construct()
    {
    $this->customResponse = new CustomResponse();
    $this->asociacionEntry = new AsociacionEntry();
    $this->validator = new Validator();

    }
  /* DESDE AQUI SE PROCESO EL CRUE DE LA TABLA ASOCIACION */
    public function viewAsociacion(Response $response)
    {
    
        $AsociacionEntry = asociacionEntry::select(
           "tbl_asociacion.Nit",
           "tbl_asociacion.Nombre",
           "tbl_asociacion.Direccion",
           "tbl_asociacion.Telefono",
           "tbl_asociacion.Correo",
           "tbl_asociacion.Id_municipio",
          "tbl_municipio.Nombre AS municipio"
         )->join(
                "tbl_municipio", 
                "tbl_asociacion.Id_municipio","=","tbl_municipio.ID")
          ->get();
        return $this->customResponse->is200Response($response,$AsociacionEntry);
    }

    public function viewAsociacionid(Response $response,$id)
    {

        $AsociacionEntry = asociacionEntry::select(
           "tbl_asociacion.Nit",
           "tbl_asociacion.Nombre",
           "tbl_asociacion.Direccion",
           "tbl_asociacion.Telefono",
           "tbl_asociacion.Correo",
           "tbl_asociacion.Id_municipio",
           "tbl_municipio.Nombre AS municipio"
         )->join(
                "tbl_municipio", 
                "tbl_asociacion.Id_municipio","=","tbl_municipio.ID")
             ->where("tbl_asociacion.ID","=",$id)
             ->get();
        return $this->customResponse->is200Response($response,$AsociacionEntry);
    }

    public function deleteAsociacion(Response $response,$id)
    {
        $this->asociacionEntry->where(["ID"=>$id])->delete();
        $responseMessage = "La Asociacion fue eliminada successfully";
        return $this->customResponse->is200Response($response,$responseMessage);
    }

    public function createAsociacion(Request $request,Response $response)
    {
       $data = json_decode($request->getBody(),true);
       $this->validator->validate($request,[
           "Id_municipio"=>v::notEmpty(),
           "Nit"=>v::notEmpty(),
           "Nombre"=>v::notEmpty(),
           "Direccion"=>v::notEmpty(),
           "Telefono"=>v::notEmpty(),
           "Correo"=>v::notEmpty()
         ]); 

        if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       } 
        try{
        $asociacionEntry = new AsociacionEntry;
        $asociacionEntry->id_municipio  =   $data['Id_municipio'];
        $asociacionEntry->Nit           =   $data['Nit'];
        $asociacionEntry->Nombre        =   $data['Nombre'];
        $asociacionEntry->direccion     =   $data['Direccion'];
        $asociacionEntry->telefono      =   $data['Telefono'];
        $asociacionEntry->correo        =   $data['Correo'];

        $asociacionEntry->save();
        $responseMessage = array('msg' 
                        => "Asociacion Guardada correctamente",'id' 
                        => $asociacionEntry->id);

        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
   }

       public function editAsociacion(Request $request,Response $response,$id)
    {
       $data = json_decode($request->getBody(),true);
       $this->validator->validate($request,[
           "Id_municipio"=>v::notEmpty(),
           "Nit"=>v::notEmpty(),
           "Nombre"=>v::notEmpty(),
           "Direccion"=>v::notEmpty(),
           "Telefono"=>v::notEmpty(),
           "Correo"=>v::notEmpty()
         ]); 

        if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       } 
        try{
        $asociacionEntry = AsociacionEntry::find($id);
        $asociacionEntry->id_municipio  =   $data['Id_municipio'];
        $asociacionEntry->Nit           =   $data['Nit'];
        $asociacionEntry->Nombre        =   $data['Nombre'];
        $asociacionEntry->direccion     =   $data['Direccion'];
        $asociacionEntry->telefono      =   $data['Telefono'];
        $asociacionEntry->correo        =   $data['Correo'];

        $asociacionEntry->save();
        $responseMessage = array('msg' 
                        => "La asociacion editada correctamente",'id' 
                        => $asociacionEntry->id);

        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
   }

}