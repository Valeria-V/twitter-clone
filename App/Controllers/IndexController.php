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

		$this->view->usuario =array(
			'nome' => '',
			'email' => '',
			'senha' => '',
		);

		$this->view->erroCadastro = false;
		
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

		//tente isso
		try {
			$usuario->validarCadastro();

			if($usuario->getUsuarioPorEmail()) {
				throw new \Exception("E-mail já está sendo utilizado.",2); //se der o trow que é uma exceção ele para tudo e não salva
			}

			if($usuario->getUsuarioPorNome()) {
				throw new \Exception("Nome de usuário já existe.",3); //se der o trow que é uma exceção ele para tudo e não salva
			}
			
			$usuario->salvar(); //metodo salvar
			$this->render('cadastro');
		}
		//se não conseguir exibe a mensagem
		catch(\Exception $e) {
			echo $e->getMessage();

			$this->view->usuario =array(
				'nome' => $_POST['nome'],
				'email' => $_POST['email'],
				'senha' => $_POST['senha'],
			);

			$this->view->erroCadastro = true; 

			$this->render('inscreverse');
		}


		//erro

	}

}


?>