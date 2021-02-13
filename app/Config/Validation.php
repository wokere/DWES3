<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var string[]
	 */
	public $ruleSets = [
		Rules::class,
		FormatRules::class,
		FileRules::class,
		CreditCardRules::class,

	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array<string, string>
	 */
	public $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------
	public $actorNuevo = [
		'nombre' => 'required|min_length[1]|max_length[50]',
		'anyoNacimiento'=> 'required|min_length[4]|max_length[4]',
		'Pais'=>'required|min_length[2]|max_length[50]'
	];
	public $actor = [
		'nombre' => 'if_exist|min_length[1]|max_length[50]',
		'anyoNacimiento'=> 'if_exist|min_length[4]|max_length[4]',
		'Pais'=>'if_exist|min_length[2]|max_length[50]'
	];
	public $directorNuevo = [
		'nombre' => 'required|min_length[1]|max_length[50]',
		'anyoNacimiento'=> 'required|min_length[4]|max_length[4]',
		'Pais'=>'required|min_length[2]|max_length[50]'
	];
	public $director = [
		'nombre' => 'if_exist|min_length[1]|max_length[50]',
		'anyoNacimiento'=> 'if_exist|min_length[4]|max_length[4]',
		'Pais'=>'if_exist|min_length[2]|max_length[50]'
	];
	public $pelicula = [
		//aunque el is_unique aqui es un poco useless porque necesito hacer trim antes de mirar...
		'titulo' => 'if_exist|is_unique[peliculas.titulo]|min_length[1]|max_length[50]',
		'anyo' => 'if_exist|exact_length[4]',
		'duracion'=>'if_exist|min_length[1]|max_length[50]'
	];
	public $peliculaNueva = [
		'titulo'=>'required|is_unique[peliculas.titulo]|min_length[1]|max_length[50]',
		'anyo' => 'required|min_length[4]|max_length[4]',
		'duracion'=>'required|min_length[1]|max_length[50]',
		'actores.*' =>'required_without[id_director]|if_exist|is_not_unique[actores.id]',
		'id_director' =>'required_without[actores]|is_not_unique[directores.id]',

	];

}
