<?php namespace App\Models;
use CodeIgniter\Model;

class ActorModel extends Model{

    protected $table = 'actores';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre','anyoNacimiento','Pais'];
    //lo hace sin necesidad de ponerlo
    protected $useAutoIncrement = true;

   function getRelated($idPelicula){

        $sentence = 'select actores.* from actores, peliculas_actores where peliculas_actores.id_pelicula =:id: and peliculas_actores.id_actor = actores.id';
        $query = $this->query($sentence, ['id'=>$idPelicula]);

        return $query->getResult('array');
    }

}
?>