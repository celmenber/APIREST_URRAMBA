<?php
namespace  App\Controllers;
use App\Models\ConcejocomunitarioEntry;
use App\Models\AutoridadtradicionalEntry;
use App\Models\ConcejosmiembrosEntry;

use App\Response\CustomResponse;
use App\Validation\Validator;
use Respect\Validation\Exceptions\Exception;
use Respect\Validation\Validator as v;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ConcejocomunitarioController
{
    protected $customResponse;

    protected $concejocomunitarioEntry;

    protected $autoridadtradicionalEntry;

    protected $concejosmiembrosEntry;

    protected $validator;

    public function __construct()
    {

        $this->customResponse = new CustomResponse();
        $this->concejocomunitarioEntry = new ConcejocomunitarioEntry();
        $this->autoridadtradicionalEntry = new AutoridadtradicionalEntry();
        $this->concejosmiembrosEntry = new ConcejosmiembrosEntry();
        $this->validator = new Validator();

    }
 /* DESDE AQUI SE PROCESO EL CRUED DE LA TABLA CONCEJO COMUNITARIO */
    public function viewConcejocomunitario(Response $response)
    {
        $ConcejocomunitarioEntry = concejocomunitarioEntry::select(
            "tbl_conncejos_comunitarios.id_autoridad_tradicional",
            "tbl_conncejos_comunitarios.id_municipio",
            "tbl_conncejos_comunitarios.id_asociacion",
            "tbl_conncejos_comunitarios.Nit",
            "tbl_conncejos_comunitarios.Nombre_concejo_comunitario",
            "tbl_conncejos_comunitarios.Direccion",
            "tbl_municipio.Nombre as Municipio",
            "tbl_asociacion.Nombre",
            "tbl_autoridad_tradicional.documentos",
            "tbl_autoridad_tradicional.nombres",
            "tbl_autoridad_tradicional.apellidos",
         )->join(
                "tbl_municipio", 
                "tbl_conncejos_comunitarios.Id_municipio","=","tbl_municipio.ID")
          ->join(
                "tbl_autoridad_tradicional", 
                "tbl_conncejos_comunitarios.id_autoridad_tradicional","=","tbl_autoridad_tradicional.ID")
          ->join(
                "tbl_municipio", 
                "tbl_conncejos_comunitarios.id_asociacion","=","tbl_asociacion.ID")
            ->get();
        return $this->customResponse->is200Response($response,$ConcejocomunitarioEntry);
    }
   public function viewConcejocomunitarioId(Response $response,$Id)
    {
        $ConcejocomunitarioEntry = concejocomunitarioEntry::select(
            "tbl_conncejos_comunitarios.id_autoridad_tradicional",
            "tbl_conncejos_comunitarios.id_municipio",
            "tbl_conncejos_comunitarios.id_asociacion",
            "tbl_conncejos_comunitarios.Nit",
            "tbl_conncejos_comunitarios.Nombre_concejo_comunitario",
            "tbl_conncejos_comunitarios.Direccion",
            "tbl_municipio.Nombre as Municipio",
            "tbl_asociacion.Nombre",
            "tbl_autoridad_tradicional.documentos",
            "tbl_autoridad_tradicional.nombres",
            "tbl_autoridad_tradicional.apellidos",
         )->join(
                "tbl_municipio", 
                "tbl_conncejos_comunitarios.Id_municipio","=","tbl_municipio.ID")
          ->join(
                "tbl_autoridad_tradicional", 
                "tbl_conncejos_comunitarios.id_autoridad_tradicional","=","tbl_autoridad_tradicional.ID")
          ->join(
                "tbl_asociacion", 
                "tbl_conncejos_comunitarios.id_asociacion","=","tbl_asociacion.ID")
         ->where("ID","=",$Id)
         ->get();
        return $this->customResponse->is200Response($response,$ConcejocomunitarioEntry);
    }

    public function deleteConcejocomunitario(Response $response,$Id)
    {
        $this->concejocomunitarioEntry->where(["ID"=>$Id])->delete();
        $responseMessage = "El concejocomunitario fue eliminada successfully";
        return $this->customResponse->is200Response($response,$responseMessage);
    }

    public function createConcejocomunitario(Request $request,Response $response)
    {
       $data = json_decode($request->getBody(),true);
       $this->validator->validate($request,[
        	"Id_asociacion"=>v::notEmpty(),
            "Id_autoridad_tradicional"=>v::notEmpty(),
            "Id_municipio"=>v::notEmpty(),
            "Nit"=>v::notEmpty(),
            "Nombre_concejo_comunitario"=>v::notEmpty(),
            "Direccion"=>v::notEmpty(),
         ]); 

        if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       } 
        try{
            $concejocomunitarioEntry = new ConcejocomunitarioEntry;
        	$concejocomunitarioEntry->id_asociacion              =   $data['Id_asociacion'];
            $concejocomunitarioEntry->id_autoridad_tradicional   =   $data['Id_autoridad_tradicional'];
            $concejocomunitarioEntry->id_municipio               =   $data['Id_municipio']; 
            $concejocomunitarioEntry->Nit                        =   $data['Nit'];
            $concejocomunitarioEntry->Nombre_concejo_comunitario =   $data['Nombre_concejo_comunitario'];
            $concejocomunitarioEntry->Direccion                  =   $data['Direccion'];

            $concejocomunitarioEntry->save();
            $responseMessage = array('msg' 
                            => "Asociacion Guardada correctamente",'id' 
                            => $concejocomunitarioEntry->id);

        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }
   public function editConcejocomunitario(Request $request,Response $response,$Id)
    {
       $data = json_decode($request->getBody(),true);
       $this->validator->validate($request,[
        	"Id_asociacion"=>v::notEmpty(),
            "Id_autoridad_tradicional"=>v::notEmpty(),
            "Id_municipio"=>v::notEmpty(),
            "Nit"=>v::notEmpty(),
            "Nombre_concejo_comunitario"=>v::notEmpty(),
            "Direccion"=>v::notEmpty(),
         ]); 

        if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       } 
        try{
            $concejocomunitarioEntry = ConcejocomunitarioEntry::find($Id);
        	$concejocomunitarioEntry->id_asociacion              =   $data['Id_asociacion'];
            $concejocomunitarioEntry->id_autoridad_tradicional   =   $data['Id_autoridad_tradicional'];
            $concejocomunitarioEntry->id_municipio               =   $data['Id_municipio']; 
            $concejocomunitarioEntry->Nit                        =   $data['Nit'];
            $concejocomunitarioEntry->Nombre_concejo_comunitario =   $data['Nombre_concejo_comunitario'];
            $concejocomunitarioEntry->Direccion                  =   $data['Direccion'];

            $concejocomunitarioEntry->save();
            $responseMessage = array('msg' 
                            => "Asociacion Guardada correctamente",'id' 
                            => $concejocomunitarioEntry->id);

        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
   }


    /* DESDE AQUI SE PROCESO EL CRUED DE LA TABLA AURORIDAD TRADICIONAL */
    public function viewAutoridaTradicional(Response $response)
    {
        $AutoridadtradicionalEntry = autoridadtradicionalEntry::select(
            "tbl_autoridad_tradicional.id_municipio",
            "tbl_autoridad_tradicional.id_barrio_vereda",
            "tbl_autoridad_tradicional.id_corregimiento",
            "tbl_autoridad_tradicional.id_tipo_documento",
            "tbl_autoridad_tradicional.documentos",
            "tbl_autoridad_tradicional.nombres",
            "tbl_autoridad_tradicional.apellidos",
            "tbl_autoridad_tradicional.sexo",
            "tbl_autoridad_tradicional.genero",
            "tbl_autoridad_tradicional.orientacion_sexual",
            "tbl_autoridad_tradicional.direccion",
            "tbl_autoridad_tradicional.telefono",
            "tbl_autoridad_tradicional.estado",
            "tbl_autoridad_tradicional.fecha_nacimiento",
            "tbl_autoridad_tradicional.fecha_ingreso",
            "tbl_municipio.Nombre as Municipio",
            "tbl_tipo_documento.Nombre as Tipo_documento",
            "tbl_veredas_barrios.Nombre as Veredas_Barrios",
            "tbl_corregimiento.Nombre as Corregimiento",
         )->join(
                "tbl_municipio", 
                "tbl_autoridad_tradicional.Id_municipio","=","tbl_municipio.ID")
          ->join(
                "tbl_veredas_barrios", 
                "tbl_autoridad_tradicional.id_barrio_vereda","=","tbl_veredas_barrios.ID")
          ->join(
                "tbl_corregimiento", 
                "tbl_autoridad_tradicional.id_corregimiento","=","tbl_corregimiento.ID")
          ->join(
                "tbl_tipo_documento", 
                "tbl_autoridad_tradicional.id_tipo_documento","=","tbl_tipo_documento.ID")->get();
        return $this->customResponse->is200Response($response,$AutoridadtradicionalEntry);
    }

     public function viewAutoridaTradicionalId(Response $response,$Id)
    {
        $AutoridadtradicionalEntry = autoridadtradicionalEntry::select(
            "tbl_autoridad_tradicional.id_municipio",
            "tbl_autoridad_tradicional.id_barrio_vereda",
            "tbl_autoridad_tradicional.id_corregimiento",
            "tbl_autoridad_tradicional.id_tipo_documento",
            "tbl_autoridad_tradicional.documentos",
            "tbl_autoridad_tradicional.nombres",
            "tbl_autoridad_tradicional.apellidos",
            "tbl_autoridad_tradicional.sexo",
            "tbl_autoridad_tradicional.genero",
            "tbl_autoridad_tradicional.orientacion_sexual",
            "tbl_autoridad_tradicional.direccion",
            "tbl_autoridad_tradicional.telefono",
            "tbl_autoridad_tradicional.estado",
            "tbl_autoridad_tradicional.fecha_nacimiento",
            "tbl_autoridad_tradicional.fecha_ingreso",
            "tbl_municipio.Nombre as Municipio",
            "tbl_tipo_documento.Nombre as Tipo_documento",
            "tbl_veredas_barrios.Nombre as Veredas_Barrios",
            "tbl_corregimiento.Nombre as Corregimiento",
         )->join(
                "tbl_municipio", 
                "tbl_autoridad_tradicional.Id_municipio","=","tbl_municipio.ID")
          ->join(
                "tbl_veredas_barrios", 
                "tbl_autoridad_tradicional.id_barrio_vereda","=","tbl_veredas_barrios.ID")
          ->join(
                "tbl_corregimiento", 
                "tbl_autoridad_tradicional.id_corregimiento","=","tbl_corregimiento.ID")
         ->join(
                "tbl_tipo_documento", 
                "tbl_autoridad_tradicional.id_tipo_documento","=","tbl_tipo_documento.ID")   
         ->where("ID","=",$Id)->get();
        return $this->customResponse->is200Response($response,$AutoridadtradicionalEntry);
    }

    public function deleteAutoridaTradicional(Response $response,$Id)
    {
        $this->autoridadtradicionalEntry->where(["ID"=>$Id])->delete();
        $responseMessage = "La Autorida Tradicinal fue eliminada successfully";
        return $this->customResponse->is200Response($response,$responseMessage);
    }

    public function createAutoridaTradicinal(Request $request,Response $response)
    {
       $data = json_decode($request->getBody(),true);
       $this->validator->validate($request,[
            "Id_municipio" =>v::notEmpty(),
            "Id_barrio_vereda" =>v::notEmpty(),
            "Id_corregimiento" =>v::notEmpty(),
            "Id_tipo_documento" =>v::notEmpty(),
            "Documentos" =>v::notEmpty(),
            "Nombres" =>v::notEmpty(),
            "Apellidos" =>v::notEmpty(),
            "Sexo" =>v::notEmpty(),
            "Genero" =>v::notEmpty(),
            "Orientacion_sexual" =>v::notEmpty(),
            "Direccion" =>v::notEmpty(),
            "Telefono" =>v::notEmpty(),
            "Estado" =>v::notEmpty(),
            "Fecha_nacimiento" =>v::notEmpty(),
            "Fecha_ingreso" =>v::notEmpty(),
         ]); 

     if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       } 

        try{
            $autoridadtradicionalEntry = new AutoridadtradicionalEntry;
            $autoridadtradicionalEntry->id_municipio        =   $data['Id_municipio'];
            $autoridadtradicionalEntry->id_barrio_vereda    =   $data['Id_barrio_vereda'];
            $autoridadtradicionalEntry->id_corregimiento    =   $data['Id_corregimiento'];
            $autoridadtradicionalEntry->id_tipo_documento   =   $data['Id_tipo_documento'];
            $autoridadtradicionalEntry->documentos          =   $data['Documentos'];
            $autoridadtradicionalEntry->nombres             =   $data['Nombres'];
            $autoridadtradicionalEntry->apellidos           =   $data['Apellidos'];
            $autoridadtradicionalEntry->sexo                =   $data['Sexo'];
            $autoridadtradicionalEntry->genero              =   $data['Genero'];
            $autoridadtradicionalEntry->orientacion_sexual  =   $data['Orientacion_sexual'];
            $autoridadtradicionalEntry->direccion           =   $data['Direccion'];
            $autoridadtradicionalEntry->telefono            =   $data['Telefono'];
            $autoridadtradicionalEntry->estado              =   $data['Estado'];
            $autoridadtradicionalEntry->fecha_nacimiento    =   $data['Fecha_nacimiento'];
            $autoridadtradicionalEntry->fecha_ingreso       =   $data['Fecha_ingreso'];
            $autoridadtradicionalEntry->save();

            $responseMessage = array('msg' 
                            => "La autoridad tradicional Guardada correctamente",'id' 
                            => $autoridadtradicionalEntry->id);

        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }

    public function editAutoridaTradicional(Request $request,Response $response,$Id)
    {
       $data = json_decode($request->getBody(),true);
       $this->validator->validate($request,[
            "Id_municipio" =>v::notEmpty(),
            "Id_barrio_vereda" =>v::notEmpty(),
            "Id_corregimiento" =>v::notEmpty(),
            "Id_tipo_documento" =>v::notEmpty(),
            "Documentos" =>v::notEmpty(),
            "Nombres" =>v::notEmpty(),
            "Apellidos" =>v::notEmpty(),
            "Sexo" =>v::notEmpty(),
            "Genero" =>v::notEmpty(),
            "Orientacion_sexual" =>v::notEmpty(),
            "Direccion" =>v::notEmpty(),
            "Telefono" =>v::notEmpty(),
            "Estado" =>v::notEmpty(),
            "Fecha_nacimiento" =>v::notEmpty(),
            "Fecha_ingreso" =>v::notEmpty(),
         ]); 

     if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       } 
       
        try{
            $autoridadtradicionalEntry = AutoridadtradicionalEntry::find($Id);
            $autoridadtradicionalEntry->id_municipio        =   $data['Id_municipio'];
            $autoridadtradicionalEntry->id_barrio_vereda    =   $data['Id_barrio_vereda'];
            $autoridadtradicionalEntry->id_corregimiento    =   $data['Id_corregimiento'];
            $autoridadtradicionalEntry->id_tipo_documento   =   $data['Id_tipo_documento'];
            $autoridadtradicionalEntry->documentos          =   $data['Documentos'];
            $autoridadtradicionalEntry->nombres             =   $data['Nombres'];
            $autoridadtradicionalEntry->apellidos           =   $data['Apellidos'];
            $autoridadtradicionalEntry->sexo                =   $data['Sexo'];
            $autoridadtradicionalEntry->genero              =   $data['Genero'];
            $autoridadtradicionalEntry->orientacion_sexual  =   $data['Orientacion_sexual'];
            $autoridadtradicionalEntry->direccion           =   $data['Direccion'];
            $autoridadtradicionalEntry->telefono            =   $data['Telefono'];
            $autoridadtradicionalEntry->estado              =   $data['Estado'];
            $autoridadtradicionalEntry->fecha_nacimiento    =   $data['Fecha_nacimiento'];
            $autoridadtradicionalEntry->fecha_ingreso       =   $data['Fecha_ingreso'];
            $autoridadtradicionalEntry->save();

            $responseMessage = array('msg' 
                            => "La autoridad tradicional Guardada correctamente",'id' 
                            => $autoridadtradicionalEntry->id);

        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }

        public function estadoAutoridaTradiciona(Request $request,Response $response,$Id)
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
            $autoridadtradicionalEntry = AutoridadtradicionalEntry::find($Id);
            $autoridadtradicionalEntry->estado =  $data['Estado'];
            $autoridadtradicionalEntry->save();

            $responseMessage = array('msg' 
                            => "La autoridad tradicional Guardada correctamente",'id' 
                            => $autoridadtradicionalEntry->id);

        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }

    
     /* DESDE AQUI SE PROCESO EL CRUED DE LA TABLA MIEMBRO CONCEJO COMUNITARIO */
    public function viewMiembrosConcejo(Response $response)
    {
        $ConcejosmiembrosEntry = concejosmiembrosEntry::select(
            "tbl_autoridad_tradicional.id_conncejo_comunitario",
            "tbl_autoridad_tradicional.id_barrio_vereda",
            "tbl_autoridad_tradicional.id_corregimiento",
            "tbl_autoridad_tradicional.id_tipo_documento",
            "tbl_autoridad_tradicional.documentos",
            "tbl_autoridad_tradicional.nombres",
            "tbl_autoridad_tradicional.apellidos",
            "tbl_autoridad_tradicional.sexo",
            "tbl_autoridad_tradicional.genero",
            "tbl_autoridad_tradicional.orientacion_sexual",
            "tbl_autoridad_tradicional.direccion",
            "tbl_autoridad_tradicional.telefono",
            "tbl_autoridad_tradicional.estado",
            "tbl_autoridad_tradicional.fecha_nacimiento",
            "tbl_autoridad_tradicional.fecha_ingreso",
            "tbl_tipo_documento.Nombre as Tipo_documento",
            "tbl_veredas_barrios.Nombre as Veredas_Barrios",
            "tbl_corregimiento.Nombre as Corregimiento",
         )->join(
                "tbl_veredas_barrios", 
                "tbl_autoridad_tradicional.id_barrio_vereda","=","tbl_veredas_barrios.ID")
          ->join(
                "tbl_corregimiento", 
                "tbl_autoridad_tradicional.id_corregimiento","=","tbl_corregimiento.ID")
          ->join(
                "tbl_tipo_documento", 
                "tbl_autoridad_tradicional.id_tipo_documento","=","tbl_tipo_documento.ID")->get();
        return $this->customResponse->is200Response($response,$ConcejosmiembrosEntry);
    }
     
