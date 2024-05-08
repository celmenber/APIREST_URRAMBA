<?php

namespace  App\Controllers;

use App\Models\UserEntry;
use App\Models\UserEntryRoll;
use App\Models\UserEntrypermiso;
use App\Models\UserEntryAcceso;
use App\Models\GT_user;

use App\Requests\CustomRequestHandler;
use App\Response\CustomResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

use App\Validation\Validator;
use Respect\Validation\Exceptions\Exception;
use Respect\Validation\Validator as v;



class UserController
{
    protected $customResponse;
    protected $userEntry;
    protected $userEntryroll;
    protected $userEntrypermiso;
    protected $userEntryacceso;
    protected $usergtEntry;
    protected $validator;
    public function __construct()
    {
        $this->customResponse = new CustomResponse();
        $this->userEntry = new UserEntry();
        $this->userEntryroll = new UserEntryRoll();
        $this->userEntrypermiso = new UserEntrypermiso();
        $this->userEntryacceso = new UserEntryAcceso();
        $this->usergtEntry = new GT_user();
        $this->validator = new Validator();
    }

   public function hashPassword($password)
    {
        return password_hash($password,PASSWORD_DEFAULT);
    }

 public function verifyAccount($users,$Id)
    {
        $User = $this->userEntry->where(["ID_USER"=>$Id])->first();

        if($User->USERNAME == $users){
                return false;
        }else{
                $count = $this->userEntry->where(["USERNAME"=>$users])->count();
                        if($count == 0)
                        {
                            return false;
                        }
            return true;   
        }
    }

    public function handleUser()
    {
       $guestEntries = userEntry::select(
                        "tbl_user_login.ID_USER",
                        "tbl_user_login.ID_ROLL",
                        "tbl_user_login.ID_AUT",
                        "tbl_user_login.ID_EMP",
                        "tbl_user_login.USERNAME",
                        "tbl_user_login.ESTADO",
                        "tbl_user_login.AVATAR",
                        "tbl_user_login.FECHA",
                        "tbl_user_roll.NOMBRE as USER_ROL",
                        "tbl_asociacion_empleados.documentos AS emp_documento",
                        "tbl_asociacion_empleados.nombres AS emp_nombres",
                        "tbl_asociacion_empleados.apellidos AS emp_apellidos",
                        "tbl_asociacion_empleados.telefono AS emp_telefono",
                        "tbl_autoridad_tradicional.documentos AS aut_documentos",
                        "tbl_autoridad_tradicional.nombres AS aut_nombres",
                        "tbl_autoridad_tradicional.apellidos AS aut_apellidos",
                        "tbl_autoridad_tradicional.telefono AS aut_telefono"
                        )
                        ->join(
                            "tbl_user_roll",
                            "tbl_user_login.ID_ROLL","=","tbl_user_roll.ID")
                        ->leftJoin(
                            "tbl_asociacion_empleados", 
                            "tbl_user_login.ID_EMP","=","tbl_asociacion_empleados.ID") 
                        ->leftJoin(
                            "tbl_autoridad_tradicional",
                            "tbl_user_login.ID_AUT","=","tbl_autoridad_tradicional.ID")
                        ->get();
        return $guestEntries;
    }

    public function handleUserId($Id)
    {
       $userEntries = userEntry::select(
                       "tbl_user_login.ID_USER",
                        "tbl_user_login.ID_ROLL",
                        "tbl_user_login.ID_AUT",
                        "tbl_user_login.ID_EMP",
                        "tbl_user_login.USERNAME",
                        "tbl_user_login.ESTADO",
                        "tbl_user_login.AVATAR",
                        "tbl_user_login.FECHA",
                        "tbl_user_roll.NOMBRE as USER_ROL",
                        "tbl_asociacion_empleados.documentos AS emp_documento",
                        "tbl_asociacion_empleados.nombres AS emp_nombres",
                        "tbl_asociacion_empleados.apellidos AS emp_apellidos",
                        "tbl_asociacion_empleados.telefono AS emp_telefono",
                        "tbl_autoridad_tradicional.documentos AS aut_documentos",
                        "tbl_autoridad_tradicional.nombres AS aut_nombres",
                        "tbl_autoridad_tradicional.apellidos AS aut_apellidos",
                        "tbl_autoridad_tradicional.telefono AS aut_telefono"
                        )
                        ->join(
                            "tbl_user_roll",
                            "tbl_user_login.ID_ROLL","=","tbl_user_roll.ID")
                        ->leftJoin(
                            "tbl_asociacion_empleados", 
                            "tbl_user_login.ID_EMP","=","tbl_asociacion_empleados.ID") 
                        ->leftJoin(
                            "tbl_autoridad_tradicional",
                            "tbl_user_login.ID_AUT","=","tbl_autoridad_tradicional.ID")
                        ->where("ID_USER","=",$Id)->first();
       return $userEntries;
    }

/* DESDE AQUI SE PROCESO EL CRUE DE LA TABLA USER LOGIN */
    public function viewUser(Response $response)
    {
        return $this->customResponse->is200Response($response, $this->handleUser()); 
    }

    public function viewUserId(Response $response,$Id)
    {
        $guestEntries = $this->handleUserId($Id);
        return $this->customResponse->is200Response($response,$guestEntries);
    }

    public function deleteUser(Response $response,$Id)
    {
        $this->userEntry->where(["ID_USER"=>$Id])->delete();
        $responseMessage = "El usuario fue eliminado exitosamente";
        return $this->customResponse->is200Response($response,$responseMessage);
    }


    public function viewUserRoll(Response $response)
    {
        $guestEntriesroll = $this->userEntryroll->get();
        return $this->customResponse->is200Response($response,$guestEntriesroll);
    }

