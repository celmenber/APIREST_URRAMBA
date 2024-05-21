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

public function verifyAccountDocjefeHogar($Document)
{
        $count = $this->jefeHogarEntry->where(["documentos"=>$Document])->count();
            if($count == 0)
            {
                return false;
            }

return true;
}

public function verifyAccountDocjefeHogaredit($Document,$Id)
{
    $Miembro = $this->jefeHogarEntry->where(["ID"=>$Id])->first();

    if($Miembro->documentos == $Document){
            return false;
        }else{
            $count = $this->jefeHogarEntry->where(["documentos"=>$Document])->count();
                    if($count == 0)
                      {
                        return false;
                      }
             return true;   
          }
}

public function verifyAccountDocNucleoFamilia($Document)
{
        $count = $this->nucleoFamiliarEntry->where(["documentos"=>$Document])->count();
            if($count == 0)
            {
                return false;
            }

return true;
}

public function verifyAccountDocNucleoFamiliaedit($Document,$Id)
{
    $Miembro = $this->nucleoFamiliarEntry->where(["ID"=>$Id])->first();

    if($Miembro->documentos == $Document){
            return false;
     }else{
            $count = $this->nucleoFamiliarEntry->where(["documentos"=>$Document])->count();
                    if($count == 0)
                      {
                        return false;
                      }
           return true;   
      }
}
     /* DESDE AQUI SE PROCESAN CONSULTAS JEFE DE HOGAR */

public function consultaJefeHogarCed($param)
{
 $data = jefeHogarEntry::select(
            "tbl_jefe_hogar.*",
            "tbl_conncejos_comunitarios.Nombre_concejo_comunitario as Concejo_Comunitario",
            "tbl_tipo_documento.Nombre as Tipo_documento",
            "tbl_veredas_barrios.Nombre as Veredas_Barrios",
            "tbl_corregimiento.Nombre as Corregimiento",
            "tbl_escolaridad.Nombre as Escolaridad",
             "tbl_orientacion_sexual.Nombre as Orientacion_sexual"
         )->join(
                "tbl_conncejos_comunitarios", 
                "tbl_jefe_hogar.id_concejo_comunitario","=","tbl_conncejos_comunitarios.ID")
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
          
           ->where("tbl_jefe_hogar.documentos","like",'%'.$param.'%')->get();

        return $data;
}

