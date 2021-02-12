<?php namespace App\Models;
use CodeIgniter\Model;

class PeliculaActorModel extends Model{
    protected $table = 'peliculas_actores';
    protected $allowedFields = ['id_actor','id_pelicula'];
} 

?>