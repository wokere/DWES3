<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\DirectorModel;

class directores extends ResourceController
{
    protected $modelName ="App\Models\DirectorModel";
    protected $format = "json";
    public function __construct()
    {
        helper('utils');
    }
    //index,show,update,... son los metodos q usara resource para la ruta
    //si no los encuentra cuando se hace la peticion pues no funcionara y te dira
    //que no está implementado
    
    //GET
    public function index()
    {
        $directores= $this->model->findAll();
        $completedirectores = $this->mapAll($directores);
        return $this->genericResponse($completedirectores, null, 200);
    }

    public function show($id=null)
    {
        if (!$this->model->find($id)) {
            return $this->genericResponse(null, array("id"=>"el Director no existe"), 500);
        }
       $director = $this->model->find($id);
       $completedirector = $this->getSingleDirectorMapped($director);
        return $this->genericResponse($completedirector, null, 200);
    }
    public function delete($id=null)
    {
        $this->model->delete($id);
        return $this->genericResponse("director Eliminado", null, 200);
    }
    public function create()
    {
        if ($this->validate('profesional')) {
            $id = $this->model->insert($this->request->getPost());
            return $this->genericResponse($this->model->find($id), null, 200);
        }
      //  $validation = \config\Services::validation();
        return $this->genericResponse(null, $this->validator->getErrors(), 500);
    }
    public function update($id=null)
    {
        if (!$this->model->find($id)) {
            return $this->genericResponse(null, array("id"=>"el Director no existe"), 500);
        }
        $datos = $this->request->getRawInput();
        if ($this->validate('profesional')) {
            //tampoco guarda el país..
            $this->model->update($id, $datos);
            return $this->genericResponse($this->model->find($id), null, 200);
        }
       // $validation = \config\Services::validation();
        return $this->genericResponse(null,$this->validator->getErrors(), 500);
    }
    //aux
    private function mapAll($directores){
        $datos = [];
        foreach($directores as $director){
            $mappedData = $this->getSingleDirectorMapped($director);
            array_push($datos,$mappedData);
        }
        return $datos;
    }
    private function getSingleDirectorMapped($director)
    {
            $temDir = [];
            foreach ($director as $key=>$value) {
                $temDir[$key] = $value;
            }
            $temDir['links'] = linksHATEOAS(url("/directores/".$director['id']),"self") ;
        
        return $temDir;
    }
    public function genericResponse($dato, $msg, $code)
    {
        if ($code == 200) {
            return $this->respond(array(
                "data"=>$dato,
                "code"=>$code
            ));
        } else {
            return $this->respond(array(
                "msj"=>$msg,
                "code"=>$code
            ));
        }
    }
}
