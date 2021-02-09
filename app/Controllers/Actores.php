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
    
    //GET
    public function index()
    {  
        $actores= $this->model->findAll();
        $completeActores = $this->map($actores);
        return $this->genericResponse($completeActores,null,200);
    }
    public function show($id=null){
        $actor = $this->model->where('id',$id)->findAll();
        $completeActor = $this->map($actor);
        return $this->genericResponse($completeActor,null,200);
    }
    public function delete($id=null){
        $this->model->delete($id);
        return $this->genericResponse("Actor Eliminado",null,200);
    }
    public function create(){
        //esto valida los request por osmosis?!
        if($this->validate('profesional')){
         //No guarda el país...
            $id = $this->model->insert($this->request->getPost());
            return $this->genericResponse($this->model->find($id),null,200);
        }
        $validation = \config\Services::validation();
        return $this->genericResponse(null,$validation->getErrors(),500);
    }
         public function update($id=null){
        if(!$this->model->find($id)){
            return $this->genericResponse(null,array("id"=>"el jugaodr no existe"),500);
        }
        $datos = $this->request->getRawInput();
        if($this->validate('profesional')){
            //tampoco guarda el país..
            $this->model->update($id,$datos);
            return $this->genericResponse($this->model->find($id),null,200);

        }
        $validation = \config\Services::validation();
        return $this->genericResponse(null,$validation->getErrors(),500);   
    }
    //aux
    public function map($data)
    {
        $actores = [];
        foreach ($data as $actor) {
            $temAct = [];
            foreach ($actor as $key=>$value) {
                $temAct[$key] = $value;
            }
            $temAct['links'] = [
                ["rel"=>"self","href"=>url("/actores/".$actor['id']),"action"=>"GET","types"=>["text/xml","application/json"]],
                ["rel"=>"self","href"=>url("/actores/".$actor['id']),"action"=>"PUT","types"=>["application/x-www-form-encoded"]],
                ["rel"=>"self","href"=>url("/actores/".$actor['id']),"action"=>"PATCH","types"=>["application/x-www-form-encoded"]],
                ["rel"=>"self","href"=>url("/actores/".$actor['id']),"action"=>"DELETE","types"=>["application/x-www-form-encoded"]]
            ];
            
            array_push($actores, $temAct);
        }
        return $actores;
    }
    function genericResponse($dato, $msg, $code)
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

