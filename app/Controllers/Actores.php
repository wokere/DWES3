<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ActorModel;

class Actores extends ResourceController
{
    protected $modelName ="App\Models\ActorModel";
    protected $format = "json";
    public function __construct()
    {
        helper('utils');
    }
    //index,show,update,... son los metodos q usara resource para la ruta
    //si no los encuentra cuando se hace la peticion pues no funcionara y te dira
    //que no está implementado

    public function index()
    {
        $actores= $this->model->findAll();
        $completeActores = $this->mapAll($actores);
        return $this->genericResponse($completeActores, null, 200);
    }
    public function show($id=null)
    {
        if (!$this->model->find($id)) {
            return $this->genericResponse(null, array("id"=>"el Actor no existe"), 500);
        }
        $actor = $this->model->find($id);
        $completeActor = $this->getSingleActorMapped($actor);
        return $this->genericResponse($completeActor, null, 200);
    }
    public function delete($id=null)
    {
        $this->model->delete($id);
        return $this->genericResponse("Actor Eliminado", null, 200);
    }
    public function create()
    {
        if ($this->validate('actorNuevo')) {
            $id = $this->model->insert(trimStringArray($this->request->getPost()));
            return $this->genericResponse($this->model->find($id), null, 200);
        }
       // $validation = \config\Services::validation();
        return $this->genericResponse(null, $this->validator->getErrors(), 500);
    }
    public function update($id=null)
    {
        if (!$this->model->find($id)) {
            return $this->genericResponse(null, array("id"=>"el Actor no existe"), 500);
        }
        $datos = $this->request->getRawInput();
        if ($this->validate('profesional')) {
            //tampoco guarda el país..
            $this->model->update($id, trimStringArray($datos));
            return $this->genericResponse($this->model->find($id), null, 200);
        }
       // $validation = \config\Services::validation();
        return $this->genericResponse(null, $this->validator->getErrors(), 500);
    }
    
    private function mapAll($actores)
    {
        $datos = [];
        foreach ($actores as $actor) {
            $mappedData = $this->getSingleActorMapped($actor);
            array_push($datos, $mappedData);
        }
        return $datos;
    }
    private function getSingleActorMapped($actor)
    {
        $temAct = [];
        foreach ($actor as $key=>$value) {
            $temAct[$key] = $value;
        }
        $temAct['links'] = linksHATEOAS(url("/actores/".$actor['id']), "self") ;
        
        return $temAct;
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