public function viewMiembrosConcejoId(Response $response,$Id)
    {
        $ConcejosmiembrosEntry = concejosmiembrosEntry::select(
            "tbl_autoridad_tradicional.id_conncejo_comunitario",
            "tbl_autoridad_tradicional.id_barrio_vereda",
            "tbl_autoridad_tradicional.id_corregimiento",
            "tbl_autoridad_tradicional.id_tipo_documento",
            "tbl_autoridad_tradicional.documentos",
            "tbl_autoridad_tradicional.nombres",
            "tbl_autoridad_tradicional.apellidos",
            "tbl_autoridad_tradicional.sexo",
            "tbl_autoridad_tradicional.genero",
            "tbl_autoridad_tradicional.orientacion_sexual",
            "tbl_autoridad_tradicional.direccion",
            "tbl_autoridad_tradicional.telefono",
            "tbl_autoridad_tradicional.estado",
            "tbl_autoridad_tradicional.fecha_nacimiento",
            "tbl_autoridad_tradicional.fecha_ingreso",
            "tbl_tipo_documento.Nombre as Tipo_documento",
            "tbl_veredas_barrios.Nombre as Veredas_Barrios",
            "tbl_corregimiento.Nombre as Corregimiento",
         )->join(
                "tbl_veredas_barrios", 
                "tbl_autoridad_tradicional.id_barrio_vereda","=","tbl_veredas_barrios.ID")
          ->join(
                "tbl_corregimiento", 
                "tbl_autoridad_tradicional.id_corregimiento","=","tbl_corregimiento.ID")
          ->join(
                "tbl_tipo_documento", 
                "tbl_autoridad_tradicional.id_tipo_documento","=","tbl_tipo_documento.ID")
          ->where("ID","=",$Id)->get();
        return $this->customResponse->is200Response($response,$ConcejosmiembrosEntry);
    }
