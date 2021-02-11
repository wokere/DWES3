<?php namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Models\PeliculaModel;
use App\Models\ActorModel;
use App\Models\DirectorModel;

class Peliculas extends ResourceController
{
    protected $modelName ="App\Models\PeliculaModel";
    protected $format = "json";
    function __construct(){
     helper('utils');
    }
    //opcion full data
    function index(){
        //sacamos todas las pelis
        $pelis = $this->model->findAll();
        $datosDefinitivos = $this->mapAll($pelis);
        //poner o no poner... 
        //$datosDefinitivos['links'] =  ["rel"=>"self","href"=>url("/peliculas/"),"action"=>"GET","types"=>["text/xml","application/json"]];
        return $this->genericResponse($datosDefinitivos,null,200);

    }
    function show($id=null){
        if(!$this->model->find($id)){
            return $this->genericResponse(null,array("id"=>"La pelicula no existe"),500);
        }
        return $this->genericResponse($this->getMappedFilmData($id),null,200);        
    }

    function delete($id=null){
        $this->model->delete($id);
        return $this->genericResponse("Pelicula Eliminada",null,200);
    }
    function create(){
        if($this->validate("pelicula")){
            //deberia tb mirar si ha indicado ids de actores o directores para meterlo en peliculas_actor/director?
            $id = $this->model->insert($this->request->getPost());
            return $this->genericResponse($this->model->find($id),null,200);
        }
       // $validation = \config\Services::validation();
        return $this->genericResponse(null,$this->validator->getErrors(),500);
    }
    function update($id=null){

        if(!$this->model->find($id)){
            return $this->genericResponse(null,array("id"=>"La pelicula no existe"),500);
        }
        $datos = $this->request->getRawInput();
        if($this->validate('pelicula')){
            $this->model->update($id,$datos);
            return $this->genericResponse($this->model->find($id),null,200);
        }
        //el controlador ya trae ese servicio de serie
       // $validation = \config\Services::validation();
       return $this->genericResponse(null,$this->validator->getErrors(),500);
    }
    
    private function getMappedFilmData ($id) {
        $peli = $this->model->find($id);
        $actorespeli = (new ActorModel())->getRelated($id);
        $directorespeli = (new DirectorModel())->getRelated($id);
        $mappedData = $this->mapSingleFilm($peli,$actorespeli,$directorespeli);
        return $mappedData;
    }
    private function mapAll($pelis){
        $datos = [];
        foreach($pelis as $peli){
            $mappedData = $this->getMappedFilmData($peli['id']);
            array_push($datos,$mappedData);
        }
        return $datos;
    }
    private function mapSingleFilm($dataFilm,$dataActores,$dataDirector)
    {
            $temPeli = [];
            foreach ($dataFilm as $key=>$value) {
                $temPeli[$key] = $value;
            }
            //añadimos los actores de la pelicula
            $temPeli['actores'] = $this->mapRelated("actor",$dataActores);
            //también los directores
            $temPeli['directores'] = $this->mapRelated('director',$dataDirector);
            //los links de la pelicula
            $temPeli['links'] = linksHATEOAS(url("/peliculas/".$dataFilm['id']),"self") ;
        
        return $temPeli;
    }
    private function mapRelated($tipo,$data){
        $temArr=[];
        foreach($data as $single){
            $tempData = [];
            foreach ($single as $key=>$value) {
                $tempData[$key] = $value;
            }
            $tempData['links'] = linksHATEOAS(url('/'.$tipo.'es/'.$single['id']),$tipo);
            array_push($temArr,$tempData);
        }
        return $temArr;
    }
    private function genericResponse($dato, $msg, $code)
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


}?>