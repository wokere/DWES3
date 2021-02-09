<?php namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Models\ActoresModel;

class Actores extends ResourceController
{
    protected $modelName ="App\Models\ActoresModel";
    protected $format = "json";
}
?>