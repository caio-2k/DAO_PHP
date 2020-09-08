<?php 

//Classe SQL para auxiliar os comandos de ação dentro do banco de dados
//Extendendo a classe PDO, que é nativa do PHP, iremos possuir todos os métodos
//do PDO (como bind param, execute, prepare) devido a sermos uma classe que extende
//ela, portanto iremos ter acesso a seus métodos (públicos).

class Sql extends PDO {

	//Variável para conexão
	private $conn;

	//Método construtor para conectar automaticamente ao banco de dados (no momento que a classe for instanciada)
	public function __construct(){

		// $this->conn = new PDO("tipo_sql:host=seu_host;dbname=nome_do_banco", "login", "senha");
		$this->conn = new PDO("mysql:host=localhost;dbname=dbphp7", "root", "");

	}

	//Função para realizar o foreach e associar os params
	private function setParams($statement, $parameters = array()){

		//Associando parâmetros, pecorrendo os params e associando (id: numero do id)
		foreach ($parameters as $key => $value) {
			
			//chamando a função para dar bindParam
			$this->setParam($statement, $key, $value);

		}

	}

	private function setParam($statement, $key, $value){

		//Recebendo o par chave-valor
		$statement->bindParam($key, $value);

	}

	//rawQuery na função age como um comando SQL
	//params por padrão é um array (deve armazenar dados)
	public function query($rawQuery, $params = array()){

		//statment será responsável por preparar o banco com o comando SQL informando em rawQuery
		$stmt = $this->conn->prepare($rawQuery);

		$this->setParams($stmt, $params);

		//Executa aqui e depois retorna (retornando na ultima linha)
		$stmt->execute();

		return $stmt;

	}

	//rawQuery na função age como um comando SQL
	//params por padrão é um array (deve armazenar dados)
	//A função irá retornar um array
	public function select($rawQuery, $params = array()):array
	{

		$stmt = $this->query($rawQuery, $params);

		return $stmt->fetchAll(PDO::FETCH_ASSOC);

	}

}

 ?>