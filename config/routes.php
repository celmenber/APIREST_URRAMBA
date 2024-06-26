<?php
use Slim\App;
use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\AsociacionController;
use App\Controllers\ConcejocomunitarioController;
use App\Controllers\GrupoFamiliarController;
use App\Controllers\ViviendaController;
use App\Controllers\CaracterizacionController;
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
         $app->get("/view-user/{Id}",[UserController::class,'viewUserId']);
         $app->post("/create-user",[UserController::class,'createUsers']);
         $app->put("/edit-user/{Id}",[UserController::class,'editUsers']);
         $app->patch("/edit-userestado/{Id}",[UserController::class,'editUserEstado']);
         $app->patch("/edit-usercambioclave/{Id}",[UserController::class,'userCambioClave']);
         $app->get("/view-user-roll",[UserController::class,'viewUserRoll']);
         $app->get("/view-user-roll/{Id}",[UserController::class,'viewUserRollid']);
       });

       $app->group("/asociacion",function($app)
      {
         $app->get("/view-asociacion",[AsociacionController::class, 'viewAsociacion']);
         $app->get("/view-asociacion/{Id}",[AsociacionController::class,'viewAsociacionid']);
         $app->post("/create-asociacion",[AsociacionController::class,'createAsociacion']);
         $app->put("/edit-asociacion/{Id}",[AsociacionController::class,'editAsociacion']);
         $app->delete("/delete-asociacion/{Id}", [AsociacionController::class, "deleteAsociacion"]);
      });

      $app->group("/concejocomunitario",function($app)
      {
         $app->get("/view-concejocomunitario",[ConcejocomunitarioController::class, 'viewConcejocomunitario']);
         $app->get("/view-concejocomunitario/{Id}",[ConcejocomunitarioController::class,'viewConcejocomunitarioId']);
         $app->post("/create-concejocomunitario",[ConcejocomunitarioController::class,'createConcejocomunitario']);
         $app->put("/edit-concejocomunitario/{Id}",[ConcejocomunitarioController::class,'editConcejocomunitario']);
         $app->delete("/delete-concejocomunitario/{Id}", [ConcejocomunitarioController::class, "deleteConcejocomunitario"]);
      });

      $app->group("/autoridatradicional",function($app)
      {
         $app->get("/view-autoridatradicional",[ConcejocomunitarioController::class, 'viewAutoridaTradicional']);
         $app->get("/view-autoridatradicional/{Id}",[ConcejocomunitarioController::class,'viewAutoridaTradicionalId']);
         $app->post("/create-autoridatradicional",[ConcejocomunitarioController::class,'createAutoridaTradicional']);
         $app->put("/edit-autoridatradicional/{Id}",[ConcejocomunitarioController::class,'editAutoridaTradicional']);
         $app->patch("/estado-concejocomunitario/{Id}",[ConcejocomunitarioController::class,'estadoAutoridaTradiciona']);
         $app->delete("/delete-autoridatradicional/{Id}", [ConcejocomunitarioController::class, "deleteAutoridaTradicional"]);
      });

       $app->group("/empleados",function($app)
      {
         $app->get("/view-empleado",[AsociacionController::class, 'viewAsociacionEmpleado']);
         $app->get("/view-empleado/{Id}",[AsociacionController::class,'viewAsociacionEmpleadoid']);
         $app->post("/create-empleado",[AsociacionController::class,'createAsociacionEmpleado']);
         $app->put("/edit-empleado/{Id}",[AsociacionController::class,'editarAsociacionEmpleado']);
         $app->delete("/delete-empleado/{Id}", [AsociacionController::class, "deleteAsociacionEmpleado"]);
      });

       $app->group("/miembrosconcejo",function($app)
      {
         $app->get("/view-miembrosconcejo",[ConcejocomunitarioController::class, 'viewMiembrosConcejo']);
         $app->get("/view-miembrosconcejo/{Id}",[ConcejocomunitarioController::class,'viewMiembrosConcejoId']);
         $app->post("/create-miembrosconcejo",[ConcejocomunitarioController::class,'createMiembrosConcejo']);
         $app->put("/edit-miembrosconcejo/{Id}",[ConcejocomunitarioController::class,'editMiembrosConcejo']);
         $app->patch("/estado-miembrosconcejo/{Id}",[ConcejocomunitarioController::class,'estadoMiembrosConcejo']);
         $app->delete("/delete-miembrosconcejo/{Id}", [ConcejocomunitarioController::class, "deleteMiembrosConcejo"]);
      });

      $app->group("/jefehogar",function($app)
      {
         $app->get("/view-jefehogar",[GrupoFamiliarController::class, 'viewJefeHogar']);
         $app->get("/view-jefehogar/{Id}",[GrupoFamiliarController::class,'viewJefeHogarId']);
         $app->get("/view-jefehogar-documento/{Doc}",[GrupoFamiliarController::class,'viewJefeHogarDocuments']);
         $app->post("/create-jefehogar",[GrupoFamiliarController::class,'createJefeHogar']);
         $app->put("/edit-jefehogar/{Id}",[GrupoFamiliarController::class,'editarJefeHogar']);
         $app->patch("/estado-jefehogar/{Id}",[GrupoFamiliarController::class,'estadoJefeHogar']);
         $app->delete("/delete-jefehogar/{Id}", [GrupoFamiliarController::class, "deleteJefeHogar"]);
      });

       $app->group("/nucleofamiliar",function($app)
      {
         $app->get("/view-nucleofamiliar",[GrupoFamiliarController::class, 'viewNucleoFamiliar']);
         $app->get("/view-nucleofamiliar/{Id}",[GrupoFamiliarController::class,'viewNucleoFamiliarId']);
         $app->post("/create-nucleofamiliar",[GrupoFamiliarController::class,'createNucleoFamiliar']);
         $app->put("/edit-nucleofamiliar/{Id}",[GrupoFamiliarController::class,'editarNucleoFamiliar']);
         $app->put("/traslado-nucleofamiliar/{Id}",[GrupoFamiliarController::class,'trasladoNucleoFamiliar']);
         $app->delete("/delete-nucleofamiliar/{Id}", [GrupoFamiliarController::class, "deleteNucleoFamiliar"]);
      });

      $app->group("/vivienda",function($app)
      {
         $app->get("/view-vivienda",[ViviendaController::class, 'viewVivienda']);
         $app->get("/view-vivienda/{Id}",[ViviendaController::class,'viewViviendaId']);
         $app->post("/create-vivienda",[ViviendaController::class,'createVivienda']);
         $app->put("/edit-vivienda/{Id}",[ViviendaController::class,'editaVivienda']);
         $app->patch("/estado-vivienda/{Id}",[ViviendaController::class,'estadoVivienda']);
         $app->delete("/delete-vivienda/{Id}", [ViviendaController::class, "deleteVivienda"]);
      });

      $app->group("/caratacterizacion",function($app)
      {
          $app->get("/view-caratacterizacion",[CaracterizacionController::class, 'viewCaracterizacion']);
          $app->get("/view-caratacterizacion/{Id}",[CaracterizacionController::class,'viewCaracterizacionid']);
          $app->post("/create-caratacterizacion",[CaracterizacionController::class,'createCaracterizacion']);
          $app->delete("/delete-caratacterizacion/{Id}", [CaracterizacionController::class, "deleteCaracterizacion"]);
      });   

       $app->group("/parametros",function($app)
      {
         $app->get("/view-departamento",[ParametricasController::class, 'viewDepartamento']);
         $app->patch("/estado-departamento/{Id}",[ParametricasController::class,'estadoDepartamento']);
         $app->get("/view-municipio",[ParametricasController::class, 'viewMunicipio']);
         $app->patch("/estado-municipio/{Id}",[ParametricasController::class,'estadoMunicipio']);
         $app->get("/view-corregimiento",[ParametricasController::class, 'viewCorregimiento']);
         $app->patch("/estado-corregimiento/{Id}",[ParametricasController::class,'estadoCorregimiento']);
         $app->get("/view-veredas_barrios",[ParametricasController::class, 'viewVeredas_barrios']);
         $app->patch("/estado-veredas_barrios/{Id}",[ParametricasController::class,'estadoVeredas_barrios']);
         $app->get("/view-escolaridad",[ParametricasController::class, 'viewEscolaridad']);
         $app->patch("/estado-escolaridad/{Id}",[ParametricasController::class,'estadoEscolaridad']);
         $app->get("/view-parentesco",[ParametricasController::class, 'viewParentesco']);
         $app->patch("/estado-parentesco/{Id}",[ParametricasController::class,'estadoParentesco']);
         $app->get("/view-orientacion_sexual",[ParametricasController::class, 'viewOrientacion_sexual']);
         $app->patch("/estado-orientacion_sexual/{Id}",[ParametricasController::class,'estadoOrientacion_sexual']);
         $app->get("/view-tipoinmueble",[ParametricasController::class, 'viewTipoinmueble']);
         $app->patch("/estado-tipoinmueble/{Id}",[ParametricasController::class,'estadoTipoinmueble']);
         $app->get("/view-tenencia",[ParametricasController::class, 'viewTenencia']);
         $app->patch("/estado-tenencia/{Id}",[ParametricasController::class,'estadoTenencia']);
         $app->get("/view-tipodocumento",[ParametricasController::class, 'viewTipodocumento']);
         $app->patch("/estado-tipodocumento/{Id}",[ParametricasController::class,'estadoTipodocumento']);
         $app->get("/view-logo",[ParametricasController::class, 'viewLogo']);
      });
   });
};