public function consultaJefeHogar($Id)
{
 $data = jefeHogarEntry::select(
            "tbl_jefe_hogar.*",
            "tbl_conncejos_comunitarios.Nombre_concejo_comunitario as Concejo_Comunitario",
            "tbl_tipo_documento.Nombre as Tipo_documento",
            "tbl_veredas_barrios.Nombre as Veredas_Barrios",
            "tbl_corregimiento.Nombre as Corregimiento",
            "tbl_escolaridad.Nombre as Escolaridad",
            "tbl_orientacion_sexual.Nombre as Orientacion_sexual",
         )->join(
                "tbl_conncejos_comunitarios", 
                "tbl_jefe_hogar.id_concejo_comunitario","=","tbl_conncejos_comunitarios.ID")
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

public function consultaNucleFamiliar()
    {
            $data = nucleoFamiliarEntry::select(
                        "tbl_nucleo_familiar.*",
                        "tbl_jefe_hogar.ID as ID_jefehogar",
                        "tbl_parentesco.Nombre as Parentesco",
                        "tbl_tipo_documento.Nombre as Tipo_documento",
                        "tbl_escolaridad.Nombre as Escolaridad",
                        "tbl_orientacion_sexual.Nombre as Orientacion_sexual",
                  )->join(
                        "tbl_jefe_hogar", 
                        "tbl_nucleo_familiar.id_jefe_hogar","=","tbl_jefe_hogar.ID")
                  ->join(
                        "tbl_parentesco", 
                        "tbl_nucleo_familiar.id_parentesco","=","tbl_parentesco.ID")
                  ->join(
                        "tbl_tipo_documento", 
                        "tbl_nucleo_familiar.id_tipo_documento","=","tbl_tipo_documento.ID")
                  ->join(
                        "tbl_escolaridad", 
                        "tbl_nucleo_familiar.id_escolaridad","=","tbl_escolaridad.ID")
                  ->join(
                        "tbl_orientacion_sexual", 
                        "tbl_nucleo_familiar.id_orientacion_sexual","=","tbl_orientacion_sexual.ID")      
                  ->get();
        return  $data; 
    }

public function consultaNucleFamiliarId($Id)
{
 $data = nucleoFamiliarEntry::select(
            "tbl_nucleo_familiar.*",
            "tbl_jefe_hogar.ID as ID_jefehogar",
            "tbl_parentesco.Nombre as Parentesco",
            "tbl_tipo_documento.Nombre as Tipo_documento",
            "tbl_escolaridad.Nombre as Escolaridad",
            "tbl_orientacion_sexual.Nombre as Orientacion_sexual",
         )->join(
                "tbl_jefe_hogar", 
                "tbl_nucleo_familiar.id_jefe_hogar","=","tbl_jefe_hogar.ID")
          ->join(
                "tbl_parentesco", 
                "tbl_nucleo_familiar.id_parentesco","=","tbl_parentesco.ID")
          ->join(
                "tbl_tipo_documento", 
                "tbl_nucleo_familiar.id_tipo_documento","=","tbl_tipo_documento.ID")
          ->join(
                "tbl_escolaridad", 
                "tbl_nucleo_familiar.id_escolaridad","=","tbl_escolaridad.ID")
          ->join(
                "tbl_orientacion_sexual", 
                "tbl_nucleo_familiar.id_orientacion_sexual","=","tbl_orientacion_sexual.ID")      
          ->where("tbl_nucleo_familiar.ID","=",$Id)->first();
return $data;
}

      /* DESDE AQUI SE PROCESO EL CRUE DE LA TABLA JEFE DE HOGAR */
    public function viewJefeHogar(Response $response)
    {
           $JefeHogarEntry = jefeHogarEntry::select(
            "tbl_jefe_hogar.*",
            "tbl_conncejos_comunitarios.Nombre_concejo_comunitario as Concejo_Comunitario",
            "tbl_tipo_documento.Nombre as Tipo_documento",
            "tbl_veredas_barrios.Nombre as Veredas_Barrios",
            "tbl_corregimiento.Nombre as Corregimiento",
            "tbl_escolaridad.Nombre as Escolaridad",
            "tbl_orientacion_sexual.Nombre as Orientacion_sexual",
         )->join(
                "tbl_conncejos_comunitarios", 
                "tbl_jefe_hogar.id_concejo_comunitario","=","tbl_conncejos_comunitarios.ID")
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
        $JefeHogarEntry = $this->consultaJefeHogar($Id);
        return $this->customResponse->is200Response($response,$JefeHogarEntry);
}

public function viewJefeHogarDocuments(Response $response,$Doc)
{
        $JefeHogarEntry = $this->consultaJefeHogarCed($Doc);
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
            //"Id_municipio" =>v::notEmpty(),
            "Id_usuario" =>v::notEmpty(),
            "Id_barrio_vereda" =>v::notEmpty(),
            "Id_corregimiento" =>v::notEmpty(),
            "Id_tipo_documento" =>v::notEmpty(),           
            "Id_escolaridad" =>v::notEmpty(),
            "Id_orientacion_sexual" =>v::notEmpty(),
            "Documentos" =>v::notEmpty(),
            "Nombres" =>v::notEmpty(),
            "Apellidos" =>v::notEmpty(),
            "Estado_escolaridad" =>v::notEmpty(),
            "Sexo" =>v::notEmpty(),
            "Genero" =>v::notEmpty(),
            "Direccion" =>v::notEmpty(),
            "Telefono" =>v::notEmpty(),
            "Correo" =>v::notEmpty(),
            "Estado" =>v::notOptional(),
            "Fecha_nacimiento" =>v::notEmpty(),
            "Fecha_ingreso" =>v::notEmpty(),
         ]); 

        if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       } 

        $count = $this->verifyAccountDocjefeHogar($data['Documentos']);
                  if($count==true){
                        $responseMessage = "203-1-Información no autorizada Jefe Hogar";
                        return $this->customResponse->is203Response($response,$responseMessage);
                  }

         $count = $this->verifyAccountDocNucleoFamilia($data['Documentos']);
                  if($count==true){
                        $responseMessage = "203-2-Información no autorizada miembro nucleo familiar";
                        return $this->customResponse->is203Response($response,$responseMessage);
                  }

        try{
        $jefeHogarEntry = new JefeHogarEntry;
        $jefeHogarEntry->id_concejo_comunitario  = $data['Id_concejo_comunitario'];
        $jefeHogarEntry->id_usuario              = $data['Id_usuario'];
       // $jefeHogarEntry->id_municipio            = $data['Id_municipio'];
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
        $jefeHogarEntry->correo                  = $data['Correo'];
        $jefeHogarEntry->estado                  = $data['Estado'];
        $jefeHogarEntry->fecha_nacimiento        = $data['Fecha_nacimiento'];
        $jefeHogarEntry->fecha_ingreso           = $data['Fecha_ingreso'];
        $jefeHogarEntry->save();

        $responseMessage = array($this->consultaJefeHogar($jefeHogarEntry->id));

        return $this->customResponse->is201Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
   }


