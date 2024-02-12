<?php
namespace  App\Controllers;
use App\Models\JefeHogarEntry;
use App\Models\NucleoFamiliarEntry;

use App\Response\CustomResponse;
use App\Validation\Validator;
use Respect\Validation\Exceptions\Exception;
use Respect\Validation\Validator as v;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class GrupoFamiliarController {

    protected $customResponse;

    protected $jefeHogarEntry;

    protected $nucleoFamiliarEntry;

    protected $validator;

    public function __construct()
    {
    $this->customResponse = new CustomResponse();
    $this->jefeHogarEntry = new JefeHogarEntry();
    $this->nucleoFamiliarEntry = new NucleoFamiliarEntry();
    $this->validator = new Validator();
    }
     /* DESDE AQUI SE PROCESAN CONSULTAS JEFE DE HOGAR */
public function consultaJefeHogar($Id)
{
 $data = jefeHogarEntry::select(
            "tbl_jefe_hogar.*",
            "tbl_conncejos_comunitarios.Nombre_concejo_comunitario as Concejo_Comunitario",
            "tbl_municipio.Nombre as Municipio",
            "tbl_tipo_documento.Nombre as Tipo_documento",
            "tbl_veredas_barrios.Nombre as Veredas_Barrios",
            "tbl_corregimiento.Nombre as Corregimiento",
            "tbl_escolaridad.Nombre as Escolaridad",
         )->join(
                "tbl_conncejos_comunitarios", 
                "tbl_jefe_hogar.id_concejo_comunitario","=","tbl_conncejos_comunitarios.ID")
          ->join(
                "tbl_municipio", 
                "tbl_jefe_hogar.Id_municipio","=","tbl_municipio.ID")
          ->join(
                "tbl_veredas_barrios", 
                "tbl_jefe_hogar.id_barrio_vereda","=","tbl_veredas_barrios.ID")
          ->join(
                "tbl_corregimiento", 
                "tbl_jefe_hogar.id_corregimiento","=","tbl_corregimiento.ID")
          ->join(
                "tbl_tipo_documento", 
                "tbl_jefe_hogar.id_tipo_documento","=","tbl_tipo_documento.ID")
          ->join(
                "tbl_escolaridad", 
                "tbl_jefe_hogar.id_escolaridad","=","tbl_escolaridad.ID")
          ->join(
                "tbl_orientacion_sexual", 
                "tbl_jefe_hogar.id_orientacion_sexual","=","tbl_orientacion_sexual.ID")      
          ->where("tbl_jefe_hogar.ID","=",$Id)->first();

        return $data;

}
public function consultaNucleFamiliar($Id)
{
 $data = nucleoFamiliarEntry::select(
            "tbl_nucleo_familiar.*",
            "tbl_jefe_hogar.ID as ID_jefehogar",
            "tbl_jefe_hogar.nombres as Nombres_jefehogar",
            "tbl_jefe_hogar.apellidos as Apellidos_jefehogar",
            "tbl_parentesco.Nombre as Parentesco",
            "tbl_tipo_documento.Nombre as Tipo_documento",
            "tbl_veredas_barrios.Nombre as Veredas_Barrios",
            "tbl_corregimiento.Nombre as Corregimiento",
            "tbl_escolaridad.Nombre as Escolaridad",
         )->join(
                "tbl_jefe_hogar", 
                "tbl_nucleo_familiar.id_jefe_hogar","=","tbl_jefe_hogar.ID")
          ->join(
                "tbl_parentesco", 
                "tbl_nucleo_familiar.id_parentesco","=","tbl_parentesco.ID")
          ->join(
                "tbl_veredas_barrios", 
                "tbl_nucleo_familiar.id_barrio_vereda","=","tbl_veredas_barrios.ID")
          ->join(
                "tbl_corregimiento", 
                "tbl_nucleo_familiar.id_corregimiento","=","tbl_corregimiento.ID")
          ->join(
                "tbl_tipo_documento", 
                "tbl_nucleo_familiar.id_tipo_documento","=","tbl_tipo_documento.ID")
          ->join(
                "tbl_escolaridad", 
                "tbl_nucleo_familiar.id_escolaridad","=","tbl_escolaridad.ID")
          ->join(
                "tbl_orientacion_sexual", 
                "tbl_jefe_hogar.id_orientacion_sexual","=","tbl_orientacion_sexual.ID")      
          ->where("tbl_nucleo_familiar.ID","=",$Id)->first();
return $data;
}

      /* DESDE AQUI SE PROCESO EL CRUE DE LA TABLA JEFE DE HOGAR */
    public function viewJefeHogar(Response $response)
    {
           $JefeHogarEntry = jefeHogarEntry::select(
            "tbl_jefe_hogar.*",
            "tbl_conncejos_comunitarios.Nombre_concejo_comunitario as Concejo_Comunitario",
            "tbl_municipio.Nombre as Municipio",
            "tbl_tipo_documento.Nombre as Tipo_documento",
            "tbl_veredas_barrios.Nombre as Veredas_Barrios",
            "tbl_corregimiento.Nombre as Corregimiento",
            "tbl_escolaridad.Nombre as Escolaridad",
         )->join(
                "tbl_conncejos_comunitarios", 
                "tbl_jefe_hogar.id_concejo_comunitario","=","tbl_conncejos_comunitarios.ID")
          ->join(
                "tbl_municipio", 
                "tbl_jefe_hogar.Id_municipio","=","tbl_municipio.ID")
          ->join(
                "tbl_veredas_barrios", 
                "tbl_jefe_hogar.id_barrio_vereda","=","tbl_veredas_barrios.ID")
          ->join(
                "tbl_corregimiento", 
                "tbl_jefe_hogar.id_corregimiento","=","tbl_corregimiento.ID")
          ->join(
                "tbl_tipo_documento", 
                "tbl_jefe_hogar.id_tipo_documento","=","tbl_tipo_documento.ID")
          ->join(
                "tbl_escolaridad", 
                "tbl_jefe_hogar.id_escolaridad","=","tbl_escolaridad.ID")
           ->join(
                "tbl_orientacion_sexual", 
                "tbl_jefe_hogar.id_orientacion_sexual","=","tbl_orientacion_sexual.ID")      
            ->get();

        return $this->customResponse->is200Response($response,$JefeHogarEntry); 
}

    public function viewJefeHogarId(Response $response,$Id)
    {
        $JefeHogarEntry = $this-> consultaJefeHogar($Id);
        return $this->customResponse->is200Response($response,$JefeHogarEntry);
    }

public function deleteJefeHogar(Response $response,$Id)
{
        $this->jefeHogarEntry->where(["ID"=>$Id])->delete();
        $responseMessage = "El jefe DE hogar fue eliminado successfully";  
        return $this->customResponse->is200Response($response,$responseMessage);
}
     public function createJefeHogar(Request $request,Response $response)
    {
       $data = json_decode($request->getBody(),true);
       $this->validator->validate($request,[
            "Id_concejo_comunitario" =>v::notEmpty(),
            "Id_municipio" =>v::notEmpty(),
            "Id_barrio_vereda" =>v::notEmpty(),
            "Id_corregimiento" =>v::notEmpty(),
            "Id_tipo_documento" =>v::notEmpty(),           
            "Id_escolaridad" =>v::notEmpty(),
            "Id_orientacion_sexual" =>v::notEmpty(),
            "Documentos" =>v::notEmpty(),
            "Nombres " =>v::notEmpty(),
            "Apellidos" =>v::notEmpty(),
            "Estado_escolaridad" =>v::notEmpty(),
            "Sexo" =>v::notEmpty(),
            "Genero" =>v::notEmpty(),
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
        $jefeHogarEntry = new JefeHogarEntry;
       	$jefeHogarEntry->id_concejo_comunitario  = $data['Id_concejo_comunitario'];
        $jefeHogarEntry->id_municipio            = $data['Id_municipio'];
        $jefeHogarEntry->id_barrio_vereda        = $data['Id_barrio_vereda'];
        $jefeHogarEntry->id_corregimiento        = $data['Id_corregimiento'];
        $jefeHogarEntry->id_tipo_documento       = $data['Id_tipo_documento'];
        $jefeHogarEntry->id_escolaridad          = $data['Id_escolaridad'];
        $jefeHogarEntry->id_orientacion_sexual   = $data['Id_orientacion_sexual'];
        $jefeHogarEntry->documentos              = $data['Documentos'];
        $jefeHogarEntry->nombres                 = $data['Nombres'];
        $jefeHogarEntry->apellidos               = $data['Apellidos'];
        $jefeHogarEntry->estado_escolaridad      = $data['Estado_escolaridad'];
        $jefeHogarEntry->sexo                    = $data['Sexo'];
        $jefeHogarEntry->genero                  = $data['Genero'];
        $jefeHogarEntry->direccion               = $data['Direccion'];
        $jefeHogarEntry->telefono                = $data['Telefono'];
        $jefeHogarEntry->estado                  = $data['Estado'];
        $jefeHogarEntry->fecha_nacimiento        = $data['Fecha_nacimiento'];
        $jefeHogarEntry->fecha_ingreso           = $data['Fecha_ingreso'];

        $responseMessage = array('msg' => "Jefe de hogar Guardado correctamente",
                                 'datos' =>  $this->consultaJefeHogar($jefeHogarEntry->id),
                                 'id' => $jefeHogarEntry->id);

        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
   }


public function editarJefeHogar(Request $request,Response $response,$id)
    {
       $data = json_decode($request->getBody(),true);
       $this->validator->validate($request,[
            "Id_concejo_comunitario" =>v::notEmpty(),
            "Id_municipio" =>v::notEmpty(),
            "Id_barrio_vereda" =>v::notEmpty(),
            "Id_corregimiento" =>v::notEmpty(),
            "Id_tipo_documento" =>v::notEmpty(),           
            "Id_escolaridad" =>v::notEmpty(),
            "Id_orientacion_sexual" =>v::notEmpty(),
            "Documentos" =>v::notEmpty(),
            "Nombres " =>v::notEmpty(),
            "Apellidos" =>v::notEmpty(),
            "Estado_escolaridad" =>v::notEmpty(),
            "Sexo" =>v::notEmpty(),
            "Genero" =>v::notEmpty(),
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
        $jefeHogarEntry = JefeHogarEntry::find($id);
       	$jefeHogarEntry->id_concejo_comunitario  = $data['Id_concejo_comunitario'];
        $jefeHogarEntry->id_municipio            = $data['Id_municipio'];
        $jefeHogarEntry->id_barrio_vereda        = $data['Id_barrio_vereda'];
        $jefeHogarEntry->id_corregimiento        = $data['Id_corregimiento'];
        $jefeHogarEntry->id_tipo_documento       = $data['Id_tipo_documento'];
        $jefeHogarEntry->id_escolaridad          = $data['Id_escolaridad'];
        $jefeHogarEntry->id_orientacion_sexual   = $data['Id_orientacion_sexual'];
        $jefeHogarEntry->documentos              = $data['Documentos'];
        $jefeHogarEntry->nombres                 = $data['Nombres'];
        $jefeHogarEntry->apellidos               = $data['Apellidos'];
        $jefeHogarEntry->estado_escolaridad      = $data['Estado_escolaridad'];
        $jefeHogarEntry->sexo                    = $data['Sexo'];
        $jefeHogarEntry->genero                  = $data['Genero'];
        $jefeHogarEntry->direccion               = $data['Direccion'];
        $jefeHogarEntry->telefono                = $data['Telefono'];
        $jefeHogarEntry->estado                  = $data['Estado'];
        $jefeHogarEntry->fecha_nacimiento        = $data['Fecha_nacimiento'];
        $jefeHogarEntry->fecha_ingreso           = $data['Fecha_ingreso'];

        $responseMessage = array('msg' => "Jefe de hogar Guardado correctamente",
                                 'datos' =>  $this->consultaJefeHogar($id),
                                 'id' => $jefeHogarEntry->id);

        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
   }

public function estadoJefeHogar(Request $request,Response $response, $Id)
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
      $jefeHogarEntry = JefeHogarEntry::find($Id);
      $jefeHogarEntry->estado         =   $data['Estado'];
      $jefeHogarEntry->save();
      $responseMessage = array('msg' => "Estado Jefe de Hogar ha cambiado correctamente",
                                'id' => $jefeHogarEntry->id);
      return $this->customResponse->is200Response($response,$responseMessage);
      }catch(Exception $err){
      $responseMessage = array("err" => $err->getMessage());
      return $this->customResponse->is400Response($response,$responseMessage);
     }
 }

       /* DESDE AQUI SE PROCESO EL CRUE DE LA TABLA NUCLEO FAMIIAR */
    public function viewNucleoFamiliar(Response $response)
    {
   $getNucleoFamiliar = nucleoFamiliarEntry::select(
            "tbl_nucleo_familiar.*",
            "tbl_jefe_hogar.ID as ID_jefehogar",
            "tbl_jefe_hogar.nombres as Nombres_jefehogar",
            "tbl_jefe_hogar.apellidos as Apellidos_jefehogar",
            "tbl_parentesco.Nombre as Parentesco",
            "tbl_tipo_documento.Nombre as Tipo_documento",
            "tbl_veredas_barrios.Nombre as Veredas_Barrios",
            "tbl_corregimiento.Nombre as Corregimiento",
            "tbl_escolaridad.Nombre as Escolaridad",
         )->join(
                "tbl_jefe_hogar", 
                "tbl_nucleo_familiar.id_jefe_hogar","=","tbl_jefe_hogar.ID")
          ->join(
                "tbl_parentesco", 
                "tbl_nucleo_familiar.id_parentesco","=","tbl_parentesco.ID")
          ->join(
                "tbl_veredas_barrios", 
                "tbl_nucleo_familiar.id_barrio_vereda","=","tbl_veredas_barrios.ID")
          ->join(
                "tbl_corregimiento", 
                "tbl_nucleo_familiar.id_corregimiento","=","tbl_corregimiento.ID")
          ->join(
                "tbl_tipo_documento", 
                "tbl_nucleo_familiar.id_tipo_documento","=","tbl_tipo_documento.ID")
          ->join(
                "tbl_escolaridad", 
                "tbl_nucleo_familiar.id_escolaridad","=","tbl_escolaridad.ID")
          ->join(
                "tbl_orientacion_sexual", 
                "tbl_jefe_hogar.id_orientacion_sexual","=","tbl_orientacion_sexual.ID")      
          ->get();
        return $this->customResponse->is200Response($response,$getNucleoFamiliar); 
    }
 public function viewNucleoFamiliarId(Response $response,$Id)
{
        $getNucleoFamiliar = $this-> consultaNucleFamiliar($Id);
        return $this->customResponse->is200Response($response,$getNucleoFamiliar);
}
public function deleteNucleoFamiliar(Response $response,$Id)
{
        $this->nucleoFamiliarEntry->where(["ID"=>$Id])->delete();
        $responseMessage = "El miembro nucleo familiar fue eliminado successfully";  
        return $this->customResponse->is200Response($response,$responseMessage);
}

public function createNucleoFamiliar(Request $request,Response $response)
{
   $data = json_decode($request->getBody(),true);
       $this->validator->validate($request,[
            "Id_jefe_hogar" =>v::notEmpty(),
            "Id_parentesco" =>v::notEmpty(),
            "Id_barrio_vereda" =>v::notEmpty(),
            "Id_corregimiento" =>v::notEmpty(),
            "Id_tipo_documento" =>v::notEmpty(),           
            "Id_escolaridad" =>v::notEmpty(),
            "Id_orientacion_sexual" =>v::notEmpty(),
            "Documentos" =>v::notEmpty(),
            "Nombres " =>v::notEmpty(),
            "Apellidos" =>v::notEmpty(),
            "Estado_escolaridad" =>v::notEmpty(),
            "Sexo" =>v::notEmpty(),
            "Genero" =>v::notEmpty(),
            "Fecha_nacimiento" =>v::notEmpty(),
         ]); 

        if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       } 

        try{
        $nucleoFamiliarEntry = new NucleoFamiliarEntry;
       	$nucleoFamiliarEntry->id_jefe_hogar           = $data['Id_jefe_hogar'];
        $nucleoFamiliarEntry->id_parentesco           = $data['Id_parentesco'];
        $nucleoFamiliarEntry->id_barrio_vereda        = $data['Id_barrio_vereda'];
        $nucleoFamiliarEntry->id_corregimiento        = $data['Id_corregimiento'];
        $nucleoFamiliarEntry->id_tipo_documento       = $data['Id_tipo_documento'];
        $nucleoFamiliarEntry->id_escolaridad          = $data['Id_escolaridad'];
        $nucleoFamiliarEntry->id_orientacion_sexual   = $data['Id_orientacion_sexual'];
        $nucleoFamiliarEntry->documentos              = $data['Documentos'];
        $nucleoFamiliarEntry->nombres                 = $data['Nombres'];
        $nucleoFamiliarEntry->apellidos               = $data['Apellidos'];
        $nucleoFamiliarEntry->estado_escolaridad      = $data['Estado_escolaridad'];
        $nucleoFamiliarEntry->sexo                    = $data['Sexo'];
        $nucleoFamiliarEntry->genero                  = $data['Genero'];
        $nucleoFamiliarEntry->fecha_nacimiento        = $data['Fecha_nacimiento'];
        $nucleoFamiliarEntry->fecha_ingreso           = $data['Fecha_ingreso'];

        $responseMessage = array('msg' => "Nucleo famiiar Guardado correctamente",
                                 'datos' =>  $this->consultaNucleFamiliar($nucleoFamiliarEntry->id),
                                 'id' => $nucleoFamiliarEntry->id);

        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
  }
  public function editarNucleoFamiliar(Request $request,Response $response,$Id)
  {
   $data = json_decode($request->getBody(),true);
       $this->validator->validate($request,[
            "Id_jefe_hogar" =>v::notEmpty(),
            "Id_parentesco" =>v::notEmpty(),
            "Id_barrio_vereda" =>v::notEmpty(),
            "Id_corregimiento" =>v::notEmpty(),
            "Id_tipo_documento" =>v::notEmpty(),           
            "Id_escolaridad" =>v::notEmpty(),
            "Id_orientacion_sexual" =>v::notEmpty(),
            "Documentos" =>v::notEmpty(),
            "Nombres " =>v::notEmpty(),
            "Apellidos" =>v::notEmpty(),
            "Estado_escolaridad" =>v::notEmpty(),
            "Sexo" =>v::notEmpty(),
            "Genero" =>v::notEmpty(),
            "Fecha_nacimiento" =>v::notEmpty(),
         ]); 

        if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       } 

        try{
        $nucleoFamiliarEntry = NucleoFamiliarEntry::find($Id);
       	$nucleoFamiliarEntry->id_jefe_hogar           = $data['Id_jefe_hogar'];
        $nucleoFamiliarEntry->id_parentesco           = $data['Id_parentesco'];
        $nucleoFamiliarEntry->id_barrio_vereda        = $data['Id_barrio_vereda'];
        $nucleoFamiliarEntry->id_corregimiento        = $data['Id_corregimiento'];
        $nucleoFamiliarEntry->id_tipo_documento       = $data['Id_tipo_documento'];
        $nucleoFamiliarEntry->id_escolaridad          = $data['Id_escolaridad'];
        $nucleoFamiliarEntry->id_orientacion_sexual   = $data['Id_orientacion_sexual'];
        $nucleoFamiliarEntry->documentos              = $data['Documentos'];
        $nucleoFamiliarEntry->nombres                 = $data['Nombres'];
        $nucleoFamiliarEntry->apellidos               = $data['Apellidos'];
        $nucleoFamiliarEntry->estado_escolaridad      = $data['Estado_escolaridad'];
        $nucleoFamiliarEntry->sexo                    = $data['Sexo'];
        $nucleoFamiliarEntry->genero                  = $data['Genero'];
        $nucleoFamiliarEntry->fecha_nacimiento        = $data['Fecha_nacimiento'];
        $nucleoFamiliarEntry->fecha_ingreso           = $data['Fecha_ingreso'];

        $responseMessage = array('msg' => "Nucleo famiiar Guardado correctamente",
                                 'datos' =>  $this->consultaNucleFamiliar($Id),
                                 'id' => $nucleoFamiliarEntry->id);

        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
  }
}