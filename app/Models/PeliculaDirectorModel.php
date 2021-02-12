<?php namespace App\Models;
use CodeIgniter\Model;

class PeliculaDirectorModel extends Model{
    protected $table = 'peliculas_directores';
    protected $allowedFields = ['id_director','id_pelicula'];
} ?>