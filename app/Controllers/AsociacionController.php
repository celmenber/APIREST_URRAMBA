<?php
namespace  App\Controllers;
use App\Models\AsociacionEntry;
use App\Models\AsociacionEmpleadoEntry;

use App\Response\CustomResponse;
use App\Validation\Validator;
use Respect\Validation\Exceptions\Exception;
use Respect\Validation\Validator as v;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AsociacionController {

    protected $customResponse;

    protected $asociacionEntry;

     protected $asociacionEmpleadoEntry;

    protected $validator;

    public function __construct()
    {
    $this->customResponse = new CustomResponse();
    $this->asociacionEntry = new AsociacionEntry();
    $this->asociacionEmpleadoEntry = new AsociacionEmpleadoEntry();
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

     /* DESDE AQUI SE PROCESO EL CRUE DE LA TABLA ASOCIACION EMPLEADOS */
    public function viewAsociacionEmpleado(Response $response)
    {
    
        $AsociacionEmpleadoEntry = asociacionEmpleadoEntry::select(
            "tbl_asociacion_empleados.id_municipio",
            "tbl_asociacion_empleados.id_barrio_vereda",
            "tbl_asociacion_empleados.id_tipo_documento",
            "tbl_asociacion_empleados.documentos",
            "tbl_asociacion_empleados.nombres",
            "tbl_asociacion_empleados.apellidos",
            "tbl_asociacion_empleados.direccion",
            "tbl_asociacion_empleados.telefono",
            "tbl_asociacion_empleados.correo",
            "tbl_asociacion_empleados.estado",
            "tbl_municipio.Nombre AS municipio",
            "tbl_tipo_documento.Nombre as Tipo_documento",
            "tbl_veredas_barrios.Nombre as Veredas_Barrios",
         )->join(
                "tbl_municipio", 
                "tbl_asociacion.Id_municipio","=","tbl_municipio.ID")
          ->join(
                "tbl_veredas_barrios", 
                "tbl_autoridad_tradicional.id_barrio_vereda","=","tbl_veredas_barrios.ID")
          ->join(
                "tbl_tipo_documento", 
                "tbl_autoridad_tradicional.id_tipo_documento","=","tbl_tipo_documento.ID")
          ->get();
        return $this->customResponse->is200Response($response,$AsociacionEmpleadoEntry);
    }

    public function viewAsociacionEmpleadoid(Response $response,$id)
    {

        $AsociacionEmpleadoEntry = asociacionEmpleadoEntry::select(
           "tbl_asociacion_empleados.id_municipio",
            "tbl_asociacion_empleados.id_barrio_vereda",
            "tbl_asociacion_empleados.id_tipo_documento",
            "tbl_asociacion_empleados.documentos",
            "tbl_asociacion_empleados.nombres",
            "tbl_asociacion_empleados.apellidos",
            "tbl_asociacion_empleados.direccion",
            "tbl_asociacion_empleados.telefono",
            "tbl_asociacion_empleados.correo",
            "tbl_asociacion_empleados.estado",
            "tbl_municipio.Nombre AS municipio",
            "tbl_tipo_documento.Nombre as Tipo_documento",
            "tbl_veredas_barrios.Nombre as Veredas_Barrios",
         )->join(
                "tbl_municipio", 
                "tbl_asociacion.Id_municipio","=","tbl_municipio.ID")
          ->join(
                "tbl_veredas_barrios", 
                "tbl_autoridad_tradicional.id_barrio_vereda","=","tbl_veredas_barrios.ID")
          ->join(
                "tbl_tipo_documento", 
                "tbl_autoridad_tradicional.id_tipo_documento","=","tbl_tipo_documento.ID")

            ->where("tbl_asociacion.ID","=",$id)
            ->get();
        return $this->customResponse->is200Response($response,$AsociacionEmpleadoEntry);
    }

    public function deleteAsociacionEmpleado(Response $response,$id)
    {
        $this->asociacionEmpleadoEntry->where(["ID"=>$id])->delete();
        $responseMessage = "El Empleado Asociacion fue eliminada successfully";
        return $this->customResponse->is200Response($response,$responseMessage);
    }

    public function createAsociacionEmpleado(Request $request,Response $response)
    {
       $data = json_decode($request->getBody(),true);
       $this->validator->validate($request,[
            "Id_asociacion" =>v::notEmpty(),
            "Id_barrio_vereda" =>v::notEmpty(),
            "Id_tipo_documento" =>v::notEmpty(),
            "Documentos" =>v::notEmpty(),
            "Nombres" =>v::notEmpty(),
            "Apellidos" =>v::notEmpty(),
            "Direccion" =>v::notEmpty(),
            "Telefono" =>v::notEmpty(),
            "Correo" =>v::notEmpty(),
            "Estado" =>v::notEmpty(),
            "Fecha_ingreso" =>v::notEmpty(),
         ]); 

     if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       } 

        try{
            $asociacionEmpleadoEntry = new AsociacionEmpleadoEntry;
            $asociacionEmpleadoEntry->id_asociacion       =   $data['Id_asociacion'];
            $asociacionEmpleadoEntry->id_barrio_vereda    =   $data['Id_barrio_vereda'];
            $asociacionEmpleadoEntry->id_corregimiento    =   $data['Id_corregimiento'];
            $asociacionEmpleadoEntry->id_tipo_documento   =   $data['Id_tipo_documento'];
            $asociacionEmpleadoEntry->documentos          =   $data['Documentos'];
            $asociacionEmpleadoEntry->nombres             =   $data['Nombres'];
            $asociacionEmpleadoEntry->apellidos           =   $data['Apellidos'];
            $asociacionEmpleadoEntry->direccion           =   $data['Direccion'];
            $asociacionEmpleadoEntry->telefono            =   $data['Telefono'];
            $asociacionEmpleadoEntry->estado              =   $data['Estado'];
            $asociacionEmpleadoEntry->fecha_ingreso       =   $data['Fecha_ingreso'];
            $asociacionEmpleadoEntry->save();

            $responseMessage = array('msg' 
                            => "El empleado de la asociacion se guardo correctamente",'id' 
                            => $asociacionEmpleadoEntry->id);

        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }

    public function editarAsociacionEmpleado(Request $request,Response $response,$id)
    {
       $data = json_decode($request->getBody(),true);
       $this->validator->validate($request,[
            "Id_asociacion" =>v::notEmpty(),
            "Id_barrio_vereda" =>v::notEmpty(),
            "Id_tipo_documento" =>v::notEmpty(),
            "Documentos" =>v::notEmpty(),
            "Nombres" =>v::notEmpty(),
            "Apellidos" =>v::notEmpty(),
            "Direccion" =>v::notEmpty(),
            "Telefono" =>v::notEmpty(),
            "Correo" =>v::notEmpty(),
            "Estado" =>v::notEmpty(),
            "Fecha_ingreso" =>v::notEmpty(),
         ]); 

     if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       } 

        try{
            $asociacionEmpleadoEntry = AsociacionEmpleadoEntry::find($id);
            $asociacionEmpleadoEntry->id_asociacion       =   $data['Id_asociacion'];
            $asociacionEmpleadoEntry->id_barrio_vereda    =   $data['Id_barrio_vereda'];
            $asociacionEmpleadoEntry->id_corregimiento    =   $data['Id_corregimiento'];
            $asociacionEmpleadoEntry->id_tipo_documento   =   $data['Id_tipo_documento'];
            $asociacionEmpleadoEntry->documentos          =   $data['Documentos'];
            $asociacionEmpleadoEntry->nombres             =   $data['Nombres'];
            $asociacionEmpleadoEntry->apellidos           =   $data['Apellidos'];
            $asociacionEmpleadoEntry->direccion           =   $data['Direccion'];
            $asociacionEmpleadoEntry->telefono            =   $data['Telefono'];
            $asociacionEmpleadoEntry->estado              =   $data['Estado'];
            $asociacionEmpleadoEntry->fecha_ingreso       =   $data['Fecha_ingreso'];
            $asociacionEmpleadoEntry->save();

            $responseMessage = array('msg' 
                            => "El empleado de la asociacion se guardo correctamente",'id' 
                            => $asociacionEmpleadoEntry->id);

        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }
}