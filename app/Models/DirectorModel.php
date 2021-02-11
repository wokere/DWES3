<?php namespace App\Models;
use CodeIgniter\Model;

class DirectorModel extends Model{

    protected $table = 'directores';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre','anyoNacimiento','Pais'];

    function getRelated($idPelicula){

        $sentence = 'select directores.* from directores, peliculas_directores where peliculas_directores.id_pelicula =:id: and peliculas_directores.id_director = directores.id';
        $query = $this->query($sentence, ['id'=>$idPelicula]);

        return $query->getResult('array');
    }
}
?>