<?php

/*namespace  App\Controllers;
use App\Models\Empresa;
use App\Requests\CustomRequestHandler;
use App\Response\CustomResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;
use App\Validation\Validator;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;

class GuestEntryEmpresaController
{

    protected $customResponse;

    protected $empresaentry;

    protected $validator;

    public function __construct()
    {
    $this->customResponse = new CustomResponse();
    $this->empresaentry = new Empresa();
    $this->validator = new Validator();

    }
    /* DESDE AQUI SE PROCESO EL CRUE DE LA TABLA USER LOGIN *
    public function viewEmpresa(Response $response)
    {
        $Empresaentry = $this->empresaentry->get();
        return $this->customResponse->is200Response($response,$Empresaentry);
    }

    public function viewEmpresaid(Response $response,$id)
    {
        $Empresaentry = $this->empresaentry->where(["ID_Empresa"=>$id])->get();
        return $this->customResponse->is200Response($response,$Empresaentry);
    }

       public function deleteEmpresa(Request $request,Response $response,$id)
    {
        $Empresaentry = $this->empresaentry->where(["ID_Empresa"=>$id])->delete();
        $responseMessage = "el Empresa fue eliminada successfully";
       return $this->customResponse->is200Response($response,$responseMessage);
       // return $this->customResponse->is200Response($response,$Terceroentries);
    }

 public function createEmpresa(Request $request,Response $response)
    {
        $data = json_decode($request->getBody(),true);
        $this->validator->validate($request,[
            "Numero"=>v::notEmpty(),
            "FechaCreacion"=>v::notEmpty(),
            "ID_TipoEmpresa"=>v::notEmpty(),
            "ID_GAES"=>v::notEmpty(),
            "ID_Ciudad"=>v::notEmpty(),
            "RazonSocial"=>v::notEmpty(),
            "NumeroRUT"=>v::notEmpty(),
            "Direccion"=>v::notEmpty(),
            "Telefono"=>v::notEmpty(),
            "Correo"=>v::notEmpty(),
            "Website"=>v::notEmpty(),
            "Logo"=>v::notEmpty(),
            "Mision"=>v::notEmpty(),
            "Vision"=>v::notEmpty(),
            "Valores"=>v::notEmpty(),
            "ObjetivoGeneral"=>v::notEmpty(),
            "ObjetivosEspecificos"=>v::notEmpty(),
            "ProblemaSolucion"=>v::notEmpty(),
            "SegmentosClientes"=>v::notEmpty(),
            "Propuestavalor"=>v::notEmpty(),
            "CanalesAtencion"=>v::notEmpty(),
            "FuentesIngresos"=>v::notEmpty(),
       ]); 

       if($this->validator->failed())
       {
           $responseMessage = $this->validator->errors;
           return $this->customResponse->is400Response($response,$responseMessage);
       }

         try{
            $Empresaentry = new empresaentry;
            $Empresaentry->ID_TipoEmpresa = $data['ID_TipoEmpresa'];
            $Empresaentry->ID_GAES = $data['ID_GAES'];
            $Empresaentry->ID_Ciudad = $data['ID_Ciudad'];
            $Empresaentry->RazonSocial = $data['RazonSocial'];
            $Empresaentry->NumeroRUT = $data['NumeroRUT'];
            $Empresaentry->Direccion = $data['Direccion'];
            $Empresaentry->Telefono = $data['Telefono'];
            $Empresaentry->Correo = $data['Correo'];
            $Empresaentry->Website = $data['Website'];
            $Empresaentry->Logo = $data['Logo'];
            $Empresaentry->Mision = $data['Mision'];
            $Empresaentry->Vision = $data['Vision'];
            $Empresaentry->Valores = $data['Valores'];
            $Empresaentry->ObjetivoGeneral = $data['ObjetivoGeneral'];
            $Empresaentry->ObjetivosEspecificos = $data['ObjetivosEspecificos'];
            $Empresaentry->ProblemaSolucion = $data['ProblemaSolucion'];
            $Empresaentry->SegmentosClientes = $data['SegmentosClientes'];
            $Empresaentry->Propuestavalor = $data['Propuestavalor'];
            $Empresaentry->CanalesAtencion = $data['CanalesAtencion'];
            $Empresaentry->FuentesIngresos = $data['FuentesIngresos'];
        $Empresaentry->save();
        $responseMessage = array('msg' => "Empresa editada correctamente",'id' => $id);
        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }
    }



 public function editEmpresa(Request $request,Response $response,$id)
    {
       $data = json_decode($request->getBody(),true);
        $this->validator->validate($request,[
            "Numero"=>v::notEmpty(),
            "FechaCreacion"=>v::notEmpty(),
            "ID_TipoEmpresa"=>v::notEmpty(),
            "ID_GAES"=>v::notEmpty(),
            "ID_Ciudad"=>v::notEmpty(),
            "RazonSocial"=>v::notEmpty(),
            "NumeroRUT"=>v::notEmpty(),
            "Direccion"=>v::notEmpty(),
            "Telefono"=>v::notEmpty(),
            "Correo"=>v::notEmpty(),
            "Website"=>v::notEmpty(),
            "Logo"=>v::notEmpty(),
            "Mision"=>v::notEmpty(),
            "Vision"=>v::notEmpty(),
            "Valores"=>v::notEmpty(),
            "ObjetivoGeneral"=>v::notEmpty(),
            "ObjetivosEspecificos"=>v::notEmpty(),
            "ProblemaSolucion"=>v::notEmpty(),
            "SegmentosClientes"=>v::notEmpty(),
            "Propuestavalor"=>v::notEmpty(),
            "CanalesAtencion"=>v::notEmpty(),
            "FuentesIngresos"=>v::notEmpty(),
       ]);

        if($this->validator->failed())
        {
            $responseMessage = $this->validator->errors;
            return $this->customResponse->is400Response($response,$responseMessage);
        }

        try{
            $Empresaentry = empresaentry::find($id);
            $Empresaentry->ID_TipoEmpresa = $data['ID_TipoEmpresa'];
            $Empresaentry->ID_GAES = $data['ID_GAES'];
            $Empresaentry->ID_Ciudad = $data['ID_Ciudad'];
            $Empresaentry->RazonSocial = $data['RazonSocial'];
            $Empresaentry->NumeroRUT = $data['NumeroRUT'];
            $Empresaentry->Direccion = $data['Direccion'];
            $Empresaentry->Telefono = $data['Telefono'];
            $Empresaentry->Correo = $data['Correo'];
            $Empresaentry->Website = $data['Website'];
            $Empresaentry->Logo = $data['Logo'];
            $Empresaentry->Mision = $data['Mision'];
            $Empresaentry->Vision = $data['Vision'];
            $Empresaentry->Valores = $data['Valores'];
            $Empresaentry->ObjetivoGeneral = $data['ObjetivoGeneral'];
            $Empresaentry->ObjetivosEspecificos = $data['ObjetivosEspecificos'];
            $Empresaentry->ProblemaSolucion = $data['ProblemaSolucion'];
            $Empresaentry->SegmentosClientes = $data['SegmentosClientes'];
            $Empresaentry->Propuestavalor = $data['Propuestavalor'];
            $Empresaentry->CanalesAtencion = $data['CanalesAtencion'];
            $Empresaentry->FuentesIngresos = $data['FuentesIngresos'];
        $Empresaentry->save();
        $responseMessage = array('msg' => "Empresa Guardada correctamente",'id' => $Empresaentry->id);
        return $this->customResponse->is200Response($response,$responseMessage);
        }catch(Exception $err){
        $responseMessage = array("err" => $err->getMessage());
        return $this->customResponse->is400Response($response,$responseMessage);
       }

      /*   $this->Gaesentry->where(["id"=>$id])->update([
             'Numero'=>CustomRequestHandler::getParam($request,'Numero'),
             'FechaCreacion'=>CustomRequestHandler::getParam($request,'FechaCreacion')
        ]);

        $responseMessage = "El gaes fue editado con éxito";

        return $this->customResponse->is200Response($response,$responseMessage); *
    }
}*/