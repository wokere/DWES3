<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\PeliculaModel;
use App\Models\ActorModel;
use App\Models\DirectorModel;
use App\Models\PeliculaActorModel;
use App\Models\PeliculaDirectorModel;

class Peliculas extends ResourceController
{
    protected $modelName ="App\Models\PeliculaModel";
    protected $format = "json";
    public function __construct()
    {
        helper('utils');
    }
    //opcion full data
    public function index()
    {
        //sacamos todas las pelis
        $pelis = $this->model->findAll();
        $datosDefinitivos = $this->mapAll($pelis);
        //poner o no poner...
        //$datosDefinitivos['links'] =  ["rel"=>"self","href"=>url("/peliculas/"),"action"=>"GET","types"=>["text/xml","application/json"]];
        return $this->genericResponse($datosDefinitivos, null, 200);
    }
    public function show($id=null)
    {
        if (!$this->model->find($id)) {
            return $this->genericResponse(null, array("id"=>"La pelicula no existe"), 500);
        }
        return $this->genericResponse($this->getMappedFilmData($id), null, 200);
    }

    public function delete($id=null)
    {
        $this->model->delete($id);
        return $this->genericResponse("Pelicula Eliminada", null, 200);
    }
    public function create()
    {
        //como para indicar en las tablas de relacion la pelicula ya ha debido estar introducida
        //debo comprobar primero si el id del actor o director existe antes de crear la pelicula para
        //que no se de el caso de que, al no existir, cree la pelicula y luego de error al crear los otros,
        //aprovecho las reglas de peliculaNueva para hacer la comprobación con una is_not_unique
        if ($this->validate("peliculaNueva")) {
            //aunque haya validado al no dejar ya hacer trim en las relgas hay q mirar que el titulo no exista ya en la bbdd...
            $trimmedPost = trimStringArray($this->request->getPost());
            if($this->model->getByTitle($trimmedPost['titulo'])){
                return $this->genericResponse(null, "la película ya existe", 500);
            }
            $id = $this->model->insert($trimmedPost);
            if ($this->request->getPost('id_director')) {
                // hago trim también , aunque sin hacerlo ya lo hacia...pero por si algun dia cambia y no lo hace
                (new PeliculaDirectorModel())->insert([
                    'id_director'=> trim($this->request->getPost('id_director')),
                    'id_pelicula'=> $id
                ]);
            }
            if ($this->request->getPost('actores')) {
                //eliminar ids repetidas de actores
                $idsactores = $this->request->getPost('actores');
                $modelPelAct = new PeliculaActorModel();
                foreach ($idsactores as $idactor) {
                    $modelPelAct->insert([
                        'id_actor'=>trim($idactor),
                        'id_pelicula'=>$id
                    ]);
                }
            }
           
            // responder con la pelicula completa con su actor y director y lo que tenga
            return $this->show($id);
        }
        // $validation = \config\Services::validation();
        return $this->genericResponse(null, $this->validator->getErrors(), 500);
    }
    public function update($id=null)
    {
        //lo comprobamos aqui y no en el validador porque no viene con el rawinput si no q se pasa por parametro al controlador ( o algo asi??)
        if (!$this->model->find($id)) {
            return $this->genericResponse(null, array("id"=>"La pelicula no existe"), 500);
        }
        $datos = $this->request->getRawInput();
        if ($this->validate('pelicula')) {
            //comprobamos que el titulo no esté repetido
            if($this->model->getByTitle(trim($datos['titulo']))){
                return $this->genericResponse(null, "la película ya existe, no puede haber 2 nombres iguales", 500);
            }
            $this->model->update($id,trimStringArray($datos));
            return $this->show($id);
        }
        return $this->genericResponse(null, $this->validator->getErrors(), 500);
    }
    
    private function getMappedFilmData($id)
    {
        $peli = $this->model->find($id);
        $actorespeli = (new ActorModel())->getRelated($id);
        $directorespeli = (new DirectorModel())->getRelated($id);
        $mappedData = $this->mapSingleFilm($peli, $actorespeli, $directorespeli);
        return $mappedData;
    }
    private function mapAll($pelis)
    {
        $datos = [];
        foreach ($pelis as $peli) {
            $mappedData = $this->getMappedFilmData($peli['id']);
            array_push($datos, $mappedData);
        }
        return $datos;
    }
    private function mapSingleFilm($dataFilm, $dataActores, $dataDirector)
    {
        $temPeli = [];
        foreach ($dataFilm as $key=>$value) {
            $temPeli[$key] = $value;
        }
        //añadimos los actores de la pelicula
        $temPeli['actores'] = $this->mapRelated("actor", $dataActores);
        //también los directores
        $temPeli['directores'] = $this->mapRelated('director', $dataDirector);
        //los links de la pelicula
        $temPeli['links'] = linksHATEOAS(url("/peliculas/".$dataFilm['id']), "self") ;
        
        return $temPeli;
    }
    private function mapRelated($tipo, $data)
    {
        $temArr=[];
        foreach ($data as $single) {
            $tempData = [];
            foreach ($single as $key=>$value) {
                $tempData[$key] = $value;
            }
            $tempData['links'] = linksHATEOAS(url('/'.$tipo.'es/'.$single['id']), $tipo);
            array_push($temArr, $tempData);
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
}
