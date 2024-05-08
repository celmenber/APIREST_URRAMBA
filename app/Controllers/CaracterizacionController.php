<?php
namespace  App\Controllers;
use App\Models\CaracterizacionEntry;

use App\Response\CustomResponse;
use App\Validation\Validator;
use Respect\Validation\Exceptions\Exception;
use Respect\Validation\Validator as v;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class CaracterizacionController {

    protected $customResponse;

    protected $caracterizacionEntry;

    protected $validator;

    public function __construct()
    {
    $this->customResponse = new CustomResponse();
    $this->caracterizacionEntry = new CaracterizacionEntry();
    $this->validator = new Validator();

    }
    

 public function consultaCaracterizacion($Id)
 {
        $data = caracterizacionEntry::select(
                "tbl_caracterizacion.*",
                "tbl_jefe_hogar.documentos AS Documentos",
                "tbl_jefe_hogar.nombres AS Nombres",
                "tbl_jefe_hogar.apellidos AS apellidos",
                "tbl_user_login.USERNAME AS Usuario",
                "tbl_user_login.ID_USER AS IdUsuario",
         )->join(
                "tbl_jefe_hogar", 
                "tbl_caracterizacion.id_jefe_hogar","=","tbl_jefe_hogar.ID")
        ->join(
                "tbl_user_login", 
                "tbl_caracterizacion.id_usuario","=","tbl_user_login.ID_USER")        
        ->where("tbl_caracterizacion.ID","=",$Id)->first();
         return $data;
 }

   /* DESDE AQUI SE PROCESO EL CRUE DE LA TABLA ASOCIACION */
    public function viewCaracterizacion(Response $response)
    {
        $CaracterizacionEntry = caracterizacionEntry::select(
                            "tbl_caracterizacion.*",
                            "tbl_jefe_hogar.documentos AS Documentos",
                            "tbl_jefe_hogar.nombres AS Nombres",
                            "tbl_jefe_hogar.apellidos AS apellidos",
                            "tbl_user_login.USERNAME AS Usuario",
                            "tbl_user_login.ID_USER AS IdUsuario",
                            )->join(
                                    "tbl_jefe_hogar", 
                                    "tbl_caracterizacion.id_jefe_hogar","=","tbl_jefe_hogar.ID")
                            ->join(
                                    "tbl_user_login", 
                                    "tbl_caracterizacion.id_usuario","=","tbl_user_login.ID_USER")->get();
        return $this->customResponse->is200Response($response,$CaracterizacionEntry);
    }

    public function viewCaracterizacionid(Response $response,$Id)
    {
        $CaracterizacionEntry = $this->consultaCaracterizacion($Id);
        return $this->customResponse->is200Response($response,$CaracterizacionEntry);
    }
    public function deleteCaracterizacion(Response $response,$Id)
    {
        $this->caracterizacionEntry->where(["ID"=>$Id])->delete();
        $responseMessage = "Caracterizacion fue eliminada successfully";
        return $this->customResponse->is200Response($response,$responseMessage);
    }


    public function createCaracterizacion(Request $request,Response $response)
    {
       $data = json_decode($request->getBody(),true);
       $this->validator->validate($request,[
        	"id_usuario"=>v::notEmpty(),
            "id_jefe_hogar"=>v::notEmpty(),
            "regimen_salud"=>v::notEmpty(),
            "tiene_discapacidad"=>v::notEmpty(),
            "indique_sudiscapacidad"=>v::notEmpty(),
            "se_encuentra_vinculado_asalud"=>v::notEmpty(),
            "mejor_condición_laboral_actual"=>v::notEmpty(),
            "tipo_remuneracion"=>v::notEmpty(),
            "ocupacion_uoficio"=>v::notEmpty(),
            "se_encuentra_afiliado_sistema_previsional"=>v::notEmpty(),
            "usted_esvictima_conflicto"=>v::notEmpty(),
            "ustedesta_inscrito_enRUV"=>v::notEmpty(),
            "personas_habitan_vivienda"=>v::notEmpty(),
            "tipo_vivienda"=>v::notEmpty(),
            "tenencia_vivienda"=>v::notEmpty(),
            "material_predominante_murosexteriores"=>v::notEmpty(),
            "material_predominante_cubierta_techo"=>v::notEmpty(),
            "material_predominante_piso"=>v::notEmpty(),
            "elagua_proviene_de"=>v::notEmpty(),
            "servicio_higienico_vivienda_esta"=>v::notEmpty(),
            "laelectricidad_proviene_de"=>v::notEmpty(),
            "medio_eliminacion_basura"=>v::notEmpty(),
            "tiene_sistema_cocina"=>v::notEmpty(),
            "metodo_utilizado_cocinar"=>v::notEmpty(),
            "acceso_telefono_fijo"=>v::notEmpty(),
            "acceso_telefono_movil"=>v::notEmpty(),
            "acceso_telefono_internet"=>v::notEmpty(),
            "servicios_sector_vias_acceso"=>v::notEmpty(),
            "servicios_sector_canchas_deportivas"=>v::notEmpty(),
            "servicios_sector_salon_comunal"=>v::notEmpty(),
            "servicios_sector_parques"=>v::notEmpty(),
            "componente_territorio_equipamiento_social"=>v::notEmpty(),
            "componente_territorio_estado_via"=>v::notEmpty(),
            "componente_territorio_frecuencia_rutas"=>v::notEmpty(),
            "componente_territorio_acceso_desarrollo"=>v::notEmpty(),
            "componente_territorio_desarrollados_beneficiende"=>v::notEmpty(),
            "componente_medicina_tradicional"=>v::notEmpty(),
            "componente_medicinaT_ejerce_territorio"=>v::notEmpty(),
            "aspecto_folclor_bailes_mapale"=>v::notEmpty(),
            "aspecto_folclor_bailes_sondenegro"=>v::notEmpty(),
            "aspecto_folclor_bailes_losnegritos"=>v::notEmpty(),
            "aspecto_folclor_bailes_seresese"=>v::notEmpty(),
            "aspecto_folclor_frecuenciab_mapale"=>v::notEmpty(),
            "aspecto_folclor_frecuenciab_sondenegro"=>v::notEmpty(),
            "aspecto_folclor_frecuenciab_losnegritos"=>v::notEmpty(),
            "aspecto_folclor_frecuenciab_seresese"=>v::notEmpty(),
            "aspecto_folclor_usadas_danzas_canto"=>v::notEmpty(),
         ]); 

        if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       } 
        
        try{
            $caracterizacionEntry = new CaracterizacionEntry;
        	$caracterizacionEntry->id_usuario                                        = $data['id_usuario'];
            $caracterizacionEntry->id_jefe_hogar                                     = $data['id_jefe_hogar'];
            $caracterizacionEntry->regimen_salud                                     = $data['regimen_salud'];
            $caracterizacionEntry->tiene_discapacidad                                = $data['tiene_discapacidad'];
            $caracterizacionEntry->indique_sudiscapacidad                            = $data['indique_sudiscapacidad'];
            $caracterizacionEntry->se_encuentra_vinculado_asalud                     = $data['se_encuentra_vinculado_asalud'];
            $caracterizacionEntry->tipo_remuneracion                                 = $data['tipo_remuneracion'];
            $caracterizacionEntry->ocupacion_uoficio                                 = $data['ocupacion_uoficio'];
            $caracterizacionEntry->se_encuentra_afiliado_sistema_previsional         = $data['se_encuentra_afiliado_sistema_previsional'];
            $caracterizacionEntry->mejor_condición_laboral_actual                    = $data['mejor_condición_laboral_actual'];
            $caracterizacionEntry->usted_esvictima_conflicto                         = $data['usted_esvictima_conflicto'];
            $caracterizacionEntry->ustedesta_inscrito_enRUV                          = $data['ustedesta_inscrito_enRUV'];
            $caracterizacionEntry->personas_habitan_vivienda                         = $data['personas_habitan_vivienda'];
            $caracterizacionEntry->tipo_vivienda                                     = $data['tipo_vivienda'];
            $caracterizacionEntry->tenencia_vivienda                                 = $data['tenencia_vivienda'];
            $caracterizacionEntry->material_predominante_murosexteriores             = $data['material_predominante_murosexteriores'];
            $caracterizacionEntry->material_predominante_cubierta_techo              = $data['material_predominante_cubierta_techo'];
            $caracterizacionEntry->material_predominante_piso                        = $data['material_predominante_piso'];
            $caracterizacionEntry->elagua_proviene_de                                = $data['elagua_proviene_de'];
            $caracterizacionEntry->servicio_higienico_vivienda_esta                  = $data['servicio_higienico_vivienda_esta'];
            $caracterizacionEntry->laelectricidad_proviene_de                        = $data['laelectricidad_proviene_de'];
            $caracterizacionEntry->medio_eliminacion_basura                          = $data['medio_eliminacion_basura'];
            $caracterizacionEntry->metodo_utilizado_cocinar                          = $data['metodo_utilizado_cocinar'];
            $caracterizacionEntry->acceso_telefono_fijo                              = $data['acceso_telefono_fijo'];
            $caracterizacionEntry->acceso_telefono_movil                             = $data['acceso_telefono_movil'];
            $caracterizacionEntry->acceso_telefono_internet                          = $data['acceso_telefono_internet'];
            $caracterizacionEntry->servicios_sector_vias_acceso                      = $data['servicios_sector_vias_acceso'];
            $caracterizacionEntry->servicios_sector_canchas_deportivas               = $data['servicios_sector_canchas_deportivas'];
            $caracterizacionEntry->servicios_sector_salon_comunal                    = $data['servicios_sector_salon_comunal'];
            $caracterizacionEntry->servicios_sector_parques                           = $data['servicios_sector_parques'];
            $caracterizacionEntry->componente_territorio_equipamiento_social          = $data['componente_territorio_equipamiento_social'];
            $caracterizacionEntry->componente_territorio_estado_via                   = $data['componente_territorio_estado_via'];
            $caracterizacionEntry->componente_territorio_frecuencia_rutas             = $data['componente_territorio_frecuencia_rutas'];
            $caracterizacionEntry->componente_territorio_acceso_desarrollo            = $data['componente_territorio_acceso_desarrollo'];
            $caracterizacionEntry->componente_territorio_desarrollados_beneficiende   = $data['componente_territorio_desarrollados_beneficiende'];
            $caracterizacionEntry->componente_medicina_tradicional                    = $data['componente_medicina_tradicional'];
            $caracterizacionEntry->componente_medicinaT_ejerce_territorio             = $data['componente_medicinaT_ejerce_territorio'];
            $caracterizacionEntry->aspecto_folclor_bailes_mapale                      = $data['aspecto_folclor_bailes_mapale'];
            $caracterizacionEntry->aspecto_folclor_bailes_sondenegro                  = $data['aspecto_folclor_bailes_sondenegro'];
            $caracterizacionEntry->aspecto_folclor_bailes_losnegritos                 = $data['aspecto_folclor_bailes_losnegritos'];
            $caracterizacionEntry->aspecto_folclor_bailes_seresese                    = $data['aspecto_folclor_bailes_seresese'];
            $caracterizacionEntry->aspecto_folclor_frecuenciab_mapale                 = $data['aspecto_folclor_frecuenciab_mapale'];
            $caracterizacionEntry->aspecto_folclor_frecuenciab_sondenegro             = $data['aspecto_folclor_frecuenciab_sondenegro'];
            $caracterizacionEntry->aspecto_folclor_frecuenciab_losnegritos            = $data['aspecto_folclor_frecuenciab_losnegritos'];
            $caracterizacionEntry->aspecto_folclor_frecuenciab_seresese               = $data['aspecto_folclor_frecuenciab_seresese'];
            $caracterizacionEntry->aspecto_folclor_usadas_danzas_canto                = $data['aspecto_folclor_usadas_danzas_canto'];
           
            $caracterizacionEntry->save();

        $responseMessage = array(
                        'msg'  => "Caracterizacion Guardada correctamente",
                        'datos' => $this->consultaCaracterizacion($caracterizacionEntry->id),
                        'id' => $caracterizacionEntry->id);

        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }

    public function editarCaracterizacion(Request $request,Response $response,$Id)
    {
       $data = json_decode($request->getBody(),true);
       $this->validator->validate($request,[
        	"id_usuario"=>v::notEmpty(),
            "id_jefe_hogar"=>v::notEmpty(),
            "regimen_salud"=>v::notEmpty(),
            "tiene_discapacidad"=>v::notEmpty(),
            "indique_sudiscapacidad"=>v::notEmpty(),
            "se_encuentra_vinculado_asalud"=>v::notEmpty(),
            "alternativas_describe_mejor_condición_laboral_actual"=>v::notEmpty(),
            "tipo_remuneracion"=>v::notEmpty(),
            "ocupacion_uoficio"=>v::notEmpty(),
            "se_encuentra_afiliado_sistema_previsional"=>v::notEmpty(),
            "usted_esvictima_conflicto"=>v::notEmpty(),
            "ustedesta_inscrito_enRUV"=>v::notEmpty(),
            "tipo_vivienda"=>v::notEmpty(),
            "tenencia_vivienda"=>v::notEmpty(),
            "material_construccion_predominante"=>v::notEmpty(),
            "material_predominante_cubierta_techo"=>v::notEmpty(),
            "material_predominante_piso"=>v::notEmpty(),
            "elagua_proviene_de"=>v::notEmpty(),
            "servicio_higienico_vivienda_esta"=>v::notEmpty(),
            "laelectricidad_proviene _de"=>v::notEmpty(),
            "medio_eliminacion_basura"=>v::notEmpty(),
            "metodo_utilizado_cocinar"=>v::notEmpty(),
            "usted_tiene_acceso_a"=>v::notEmpty(),
            "cuenta_conestos_servicios_sector"=>v::notEmpty()
         ]); 

        if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       } 
        
        try{
        CaracterizacionEntry::where('ID', '=', $Id)->update([
        	'id_usuario'                                => $data['id_usuario'],
            'id_jefe_hogar'                             => $data['id_jefe_hogar'],
            'regimen_salud'                             => $data['regimen_salud'],
            'tiene_discapacidad'                        => $data['tiene_discapacidad'],
            'indique_sudiscapacidad'                    => $data['indique_sudiscapacidad'],
            'se_encuentra_vinculado_asalud'             => $data['se_encuentra_vinculado_asalud'],
            'tipo_remuneracion'                         => $data['tipo_remuneracion'],
            'ocupacion_uoficio'                         => $data['ocupacion_uoficio'],
            'se_encuentra_afiliado_sistema_previsional' => $data['se_encuentra_afiliado_sistema_previsional'],
            'usted_esvictima_conflicto'                 => $data['usted_esvictima_conflicto'],
            'ustedesta_inscrito_enRUV'                  => $data['ustedesta_inscrito_enRUV'],
            'tipo_vivienda'                             => $data['tipo_vivienda'],
            'tenencia_vivienda'                         => $data['tenencia_vivienda'],
            'material_construccion_predominante'        => $data['material_construccion_predominante'],
            'material_predominante_cubierta_techo'      => $data['material_predominante_cubierta_techo'],
            'material_predominante_piso'                => $data['material_predominante_piso'],
            'elagua_proviene_de'                        => $data['elagua_proviene_de'],
            'servicio_higienico_vivienda_esta'          => $data['servicio_higienico_vivienda_esta'],
            'laelectricidad_proviene_de'                => $data['laelectricidad_proviene_de'],
            'medio_eliminacion_basura'                  => $data['medio_eliminacion_basura'],
            'metodo_utilizado_cocinar'                  => $data['metodo_utilizado_cocinar'],
            'usted_tiene_acceso_a'                      => $data['usted_tiene_acceso_a'],
            'cuenta_conestos_servicios_sector'          => $data['cuenta_conestos_servicios_sector'],
            'alternativas_describe_mejor_condición_laboral_actual' => $data['alternativas_describe_mejor_condición_laboral_actual'],
            ]);

        $responseMessage = array(
                        'msg'  => "Caracterizacion Guardada correctamente",
                        'datos' => $this->consultaCaracterizacion($Id),
                        'id' => $Id);

        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }
}