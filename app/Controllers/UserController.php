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

/* DESDE AQUI SE PROCESO EL CRUE DE LA TABLA USER LOGIN */
    public function viewUser(Response $response)
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
            "tbl_autoridad_tradicional.telefono AS aut_telefono",
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
        return $this->customResponse->is200Response($response,$guestEntries); 
    }

    public function viewUserId(Response $response,$id)
    {
       $guestEntries = userEntry::select(
                       "ID_USER",
                       "ID_ROLL",
                       "USERNAME",
                       "ESTADO",
                       "AVATAR",
                       "FECHA")
                    ->where("ID_USER","=",$id)
                    ->get();
        return $this->customResponse->is200Response($response,$guestEntries);
    }

    public function deleteUser(Response $response,$id)
    {
        $this->userEntry->where(["ID_USER"=>$id])->delete();
        $responseMessage = "El usuario fue eliminado exitosamente";
        return $this->customResponse->is200Response($response,$responseMessage);
    }


    public function viewUserRoll(Response $response)
    {
        $guestEntriesroll = $this->userEntryroll->get();
        return $this->customResponse->is200Response($response,$guestEntriesroll);
    }

      public function viewUserRollid(Response $response,$id)
    {
        $guestEntriesroll = $this->userEntryroll->where(["ID"=>$id])->get();
        return $this->customResponse->is200Response($response,$guestEntriesroll);
    }


    public function createUsers(Request $request,Response $response)
    {
       $data = json_decode($request->getBody(),true);
       $this->validator->validate($request,[
           "rol"=>v::notEmpty(),
           "users"=>v::notEmpty(),
           "password"=>v::notEmpty()
         ]); 

        if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       } 
        try{
        $guestEntry = new UserEntry;
        $guestEntry->ID_ROLL     =   $data['rol'];
        $guestEntry->USERNAME    =   $data['users'];
        $guestEntry->ESTADO      =   1;
        $guestEntry->PASSWORD    =   $this->hashPassword($data['password']);
        $guestEntry->save();
        $responseMessage = array('msg' => "usuario Guardado correctamente",'id' => $guestEntry->id);
        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
   }

    public function editUsers(Request $request,Response $response,$id)
    {
         $data = json_decode($request->getBody(),true);
         $this->validator->validate($request,[
           "rol"=>v::notEmpty(),
           "users"=>v::notEmpty(),
           "estado"=>v::notEmpty()
         ]);
         
        if($this->validator->failed())
        {
            $responseMessage = $this->validator->errors;
            return $this->customResponse->is400Response($response,$responseMessage);
        }
        try{
                $guestEntry = UserEntry::find($id);
                $guestEntry->ID_ROLL     =   $data['rol'];
                $guestEntry->USERNAME    =   $data['users'];
                $guestEntry->ESTADO      =   1;
                $guestEntry->PASSWORD    =   $this->hashPassword($data['password']);
                $guestEntry->save();
                $responseMessage = array('msg' => "usuario Editado correctamente",'id' => $id);
                return $this->customResponse->is200Response($response,$responseMessage);
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

      public function viewUserPermisoid(Response $response,$id)
    {
        $guestEntriespermiso = $this->userEntrypermiso->where(["ID"=>$id])->get();
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

   public function editUserPermiso(Request $request,Response $response,$id)
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
        $guestEntrypermiso = UserEntrypermiso::find($id);
        $guestEntrypermiso->ID_USER_MENU         =   $data['IDUSERMENU'];
        $guestEntrypermiso->NOMBRE               =   $data['NOMBRE'];
        $guestEntrypermiso->ESTADO               =   $data['ESTADO'];
        $guestEntrypermiso->save();
        $responseMessage = array('msg' => "permiso editado correctamente",'id' => $id);
        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }

    /* FIN DEL CRUE PERMISO */
    /* DESDE AQUI SE PROCESA EL CRUE DE LA TABLA ACCESOS */
 public function viewUserAcceso(Response $response)
    {
        $guestEntriesacceso = $this->userEntryacceso->get();
        return $this->customResponse->is200Response($response,$guestEntriesacceso);
    }

    public function viewUserAccesoid(Response $response,$id)
    {
        $guestEntriesacceso = $this->userEntryacceso->where(["ID"=>$id])->get();
        return $this->customResponse->is200Response($response,$guestEntriesacceso);
    }

   public function createuserAcceso(Request $request,Response $response)
    {

         $data = json_decode($request->getBody(),true);
         $this->validator->validate($request,[
            "IDUSER"=>v::notEmpty(),
            "LAT"=>v::notEmpty(),
            "LON"=>v::notEmpty(),
            "CIUDAD"=>v::notEmpty(),
            "PAIS"=>v::notEmpty(),
            "IP"=>v::notEmpty()
          ]); 

       if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       }

    try{
        $Guestentryacceso = new UserEntryacceso;
        $Guestentryacceso->ID_USER         =   $data['IDUSER'];
        $Guestentryacceso->LAT             =   $data['LAT'];
        $Guestentryacceso->LON             =   $data['LON'];
        $Guestentryacceso->CIUDAD          =   $data['CIUDAD'];
        $Guestentryacceso->PAIS            =   $data['PAIS'];
        $Guestentryacceso->IP              =   $data['IP'];
        $Guestentryacceso->save();
        $responseMessage = array('msg' => "auditoria Guardada correctamente",'id' => $Guestentryacceso->id);
        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }
    /* FIN DEL CRUE ACCESOS */
    /* DESDE AQUI SE PROCESA EL CRUE DE LA TABLA GT_USER LA CUAL ES AUXILIAR */
    public function viewUserGt(Response $response)
    {
        $usergt_userentry = $this->usergtEntry->get();
        return $this->customResponse->is200Response($response,$usergt_userentry);
    }

    public function viewUserGtid(Response $response,$id)
    {
        $guestgt_userentry = $this->usergtEntry->where(["ID"=>$id])->get();
        return $this->customResponse->is200Response($response,$guestgt_userentry);
    }

    public function createuserGt(Request $request,Response $response)
    {
        $data = json_decode($request->getBody(),true);
        $this->validator->validate($request,[
            "IDUSER"=>v::notEmpty(),
            "IDTIPOUSER"=>v::notEmpty() 
       ]); 

       if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       }

       try{
        $gtuserentry =  new GT_user; 
        $gtuserentry->ID_USER         =   $data['IDUSER'];
        $gtuserentry->ID_TIPO_USER    =   $data['IDTIPOUSER'];
        $gtuserentry->save();
        $responseMessage = array('msg' => "gt USUARIO guardado correctamente",'id' => $gtuserentry->id);
        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }

    public function editUserGt(Request $request,Response $response,$id)
    {
         $data = json_decode($request->getBody(),true);
         $this->validator->validate($request,[
            "IDUSER"=>v::notEmpty(),
            "IDTIPOUSER"=>v::notEmpty() 
          ]); 

        if($this->validator->failed())
        {
            $responseMessage = $this->validator->errors;
            return $this->customResponse->is400Response($response,$responseMessage);
        }

        try{
        $gtuserentry = GT_user::find($id);
        $gtuserentry->ID_USER         =   $data['IDUSER'];
        $gtuserentry->ID_TIPO_USER    =   $data['IDTIPOUSER'];
        $gtuserentry->save();
        $responseMessage = array('msg' => "gt USUARIO editado correctamente",'id' => $id);
        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }

}