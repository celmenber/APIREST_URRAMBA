<?php
namespace  App\Controllers;
use App\Models\AsociacionEntry;
use App\Models\AsociacionEmpleadoEntry;
use App\Models\UserEntry;

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

    protected $userEntry;

    protected $validator;

    public function __construct()
    {
    $this->customResponse = new CustomResponse();
    $this->asociacionEntry = new AsociacionEntry();
    $this->userEntry = new UserEntry();
    $this->asociacionEmpleadoEntry = new AsociacionEmpleadoEntry();
    $this->validator = new Validator();

    }

/* DESDE AQUI SE PROCESO DE CONSULTAS EJECUCION METODOS */
public function hashPassword($password)
{
    return password_hash($password,PASSWORD_DEFAULT);
}   
public function verifyAccountUsuario($usuario)
{
        $count = $this->userEntry->where(["USERNAME"=>$usuario])->count();
            if($count == 0)
            {
                return false;
            }

return true;
}
public function verifyAccountNit($Nit)
{
        $count = $this->asociacionEntry->where(["nit"=>$Nit])->count();
            if($count == 0)
            {
                return false;
            }

return true;
}

public function verifyAccountNitEdit($Nit,$Id)
{
    $asociacion = $this->asociacionEntry->where(["ID"=>$Id])->first();

    if($asociacion->nit == $Nit){
            return false;
     }else{
            $count = $this->asociacionEntry->where(["nit"=>$Nit])->count();
                    if($count == 0)
                      {
                        return false;
                      }
           return true;   
      }
}


public function verifyAccountDoc($Document)
{
        $count = $this->asociacionEmpleadoEntry->where(["documentos"=>$Document])->count();
            if($count == 0)
            {
                return false;
            }

return true;
}

public function verifyAccountDocEdit($Document,$Id)
{
    $Empleado = $this->asociacionEmpleadoEntry->where(["ID"=>$Id])->first();

    if($Empleado->documentos == $Document){
            return false;
     }else{
            $count = $this->asociacionEmpleadoEntry->where(["documentos"=>$Document])->count();
                    if($count == 0)
                      {
                        return false;
                      }
           return true;   
      }
}



 public function consultaAsociacion($Id)
 {
        $data = asociacionEntry::select(
           "tbl_asociacion.ID",
           "tbl_asociacion.nit",
           "tbl_asociacion.nombre",
           "tbl_asociacion.direccion",
           "tbl_asociacion.telefono",
           "tbl_asociacion.correo",
           "tbl_asociacion.id_municipio",
           "tbl_municipio.Nombre AS municipio"
         )->join(
                "tbl_municipio", 
                "tbl_asociacion.Id_municipio","=","tbl_municipio.ID")
          ->where("tbl_asociacion.ID","=",$Id)->first();
         return $data;
 }
