<?php namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Models\PeliculasModel;
use App\Models\ActoresModel;
use App\Models\DirectoresModel;

class Peliculas extends ResourceController
{
    protected $modelName ="App\Models\PeliculasModel";
    protected $format = "json";
}?>