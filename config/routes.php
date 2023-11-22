<?php
use Slim\App;
use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\AsociacionController;
use App\Controllers\ConcejocomunitarioController;
use App\Controllers\ViviendaController;
use App\Controllers\ParametricasController;

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

       $app->group("/asociacion",function($app)
      {
         $app->get("/view-asociacion",[AsociacionController::class, 'viewAsociacion']);
         $app->get("/view-asociacion/{id}",[AsociacionController::class,'viewAsociacionid']);
         $app->post("/create-asociacion",[AsociacionController::class,'createAsociacion']);
         $app->put("/edit-asociacion/{id}",[AsociacionController::class,'editAsociacion']);
         $app->delete("/delete-asociacion/{id}", [AsociacionController::class, "deleteAsociacion"]);
      });

      $app->group("/concejocomunitario",function($app)
      {
         $app->get("/view-concejocomunitario",[ConcejocomunitarioController::class, 'viewConcejocomunitario']);
         $app->get("/view-concejocomunitario/{id}",[ConcejocomunitarioController::class,'viewConcejocomunitarioId']);
         $app->post("/create-concejocomunitario",[ConcejocomunitarioController::class,'createConcejocomunitario']);
         $app->put("/edit-concejocomunitario/{id}",[ConcejocomunitarioController::class,'editConcejocomunitario']);
         $app->delete("/delete-concejocomunitario/{id}", [ConcejocomunitarioController::class, "deleteConcejocomunitario"]);
      });

      $app->group("/autoridatradicional",function($app)
      {
         $app->get("/view-autoridatradicional",[ConcejocomunitarioController::class, 'viewAutoridaTradicional']);
         $app->get("/view-autoridatradicional/{id}",[ConcejocomunitarioController::class,'viewAutoridaTradicionalId']);
         $app->post("/create-autoridatradicional",[ConcejocomunitarioController::class,'createAutoridaTradicional']);
         $app->put("/edit-autoridatradicional/{id}",[ConcejocomunitarioController::class,'editAutoridaTradicional']);
         $app->patch("/estado-concejocomunitario/{id}",[ConcejocomunitarioController::class,'estadoAutoridaTradiciona']);
         $app->delete("/delete-autoridatradicional/{id}", [ConcejocomunitarioController::class, "deleteAutoridaTradicional"]);
      });

       $app->group("/miembrosconcejo",function($app)
      {
         $app->get("/view-miembrosconcejo",[ConcejocomunitarioController::class, 'viewMiembrosConcejo']);
         $app->get("/view-miembrosconcejo/{id}",[ConcejocomunitarioController::class,'viewMiembrosConcejoId']);
         $app->post("/create-miembrosconcejo",[ConcejocomunitarioController::class,'createMiembrosConcejo']);
         $app->put("/edit-miembrosconcejo/{id}",[ConcejocomunitarioController::class,'editMiembrosConcejo']);
         $app->patch("/estado-miembrosconcejo/{id}",[ConcejocomunitarioController::class,'estadoMiembrosConcejo']);
         $app->delete("/delete-miembrosconcejo/{id}", [ConcejocomunitarioController::class, "deleteMiembrosConcejo"]);
      });

       $app->group("/vivienda",function($app)
      {
         $app->get("/view-vivienda",[ViviendaController::class, 'viewVivienda']);
         $app->get("/view-vivienda/{id}",[ViviendaController::class,'viewViviendaId']);
         $app->post("/create-vivienda",[ViviendaController::class,'createVivienda']);
         $app->put("/edit-vivienda/{id}",[ViviendaController::class,'editaVivienda']);
         $app->patch("/estado-vivienda/{id}",[ViviendaController::class,'estadoVivienda']);
         $app->delete("/delete-vivienda/{id}", [ViviendaController::class, "deleteVivienda"]);
      });



       $app->group("/parametros",function($app)
      {
         $app->get("/view-departamento",[ParametricasController::class, 'viewDepartamento']);
         $app->patch("/estado-departamento/{id}",[ParametricasController::class,'estadoDepartamento']);
         $app->get("/view-municipio",[ParametricasController::class, 'viewMunicipio']);
         $app->patch("/estado-municipio/{id}",[ParametricasController::class,'estadoMunicipio']);
         $app->get("/view-corregimiento",[ParametricasController::class, 'viewCorregimiento']);
         $app->patch("/estado-corregimiento/{id}",[ParametricasController::class,'estadoCorregimiento']);
         $app->get("/view-veredas_barrios",[ParametricasController::class, 'viewVeredas_barrios']);
         $app->patch("/estado-veredas_barrios/{id}",[ParametricasController::class,'estadoVeredas_barrios']);
         $app->get("/view-escolaridad",[ParametricasController::class, 'viewEscolaridad']);
         $app->patch("/estado-escolaridad/{id}",[ParametricasController::class,'estadoEscolaridad']);
         $app->get("/view-parentesco",[ParametricasController::class, 'viewParentesco']);
         $app->patch("/estado-parentesco/{id}",[ParametricasController::class,'estadoParentesco']);
         $app->get("/view-orientacion_sexual",[ParametricasController::class, 'viewOrientacion_sexual']);
         $app->patch("/estado-orientacion_sexual/{id}",[ParametricasController::class,'estadoOrientacion_sexual']);
         $app->get("/view-tipoinmueble",[ParametricasController::class, 'viewTipoinmueble']);
         $app->patch("/estado-tipoinmueble/{id}",[ParametricasController::class,'estadoTipoinmueble']);
         $app->get("/view-tenencia",[ParametricasController::class, 'viewTenencia']);
         $app->patch("/estado-tenencia/{id}",[ParametricasController::class,'estadoTenencia']);
         $app->get("/view-tipodocumento",[ParametricasController::class, 'viewTipodocumento']);
         $app->patch("/estado-tipodocumento/{id}",[ParametricasController::class,'estadoTipodocumento']);
         $app->get("/view-logo",[ParametricasController::class, 'viewLogo']);
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
 */

   });
};