public function consultaAsociacionEmpleado($Id){
    $data = asociacionEmpleadoEntry::select(
                    "tbl_asociacion_empleados.*",
                    "tbl_asociacion.Nombre AS asociacion",
                    "tbl_municipio.Nombre AS municipio",
                    "tbl_tipo_documento.Nombre as Tipo_documento",
                    "tbl_veredas_barrios.Nombre as Veredas_Barrios"
                )->leftjoin(
                        "tbl_asociacion", 
                        "tbl_asociacion_empleados.id_asociacion","=","tbl_asociacion.ID")
                ->leftjoin(
                        "tbl_municipio", 
                        "tbl_asociacion.Id_municipio","=","tbl_municipio.ID")
                ->leftjoin(
                        "tbl_veredas_barrios", 
                        "tbl_asociacion_empleados.id_barrio_vereda","=","tbl_veredas_barrios.ID")

                 ->leftjoin(
                        "tbl_user_login", 
                        "tbl_asociacion_empleados.ID","=","tbl_user_login.ID_EMP") 

                ->leftjoin(
                        "tbl_tipo_documento", 
                        "tbl_asociacion_empleados.id_tipo_documento","=","tbl_tipo_documento.ID")
                ->where("tbl_asociacion_empleados.ID","=",$Id)->first();
        return $data;
    }

  /* DESDE AQUI SE PROCESO EL CRUE DE LA TABLA ASOCIACION */
    public function viewAsociacion(Response $response)
    {
        $AsociacionEntry = asociacionEntry::select(
           "tbl_asociacion.*",
           "tbl_asociacion.Id_municipio",
           "tbl_municipio.Nombre AS municipio"
         )->join(
                "tbl_municipio", 
                "tbl_asociacion.Id_municipio","=","tbl_municipio.ID")
          ->get();
        return $this->customResponse->is200Response($response,$AsociacionEntry);
    }

    public function viewAsociacionid(Response $response,$Id)
    {
        $AsociacionEntry = $this->consultaAsociacion($Id);
        return $this->customResponse->is200Response($response,$AsociacionEntry);
    }

    public function deleteAsociacion(Response $response,$Id)
    {
        $this->asociacionEntry->where(["ID"=>$Id])->delete();
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

       $count = $this->verifyAccountNit($data['Nit']);
        if($count==true){
             $responseMessage = "203-Información no autorizada Asociacion";
            return $this->customResponse->is203Response($response,$responseMessage);
        }
        
        try{
        $asociacionEntry = new AsociacionEntry;
        $asociacionEntry->id_municipio  =   $data['Id_municipio'];
        $asociacionEntry->nit           =   $data['Nit'];
        $asociacionEntry->nombre        =   $data['Nombre'];
        $asociacionEntry->direccion     =   $data['Direccion'];
        $asociacionEntry->telefono      =   $data['Telefono'];
        $asociacionEntry->correo        =   $data['Correo'];
        $asociacionEntry->save();

        $responseMessage = array($this->consultaAsociacion($asociacionEntry->id));

        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
   }

       public function editAsociacion(Request $request,Response $response,$Id)
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

       $count = $this->verifyAccountNitEdit($data['Nit'],$Id);
        if($count==true){
             $responseMessage = "101-Invalido Asociacion documento";
            return $this->customResponse->is203Response($response,$responseMessage);
        }

        try{
         AsociacionEntry::where('ID', '=', $Id)->update([
            'id_municipio'  =>   $data['Id_municipio'],
            'nit'           =>   $data['Nit'],
            'nombre'        =>   $data['Nombre'],
            'direccion'     =>   $data['Direccion'],
            'telefono'      =>   $data['Telefono'],
            'correo'        =>   $data['Correo'],
        ]);
        
        $responseMessage = array('msg' => "La asociacion editada correctamente",
                                  'datos' => $this->consultaAsociacion($Id),
                                  'id' => $Id);

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
            "tbl_asociacion_empleados.*",
            "tbl_asociacion.Nombre AS asociacion",
            "tbl_municipio.Nombre AS municipio",
            "tbl_tipo_documento.Nombre as Tipo_documento",
            "tbl_veredas_barrios.Nombre as Veredas_Barrios",
            "tbl_user_login.ID_EMP as id_Perfil"
         )->leftjoin(
                "tbl_asociacion", 
                "tbl_asociacion_empleados.id_asociacion","=","tbl_asociacion.ID")
         ->leftjoin(
                "tbl_municipio", 
                "tbl_asociacion.Id_municipio","=","tbl_municipio.ID")
          ->leftjoin(
                "tbl_veredas_barrios", 
                "tbl_asociacion_empleados.id_barrio_vereda","=","tbl_veredas_barrios.ID")

          ->leftjoin("tbl_user_login", 
                     "tbl_asociacion_empleados.ID","=","tbl_user_login.ID_EMP") 
          ->leftjoin(
                "tbl_tipo_documento", 
                "tbl_asociacion_empleados.id_tipo_documento","=","tbl_tipo_documento.ID")->get();
        return $this->customResponse->is200Response($response,$AsociacionEmpleadoEntry);
    }

    public function viewAsociacionEmpleadoid(Response $response,$Id)
    {

        $AsociacionEmpleadoEntry = $this->consultaAsociacionEmpleado($Id);
        return $this->customResponse->is200Response($response,$AsociacionEmpleadoEntry);
    }

    public function deleteAsociacionEmpleado(Response $response,$Id)
    {
         $this->asociacionEmpleadoEntry->where(["ID"=>$Id])->delete();

         $this->userEntry->where(["ID_EMP"=>$Id])->delete();

        $responseMessage = "El Empleado Asociacion fue eliminada successfully";
        return $this->customResponse->is200Response($response,$responseMessage);
    }

    public function createAsociacionEmpleado(Request $request,Response $response)
    {
       $data = json_decode($request->getBody(),true);
       $this->validator->validate($request,[
            "Id_asociacion" =>v::notEmpty(),
            "Id_barrio_vereda" =>v::notEmpty(),
            "Id_perfil" =>v::notEmpty(),
            "Documentos" =>v::notEmpty(),
            "Nombres" =>v::notEmpty(),
            "Apellidos" =>v::notEmpty(),
            "Direccion" =>v::notEmpty(),
            "Telefono" =>v::notEmpty(),
            "Correo" =>v::notEmpty(),
            "Estado" =>v::notOptional(),
         ]); 

     if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       } 

    $count = $this->verifyAccountDoc($data['Documentos']);
           if($count==true){
             $responseMessage = "203-1-Información no autorizada Asociacion Empleado";
            return $this->customResponse->is203Response($response,$responseMessage);
           }

    $count = $this->verifyAccountUsuario($data['Correo']);
          if($count==true){
             $responseMessage = "203-2-Información no autorizada Usuario Empleado";
            return $this->customResponse->is203Response($response,$responseMessage);
           }


        try{
            $asociacionEmpleadoEntry = new AsociacionEmpleadoEntry;
            $asociacionEmpleadoEntry->id_asociacion       =   $data['Id_asociacion'];
            $asociacionEmpleadoEntry->id_barrio_vereda    =   $data['Id_barrio_vereda'];
            $asociacionEmpleadoEntry->documentos          =   $data['Documentos'];
            $asociacionEmpleadoEntry->nombres             =   $data['Nombres'];
            $asociacionEmpleadoEntry->apellidos           =   $data['Apellidos'];
            $asociacionEmpleadoEntry->direccion           =   $data['Direccion'];
            $asociacionEmpleadoEntry->telefono            =   $data['Telefono'];
            $asociacionEmpleadoEntry->correo              =   $data['Correo'];
            $asociacionEmpleadoEntry->estado              =   $data['Estado'];
            $asociacionEmpleadoEntry->save();

            $userEntry = new UserEntry;
            $userEntry->ID_EMP      =   $asociacionEmpleadoEntry->id;
            $userEntry->USERNAME    =   $data['Correo'];
            $userEntry->PASSWORD    =   $this->hashPassword($data['Documentos']);
            $userEntry->ESTADO      =   $data['Estado'];
            $userEntry->ID_ROLL     =   $data['Id_perfil'];
            $userEntry->save();

            $responseMessage = array($this->consultaAsociacionEmpleado($asociacionEmpleadoEntry->id));

            return $this->customResponse->is201Response($response,$responseMessage);
            }catch(Exception $err){
            $responseMessage = array("err" => $err->getMessage());
            return $this->customResponse->is400Response($response,$responseMessage);
        }
    }

    public function editarAsociacionEmpleado(Request $request,Response $response,$Id)
    {
       $data = json_decode($request->getBody(),true);
       $this->validator->validate($request,[
            "Id_asociacion" =>v::notEmpty(),
            "Id_barrio_vereda" =>v::notEmpty(),
            "Documentos" =>v::notEmpty(),
            "Nombres" =>v::notEmpty(),
            "Apellidos" =>v::notEmpty(),
            "Direccion" =>v::notEmpty(),
            "Telefono" =>v::notEmpty(),
            "Correo" =>v::notEmpty(),
            "Estado" =>v::notOptional(),
         ]); 

     if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       } 

        $count = $this->verifyAccountDocEdit($data['Documentos'],$Id);
        if($count==true){
             $responseMessage = "203-Información no autorizada Asociacion Empleado";
            return $this->customResponse->is203Response($response,$responseMessage);
        }

        try{
           AsociacionEmpleadoEntry::where('ID', '=', $Id)->update([
            'id_asociacion'         =>   $data['Id_asociacion'],
            'id_barrio_vereda'      =>   $data['Id_barrio_vereda'],
            'documentos'            =>   $data['Documentos'],
            'nombres'               =>   $data['Nombres'],
            'apellidos'             =>   $data['Apellidos'],
            'direccion'             =>   $data['Direccion'],
            'telefono'              =>   $data['Telefono'],
            'estado'                =>   $data['Estado'],
           ]);

            $responseMessage = array(
                            'msg'  => "El empleado de la asociacion se edito correctamente",
                            'datos' => $this->consultaAsociacionEmpleado($Id),
                            'id' => $Id);

        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }
}
