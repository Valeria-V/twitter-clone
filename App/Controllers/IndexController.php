<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action {

	public function index() {

		$this->render('index');
	}

	public function inscreverse() {
		$this->render('inscreverse');
	}

	public function registrar() {

		//echo '<pre>';
		//print_r($_POST);
		//echo '</pre>';	
		//receber os dados do formulário

		$usuario = Container::getModel('Usuario'); //instancia do usuario com conexao com o banco

		$usuario->__set('nome', $_POST['nome']); //recuperar objeto instanciado e setar atributos
		$usuario->__set('email', $_POST['email']);
		$usuario->__set('senha', $_POST['senha']);

		//echo '<pre>';
		//print_r($usuario);
		//echo '</pre>';
		//sucesso

		//if( $usuario->validarCadastro() ) { }

		try {
			$usuario->validarCadastro();
			$usuario->salvar(); //metodo salvar
		}
		catch(\Exception $e) {
			echo $e->getMessage();
		}


		//erro

	}

}


?>