public function deleteMiembrosConcejo(Response $response,$Id)
    {
        $this->concejosmiembrosEntry->where(["ID"=>$Id])->delete();
        $responseMessage = "El miembro fue eliminado successfully";
        return $this->customResponse->is200Response($response,$responseMessage);
    }

    public function createMiembrosConcejo(Request $request,Response $response)
    {
       $data = json_decode($request->getBody(),true);
       $this->validator->validate($request,[
            "Id_conncejo_comunitario" =>v::notEmpty(),
            "Id_barrio_vereda" =>v::notEmpty(),
            "Id_corregimiento" =>v::notEmpty(),
            "Id_tipo_documento" =>v::notEmpty(),
            "Documentos" =>v::notEmpty(),
            "Nombres" =>v::notEmpty(),
            "Apellidos" =>v::notEmpty(),
            "Sexo" =>v::notEmpty(),
            "Genero" =>v::notEmpty(),
            "Orientacion_sexual" =>v::notEmpty(),
            "Direccion" =>v::notEmpty(),
            "Telefono" =>v::notEmpty(),
            "Estado" =>v::notEmpty(),
            "Fecha_nacimiento" =>v::notEmpty(),
            "Fecha_ingreso" =>v::notEmpty(),
         ]); 

     if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       } 

        try{
            $concejosmiembrosEntry = new ConcejosmiembrosEntry;
            $concejosmiembrosEntry->id_conncejo_comunitario =   $data['Id_conncejo_comunitario'];
            $concejosmiembrosEntry->id_barrio_vereda    =   $data['Id_barrio_vereda'];
            $concejosmiembrosEntry->id_corregimiento    =   $data['Id_corregimiento'];
            $concejosmiembrosEntry->id_tipo_documento   =   $data['Id_tipo_documento'];
            $concejosmiembrosEntry->documentos          =   $data['Documentos'];
            $concejosmiembrosEntry->nombres             =   $data['Nombres'];
            $concejosmiembrosEntry->apellidos           =   $data['Apellidos'];
            $concejosmiembrosEntry->sexo                =   $data['Sexo'];
            $concejosmiembrosEntry->genero              =   $data['Genero'];
            $concejosmiembrosEntry->orientacion_sexual  =   $data['Orientacion_sexual'];
            $concejosmiembrosEntry->direccion           =   $data['Direccion'];
            $concejosmiembrosEntry->telefono            =   $data['Telefono'];
            $concejosmiembrosEntry->estado              =   $data['Estado'];
            $concejosmiembrosEntry->fecha_nacimiento    =   $data['Fecha_nacimiento'];
            $concejosmiembrosEntry->fecha_ingreso       =   $data['Fecha_ingreso'];
            $concejosmiembrosEntry->save();

            $responseMessage = array('msg' 
                            => "La autoridad tradicional Guardada correctamente",'id' 
                            => $concejosmiembrosEntry->id);

        return $this->customResponse->is201Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }

    public function editMiembrosConcejo(Request $request,Response $response,$Id)
    {
       $data = json_decode($request->getBody(),true);
       $this->validator->validate($request,[
            "Id_conncejo_comunitario" =>v::notEmpty(),
            "Id_barrio_vereda" =>v::notEmpty(),
            "Id_corregimiento" =>v::notEmpty(),
            "Id_tipo_documento" =>v::notEmpty(),
            "Documentos" =>v::notEmpty(),
            "Nombres" =>v::notEmpty(),
            "Apellidos" =>v::notEmpty(),
            "Sexo" =>v::notEmpty(),
            "Genero" =>v::notEmpty(),
            "Orientacion_sexual" =>v::notEmpty(),
            "Direccion" =>v::notEmpty(),
            "Telefono" =>v::notEmpty(),
            "Estado" =>v::notEmpty(),
            "Fecha_nacimiento" =>v::notEmpty(),
            "Fecha_ingreso" =>v::notEmpty(),
         ]); 

     if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       } 

        try{
            $concejosmiembrosEntry = ConcejosmiembrosEntry::find($Id);
            $concejosmiembrosEntry->id_conncejo_comunitario =   $data['Id_conncejo_comunitario'];
            $concejosmiembrosEntry->id_barrio_vereda    =   $data['Id_barrio_vereda'];
            $concejosmiembrosEntry->id_corregimiento    =   $data['Id_corregimiento'];
            $concejosmiembrosEntry->id_tipo_documento   =   $data['Id_tipo_documento'];
            $concejosmiembrosEntry->documentos          =   $data['Documentos'];
            $concejosmiembrosEntry->nombres             =   $data['Nombres'];
            $concejosmiembrosEntry->apellidos           =   $data['Apellidos'];
            $concejosmiembrosEntry->sexo                =   $data['Sexo'];
            $concejosmiembrosEntry->genero              =   $data['Genero'];
            $concejosmiembrosEntry->orientacion_sexual  =   $data['Orientacion_sexual'];
            $concejosmiembrosEntry->direccion           =   $data['Direccion'];
            $concejosmiembrosEntry->telefono            =   $data['Telefono'];
            $concejosmiembrosEntry->estado              =   $data['Estado'];
            $concejosmiembrosEntry->fecha_nacimiento    =   $data['Fecha_nacimiento'];
            $concejosmiembrosEntry->fecha_ingreso       =   $data['Fecha_ingreso'];
            $concejosmiembrosEntry->save();

            $responseMessage = array('msg' 
                            => "La autoridad tradicional Guardada correctamente",'id' 
                            => $concejosmiembrosEntry->id);

        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }


    public function estadoMiembrosConcejo(Request $request,Response $response,$Id)
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
            $concejosmiembrosEntry = ConcejosmiembrosEntry::find($Id);
            $concejosmiembrosEntry->estado =   $data['Estado'];
            $concejosmiembrosEntry->save();

            $responseMessage = array('msg' 
                            => "el Miembro cambio estado correctamente",'id' 
                            => $concejosmiembrosEntry->id);

        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }








}