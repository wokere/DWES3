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
        $completedirectores = $this->map($directores);
        return $this->genericResponse($completedirectores,null,200);
    }
    public function show($id=null){
        $director = $this->model->where('id',$id)->findAll();
        $completedirector = $this->map($director);
        return $this->genericResponse($completedirector,null,200);
    }
    public function delete($id=null){
        $this->model->delete($id);
        return $this->genericResponse("director Eliminado",null,200);
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
        $directores = [];
        foreach ($data as $director) {
            $temAct = [];
            foreach ($director as $key=>$value) {
                $temAct[$key] = $value;
            }
            $temAct['links'] = [
                ["rel"=>"self","href"=>url("/directores/".$director['id']),"action"=>"GET","types"=>["text/xml","application/json"]],
                ["rel"=>"self","href"=>url("/directores/".$director['id']),"action"=>"PUT","types"=>["application/x-www-form-encoded"]],
                ["rel"=>"self","href"=>url("/directores/".$director['id']),"action"=>"PATCH","types"=>["application/x-www-form-encoded"]],
                ["rel"=>"self","href"=>url("/directores/".$director['id']),"action"=>"DELETE","types"=>["application/x-www-form-encoded"]]
            ];
            
            array_push($directores, $temAct);
        }
        return $directores;
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