      public function viewUserRollid(Response $response,$Id)
    {
        $guestEntriesroll = $this->userEntryroll->where(["ID"=>$Id])->first();
        return $this->customResponse->is200Response($response,$guestEntriesroll);
    }


    public function createUsers(Request $request,Response $response)
    {
       $data = json_decode($request->getBody(),true);
       $this->validator->validate($request,[
           "Roll"=>v::notEmpty(),
           "Usuario"=>v::notEmpty(),
           "Estado"=>v::notEmpty(),
           "Password"=>v::notEmpty()
         ]); 

        if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       } 
        try{
        $guestEntry = new UserEntry;
        $guestEntry->ID_ROLL     =   $data['Roll'];
        $guestEntry->USERNAME    =   $data['Usuario'];
        $guestEntry->ESTADO      =   $data['Estado'];
        $guestEntry->PASSWORD    =   $this->hashPassword($data['Password']);
        $guestEntry->save();
        $responseMessage = array('msg' => "usuario Guardado correctamente",
                                  'id' => $guestEntry->id);
        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
   }

    public function editUsers(Request $request,Response $response,$Id)
    {
         $data = json_decode($request->getBody(),true);
         $this->validator->validate($request,[
           "ID_ROLL"=>v::notEmpty(),
           "USERNAME"=>v::notEmpty()
         ]);

        if($this->validator->failed())
        {
            $responseMessage = $this->validator->errors;
            return $this->customResponse->is400Response($response,$responseMessage);
        }
               $verifyAccount = $this->verifyAccount($data['USERNAME'],$Id);

                if($verifyAccount==true)
                {
                    $responseMessage = "203-1-Información no autorizada cambio usuario";
                    return $this->customResponse->is203Response($response,$responseMessage);
                } 
        try{

           UserEntry::where('ID_USER', '=', $Id)->update([
                            'ID_ROLL' =>  $data['ID_ROLL'],
                            'USERNAME' => $data['USERNAME'],
                            ]);

                $responseMessage =  $this->handleUserId($Id);
                return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
                $responseMessage = array("err" => $err->getMessage());
                return $this->customResponse->is400Response($response,$responseMessage);
            }
    }
    public function editUserEstado(Request $request,Response $response,$Id)
    {
        $data = json_decode($request->getBody(),true);
            try{
                    UserEntry::where('ID_USER', '=', $Id)->update([
                                    'ESTADO' => $data['ESTADO'],
                    ]);

                    $userEntries = $this->handleUserId($Id);
                    //$this->handleUser();
                    return $this->customResponse->is200Response($response,$userEntries);
                }catch(Exception $err){
                $responseMessage = array("err" => $err->getMessage());
                return $this->customResponse->is400Response($response,$responseMessage);
            }
    }

 public function userCambioClave(Request $request,Response $response,$Id)
    {
        $data = json_decode($request->getBody(),true);
            try{
                    UserEntry::where('ID_USER', '=', $Id)->update([
                                     'PASSWORD' => $this->hashPassword($data['DOCUMENTO']),
                    ]);

                    $userEntries = $this->handleUserId($Id);
                    return $this->customResponse->is200Response($response,$userEntries);
                }catch(Exception $err){
                $responseMessage = array("err" => $err->getMessage());
                return $this->customResponse->is400Response($response,$responseMessage);
            }
    }
/* FIN DEL CRUE LOGIUN USER */
/* DESDE AQUI SE PROCESA EL CRUE DE LA TABLA PERMISO */
    public function viewUserPermiso(Response $response)
    {
        $guestEntriespermiso = $this->userEntrypermiso->get();
        return $this->customResponse->is200Response($response,$guestEntriespermiso);
    }

      public function viewUserPermisoid(Response $response,$Id)
    {
        $guestEntriespermiso = $this->userEntrypermiso->where(["ID"=>$Id])->get();
        return $this->customResponse->is200Response($response,$guestEntriespermiso);
    }

    public function createuserPermiso(Request $request,Response $response)
    {

    $data = json_decode($request->getBody(),true);
        $this->validator->validate($request,[
           "IDUSERMENU"=>v::notEmpty(),
           "NOMBRE"=>v::notEmpty(),
           "ESTADO"=>v::notEmpty()
             ]); 
       	 

       if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       }
 try{
       
        $guestEntrypermiso = new UserEntrypermiso;
        $guestEntrypermiso->ID_USER_MENU         =   $data['IDUSERMENU'];
        $guestEntrypermiso->NOMBRE               =   $data['NOMBRE'];
        $guestEntrypermiso->ESTADO               =   $data['ESTADO'];
        $guestEntrypermiso->save();
        $responseMessage = array('msg' => "permiso guardado correctamente",'id' => $guestEntrypermiso->id);
        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }

   public function editUserPermiso(Request $request,Response $response,$Id)
    {
        $data = json_decode($request->getBody(),true);
         $this->validator->validate($request,[
              "IDUSERMENU"=>v::notEmpty(),
              "NOMBRE"=>v::notEmpty(),
              "ESTADO"=>v::notEmpty()
        ]); 
        if($this->validator->failed())
        {
            $responseMessage = $this->validator->errors;
            return $this->customResponse->is400Response($response,$responseMessage);
        }

     try{
        $guestEntrypermiso = UserEntrypermiso::find($Id);
        $guestEntrypermiso->ID_USER_MENU         =   $data['IDUSERMENU'];
        $guestEntrypermiso->NOMBRE               =   $data['NOMBRE'];
        $guestEntrypermiso->ESTADO               =   $data['ESTADO'];
        $guestEntrypermiso->save();
        $responseMessage = array('msg' => "permiso editado correctamente",
                                  'id' => $Id);
        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }
    /* FIN DEL CRUE PERMISO */
}