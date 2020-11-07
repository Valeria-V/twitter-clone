<?php

namespace MF\Model;

use App\Connection;

class Container {

	public static function getModel($model) {
		$class = "\\App\\Models\\".ucfirst($model); //instanciar modelo
		$conn = Connection::getDb(); //instanciar classe com o banco

		return new $class($conn); //retorna objeto já com a conexão
	}
}


?>