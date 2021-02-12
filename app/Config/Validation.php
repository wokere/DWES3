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
	public $profesional = [
		'nombre' => 'required|min_length[1]|max_length[50]',
		'anyoNacimiento'=> 'required|min_length[4]|max_length[4]',
		'Pais'=>'required|min_length[2]|max_length[50]'
	];
	public $pelicula = [
		'titulo'=>'required|min_length[1]|max_length[50]',
		'anyo' => 'required|min_length[4]|max_length[4]',
		'duracion'=>'required|min_length[1]|max_length[50]'
	];
	public $peliculaNueva = [
		'titulo'=>'required|min_length[1]|max_length[50]',
		'anyo' => 'required|min_length[4]|max_length[4]',
		'duracion'=>'required|min_length[1]|max_length[50]',
		'actores.*' =>'required_without[id_director]',
		'id_director' =>'required_without[actores]',

	];

}