public function editarJefeHogar(Request $request,Response $response,$Id)
    {
       $data = json_decode($request->getBody(),true);
       $this->validator->validate($request,[
            "Id_concejo_comunitario" =>v::notEmpty(),
            "Id_barrio_vereda" =>v::notEmpty(),
            "Id_corregimiento" =>v::notEmpty(),
            "Id_tipo_documento" =>v::notEmpty(),           
            "Id_escolaridad" =>v::notEmpty(),
            "Id_orientacion_sexual" =>v::notEmpty(),
            "Documentos" =>v::notEmpty(),
            "Nombres" =>v::notEmpty(),
            "Apellidos" =>v::notEmpty(),
            "Estado_escolaridad" =>v::notEmpty(),
            "Sexo" =>v::notEmpty(),
            "Genero" =>v::notEmpty(),
            "Direccion" =>v::notEmpty(),
            "Telefono" =>v::notEmpty(),
            "Correo" =>v::notEmpty(),
            "Estado" =>v::notOptional(),
            "Fecha_nacimiento" =>v::notEmpty(),
            "Fecha_ingreso" =>v::notEmpty(),
         ]); 

        if($this->validator->failed())
          {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
         } 

       $count = $this->verifyAccountDocjefeHogaredit($data['Documentos'], $Id);
                        if($count==true){
                              $responseMessage = "203-1-Información no autorizada Jefe Hogar";
                              return $this->customResponse->is203Response($response,$responseMessage);
                        }

       $count = $this->verifyAccountDocNucleoFamilia($data['Documentos']);
                  if($count==true){
                        $responseMessage = "203-2-Información no autorizada miembro nucleo familiar";
                        return $this->customResponse->is203Response($response,$responseMessage);
                  }

        try{
         JefeHogarEntry::where('ID', '=', $Id)->update([
                  'id_concejo_comunitario'  => $data['Id_concejo_comunitario'],
                  'id_barrio_vereda'        => $data['Id_barrio_vereda'],
                  'id_corregimiento'        => $data['Id_corregimiento'],
                  'id_tipo_documento'       => $data['Id_tipo_documento'],
                  'id_escolaridad'          => $data['Id_escolaridad'],
                  'id_orientacion_sexual'   => $data['Id_orientacion_sexual'],
                  'documentos'              => $data['Documentos'],
                  'nombres'                 => $data['Nombres'],
                  'apellidos'               => $data['Apellidos'],
                  'estado_escolaridad'      => $data['Estado_escolaridad'],
                  'sexo'                    => $data['Sexo'],
                  'genero'                  => $data['Genero'],
                  'direccion'               => $data['Direccion'],
                  'telefono'                => $data['Telefono'],
                  'correo'                  => $data['Correo'],
                  'estado'                  => $data['Estado'],
                  'fecha_nacimiento'        => $data['Fecha_nacimiento'],
                  'fecha_ingreso'           => $data['Fecha_ingreso'],
          ]);

        $responseMessage = array($this->consultaJefeHogar($Id));

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
        $getNucleoFamiliar = $this-> consultaNucleFamiliar();
        return $this->customResponse->is200Response($response,$getNucleoFamiliar); 
    }
 public function viewNucleoFamiliarId(Response $response,$Id)
{
        $getNucleoFamiliar = $this-> consultaNucleFamiliarId($Id);
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
            "Id_tipo_documento" =>v::notEmpty(),           
            "Id_escolaridad" =>v::notEmpty(),
            "Id_orientacion_sexual" =>v::notEmpty(),
            "Documentos" =>v::notEmpty(),
            "Nombres" =>v::notEmpty(),
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

       $count = $this->verifyAccountDocNucleoFamilia($data['Documentos']);
        if($count==true){
              $responseMessage = "203-2-Información no autorizada miembro nucleo familiar";
            return $this->customResponse->is203Response($response,$responseMessage);
        }

        $count = $this->verifyAccountDocjefeHogar($data['Documentos']);
        if($count==true){
              $responseMessage = "203-1-Información no autorizada Jefe Hogar";
            return $this->customResponse->is203Response($response,$responseMessage);
        }

        try{
        $nucleoFamiliarEntry = new NucleoFamiliarEntry;
        $nucleoFamiliarEntry->id_jefe_hogar           = $data['Id_jefe_hogar'];
        $nucleoFamiliarEntry->id_parentesco           = $data['Id_parentesco'];
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
        $nucleoFamiliarEntry->save();

        $responseMessage = array($this->consultaNucleFamiliarId($nucleoFamiliarEntry->id));
        return $this->customResponse->is201Response($response,$responseMessage);
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
            "Id_tipo_documento" =>v::notEmpty(),           
            "Id_escolaridad" =>v::notEmpty(),
            "Id_orientacion_sexual" =>v::notEmpty(),
            "Documentos" =>v::notEmpty(),
            "Nombres" =>v::notEmpty(),
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

        $count = $this->verifyAccountDocjefeHogar($data['Documentos']);
        if($count==true){
              $responseMessage = "203-1-Información no autorizada Jefe Hogar";
            return $this->customResponse->is203Response($response,$responseMessage);
        }

      $count = $this->verifyAccountDocNucleoFamiliaedit($data['Documentos'], $Id);
        if($count==true){
              $responseMessage = "203-2-Información no autorizada Jefe Hogar";
            return $this->customResponse->is203Response($response,$responseMessage);
        }

        try{
  NucleoFamiliarEntry::where('ID', '=', $Id)->update([
                              'id_jefe_hogar'         => $data['Id_jefe_hogar'],
                              'id_parentesco'         => $data['Id_parentesco'],
                              'id_tipo_documento'     => $data['Id_tipo_documento'],
                              'id_escolaridad'        => $data['Id_escolaridad'],
                              'id_orientacion_sexual' => $data['Id_orientacion_sexual'],
                              'documentos'            => $data['Documentos'],
                              'nombres'               => $data['Nombres'],
                              'apellidos'             => $data['Apellidos'],
                              'estado_escolaridad'    => $data['Estado_escolaridad'],
                              'sexo'                  => $data['Sexo'],
                              'genero'                => $data['Genero'],
                              'fecha_nacimiento'      => $data['Fecha_nacimiento'],
         ]);

        $responseMessage = array($this->consultaNucleFamiliarId($Id));
        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
  }
  public function trasladoNucleoFamiliar(Request $request,Response $response,$Id)
  {
   $data = json_decode($request->getBody(),true);
      if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       } 

        try{
            NucleoFamiliarEntry::where('ID', '=', $Id)->update([
                                  'id_jefe_hogar' => $data['Id_jefe_hogar'],
                               ]);

        $responseMessage = array($this->consultaNucleFamiliar());
        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
  }

}

