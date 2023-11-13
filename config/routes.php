<?php
use Slim\App;
use App\Controllers\AuthController;
use App\Controllers\UserController;

return function (App $app)
{
   $app->group("/api",function($app)
     {

        $app->group("/auth",function($app)
        {
            $app->post("/login",[AuthController::class,"Login"]);
        });

        $app->group("/users",function($app)
         {
         $app->get("/view-user",[UserController::class, 'viewUser']);
         $app->get("/view-user/{id}",[UserController::class,'viewUserId']);
         $app->post("/create-user",[UserController::class,'createUsers']);
         $app->put("/edit-user/{id}",[UserController::class,'editUsers']);

         $app->get("/view-user-roll",[UserController::class,'viewUserRoll']);
         $app->get("/view-user-roll/{id}",[UserController::class,'viewUserRollid']);

/*          $app->get("/view-user-permiso",[UserController::class,'viewUserPermiso']);
         $app->get("/view-user-permiso/{id}",[UserController::class,'viewUserPermisoid']);
         $app->post("/create-user-permiso",[UserController::class,'createuserPermiso']);
         $app->put("/edit-user-permiso/{id}",[UserController::class,'editUserPermiso']);

         $app->get("/view-user-acceso",[UserController::class,'viewUserAcceso']);
         $app->get("/view-user-acceso/{id}",[UserController::class,'viewUserAccesoid']);
         $app->post("/create-user-acceso",[UserController::class,'createuserAcceso']);
           
         $app->post("/create-user-gt",[UserController::class,'createuserGt']);
         $app->put("/edit-user-gt/{id}",[UserController::class,'editUserGt']); */
       });

    /*   $app->group("/clientecandidato",function($app)
      {
         $app->get("/view-candidato",[ClienteCandidatoController::class, 'viewCliCandidatoGet']);
         $app->get("/view-candidato/{id}",[ClienteCandidatoController::class,'viewCliCandidatoGetid']);
         $app->get("/view-candidatonombre/{nombre}",[ClienteCandidatoController::class,'viewCliCandidatoGetnombre']);
         $app->get("/view-candidatocodigo/{codigo}",[ClienteCandidatoController::class,'viewCliCandidatoGetcodigo']);
         $app->post("/create-candidato",[ClienteCandidatoController::class,'createCliCandidatoEntry']);
         $app->put("/edit-candidato/{id}",[ClienteCandidatoController::class,'editaCliCandidatoEntry']);
         $app->patch("/estado-candidato/{id}",[ClienteCandidatoController::class,'estadoCliCandidato']);
         $app->delete("/delete-candidato/{id}", [ClienteCandidatoController::class, "deleteCliCandidato"]);
      });

      $app->group("/clientecobros",function($app)
      {
         $app->get("/view-cobros",[ClienteCobrosController::class, 'viewclienteCobrosGet']);
         $app->get("/view-cobros/{id}",[ClienteCobrosController::class,'viewclienteCobrosGetid']);
         $app->post("/create-cobros",[ClienteCobrosController::class,'createClienteCobrosEntry']);
         $app->put("/edit-cobros/{id}",[ClienteCobrosController::class,'editaClienteCobrosEntry']);
         $app->patch("/estado-cobros/{id}",[ClienteCobrosController::class,'estadoclienteCobros']);
         $app->delete("/delete-cobros/{id}", [ClienteCobrosController::class, "deleteClienteCobros"]);
      });

      $app->group("/clientepos",function($app)
      {
         $app->get("/view-pos",[ClientePosController::class, 'viewclientePosGet']);
         $app->get("/view-pos/{id}",[ClientePosController::class,'viewclientePosGetid']);
         $app->post("/create-pos",[ClientePosController::class,'createclientePosEntry']);
         $app->put("/edit-pos/{id}",[ClientePosController::class,'editaclientePosEntry']);
         $app->patch("/estado-pos/{id}",[ClientePosController::class,'estadoclientePos']);
         $app->delete("/delete-pos/{id}", [ClientePosController::class, "deleteClientePos"]);
      });

      $app->group("/clienteplanes",function($app)
      {
         $app->get("/view-planes",[ClientePosController::class, 'viewCliPlanesGet']);
         $app->get("/view-planes/{id}",[ClientePosController::class,'viewCliPlanesGetid']);
         $app->post("/create-planes",[ClientePosController::class,'createcliPlanesEntry']);
         $app->put("/edit-planes/{id}",[ClientePosController::class,'editacliPlanesEntry']);
         $app->delete("/delete-planes/{id}", [ClientePosController::class, "deleteCliPlanes"]);
      });

      $app->group("/clientemodulos",function($app)
      {
         $app->get("/view-modulo",[ClientePosController::class, 'viewCliModulosGet']);
         $app->get("/view-modulo/{id}",[ClientePosController::class,'viewCliModulosGetid']);
         $app->post("/create-modulo",[ClientePosController::class,'createcliModuloEntry']);
         $app->put("/edit-modulo/{id}",[ClientePosController::class,'editacliModuloEntry']);
         $app->delete("/delete-modulo/{id}", [ClientePosController::class, "deleteCliModulos"]);
      });

      $app->group("/mensajetexto",function($app)
      {
         $app->get("/view-smstexto",[ClientePosController::class, 'viewSmsTextoGet']);
         $app->get("/view-smstexto/{id}",[ClientePosController::class,'viewSmsTextoGetid']);
         $app->post("/create-smstexto",[ClientePosController::class,'createSmsTextoEntry']);
         $app->put("/edit-smstexto/{id}",[ClientePosController::class,'editaSmsTextoEntry']);
         $app->delete("/delete-smstexto/{id}", [ClientePosController::class, "deleteSmsTexto"]);
      });

      $app->group("/mensajevoz",function($app)
      {
         $app->get("/view-smsvoz",[ClientePosController::class, 'viewSmsVozGet']);
         $app->get("/view-smsvoz/{id}",[ClientePosController::class,'viewSmsVozGetid']);
         $app->post("/create-smsvoz",[ClientePosController::class,'createSmsVozEntry']);
         $app->put("/edit-smsvoz/{id}",[ClientePosController::class,'editaSmsVozEntry']);
         $app->delete("/delete-smsvoz/{id}", [ClientePosController::class, "deleteSmsVoz"]);
      });

      $app->group("/smsenvios",function($app)
      {
         $app->get("/view-envios",[ClientePosController::class, 'viewSmsEnviosGet']);
         $app->get("/view-envios/{id}",[ClientePosController::class,'viewSmsEnviosGetid']);
         $app->post("/create-envios",[ClientePosController::class,'createSmsEnviosEntry']);
         $app->put("/edit-envios/{id}",[ClientePosController::class,'editaSmsEnviadosEntry']);
         $app->delete("/delete-envios/{id}", [ClientePosController::class, "deleteSmsEnvios"]);
      });

      $app->group("/smsvalor",function($app)
      {
         $app->get("/view-valor",[ClientePosController::class, 'viewSmsValorGet']);
         $app->post("/create-valor",[ClientePosController::class,'SmsValorEntry']);
      }); */

   });
};