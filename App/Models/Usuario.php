<?php

namespace App\Models;

use MF\Model\Model;

class Usuario extends Model {

    private $id;
    private $nome = '';
    private $email = '';
    private $senha = '';
    private $errors = [];

    //salvar

    //validar se um cadastro pode ser feito

    //recuperar um usuario por email

    public function __get($atributo) {
        return $this->$atributo;
    }

    public function __set($atributo, $valor) {
    $this->$atributo = $valor;
    }


    // metodo salvar, armazena no banco
    public function salvar (){

    $query = "insert into usuarios(nome, email, senha)values(:nome, :email, :senha)";
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':nome', $this->__get('nome'));
    $stmt->bindValue(':email', $this->__get('email'));
    $stmt->bindValue(':senha', $this->__get('senha')); //md5() -> hash de 32 caracteres
    $stmt->execute();

    return $this;
    }

    //
    /**
     * @method validarCadastro
     * 
     * validar se um cadastro poed ser feito verificando as varaveis de entrada
     * 
     * @return Bool "true se está ok"
     * @throws Exception
     */
    public function validarCadastro(){
        $valido = true;

        if (empty($this->nome)) {
            $this->errors['nome'] = "Nome é obrigatório";
            $valido = false; 
        } else {
            $name = ($this->nome);
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z0-9\_]*$/",$name)) {
                $this->errors['nome'] = "Somente letras e digitos";
                $valido = false; 
            }
        }
        
        if (empty($this->email)) {
            $this->errors['email'] = "Email é obrigatório";
            $valido = false; 
        } else {
            $email = ($this->email);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->errors['email'] = "formato de e-mail inválido";
                $valido = false; 
            }
        }
            
        if (empty($this->senha)) {
            $this->errors['senha'] = "Senha é obrigatória";
            $valido = false; 
        } else {
            $senha = ($this->senha);
            // check if URL address syntax is valid
            if (!preg_match("/^[-a-zA-Z0-9\+\&\@\#\/\%\=\_|]*$/",$senha)) {
                $this->errors['senha'] = "formato inválido";
                $valido = false; 
            }    
        }
        //cria exceção de para a validação
        if(!$valido) {
            throw new \Exception(print_r($this->errors,true),1);
        }
        return $valido;
    }

    //recuperar um usuário por e-mail
    public function getUsuarioPorEmail(){
        $query = "select email from usuarios where email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC); //array associativo
        # code...
    }

    public function getUsuarioPorNome(){
        $query = "select nome from usuarios where nome = :nome";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC); //array associativo
        # code...
    }
}