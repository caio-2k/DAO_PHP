<?php 

class Usuario {

	private $idusuario;
	private $deslogin;
	private $desenha;
	private $dtcadastro;

	public function getIdusuario(){
		return $this->idusuario;
	}

	public function setIdusuario($value){
		$this->idusuario = $value;
	}

	public function getDeslogin(){
		return $this->deslogin;
	}

	public function setDeslogin($value){
		$this->deslogin = $value;
	}

	public function getdesenha(){
		return $this->desenha;
	}

	public function setdesenha($value){
		$this->desenha = $value;
	}

	public function getDtcadastro(){
		return $this->dtcadastro;
	}

	public function setDtcadastro($value){
		$this->dtcadastro = $value;
	}
	
	//Função para retornar um usuário pelo seu ID (pasasdo por parametro)
	public function loadById($id){

		$sql = new Sql();

		//Select pela ID do usuário, por ser primary key só deve me retornar 1 linha
		//Porém o PDO por padrão nos retorna um array de arrays mesmo tendo 1 registro apenas
		//Passamos o idusuario e dentro do array o ID do usuario que no caso são os parameters
		//da função em sql.php
		$results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(
			":ID"=>$id
		));

		//verificando se existe registro
		if (count($results) > 0) {

			$this->setData($results[0]);

		}

	}

	//Retornando todos os usuários do banco de dados
	//Por não possuir this em sua estrutura podemos transforma-lo em um método
	//estático e assim portanto não precisamos instanciar o objeto
	//posso chamar usuário direto com o método (Usuario::getList())
	public static function getList(){

		$sql = new Sql();

		//Utilizando a função select e ordenando por login (assim então, listando)
		return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin;");

	}

	//Buscar usuário pelo login
	public static function search($login){

		$sql = new Sql();

		//Vai pegar oque eu digitar dentro da variável login e quando enviado para o param pra evitar sql
		//injection é aclasse que vai adicionar a aspas simples
		return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(
			':SEARCH'=>"%".$login."%"
		));

	}

	public function login($login, $password){

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND desenha = :PASSWORD", array(
			":LOGIN"=>$login,
			":PASSWORD"=>$password
		));

		if (count($results) > 0) {

			$this->setData($results[0]);

		} else {

			//Estourando uma exceção
			throw new Exception("Login e/ou senha inválidos.");

		}

	}

	public function setData($data){

		$this->setIdusuario($data['idusuario']);
		$this->setDeslogin($data['deslogin']);
		$this->setdesenha($data['desenha']);
		$this->setDtcadastro(new DateTime($data['dtcadastro']));

	}

	public function insert(){

		$sql = new Sql();

		$results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(
			':LOGIN'=>$this->getDeslogin(),
			':PASSWORD'=>$this->getdesenha()
		));

		if (count($results) > 0) {
			$this->setData($results[0]);
		}

	}

	public function update($login, $password){

		$this->setDeslogin($login);
		$this->setdesenha($password);

		$sql = new Sql();

		$sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, desenha = :PASSWORD WHERE idusuario = :ID", array(
			':LOGIN'=>$this->getDeslogin(),
			':PASSWORD'=>$this->getdesenha(),
			':ID'=>$this->getIdusuario()
		));

	}

	public function delete(){

		$sql = new Sql();

		$sql->query("DELETE FROM tb_usuarios WHERE idusuario = :ID", array(
			':ID'=>$this->getIdusuario()
		));

		$this->setIdusuario(0);
		$this->setDeslogin("");
		$this->setdesenha("");
		$this->setDtcadastro(new DateTime());

	}

	public function __construct($login = "", $password = ""){

		$this->setDeslogin($login);
		$this->setdesenha($password);

	}

	//Devolvendo o array em JSON quando for requisitado (pegando com GET)
	public function __toString(){

		return json_encode(array(
			"idusuario"=>$this->getIdusuario(),
			"deslogin"=>$this->getDeslogin(),
			"desenha"=>$this->getdesenha(),
			"dtcadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s") //Formatando
		));

	}

} 	
	


 ?>