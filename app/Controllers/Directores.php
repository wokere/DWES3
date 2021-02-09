<?php namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Models\DirectoresModel;

class Directores extends ResourceController
{
    protected $modelName ="App\Models\DirectoresModel";
    protected $format = "json";
}?>