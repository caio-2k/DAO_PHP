<?php 

require_once("./config.php");

// -------------- Select do que tem no banco de dados -------------

// $sql = new Sql();

// $usuarios = $sql->select("SELECT * FROM tb_usuarios");
// $usuarios = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = 2");

// echo json_encode($usuarios);
// -----------------------------------------------------------------

//Carrega um usuário
// $root = new Usuario();
// $root->loadbyId(3);
// echo $root; //Por ser um objeto vai chamar o toString e gerar um JSON

//Carrega uma lista de usuários
//Static não precisa instanciar
// $lista = Usuario::getList();
// echo json_encode($lista);

//Carrega uma lista de usuários buscando pelo login
//Static não precisa instanciar
// $search = Usuario::search("ro");
// echo json_encode($search);

//carrega um usuário usando o login e a senha
// $usuario = new Usuario();
// $usuario->login("root", "!@#$");
// echo $usuario;

/*
//Criando um novo usuário
$aluno = new Usuario("aluno", "@lun0");
$aluno->insert();
echo $aluno;
*/
/*

//Alterar um usuário
$usuario = new Usuario();

$usuario->loadById(8);

$usuario->update("professor", "!@#$%¨&*");

echo $usuario;
*/

// $usuario = new Usuario();

// $usuario->loadById(7);

// $usuario->delete();

// echo $usuario;
 ?>