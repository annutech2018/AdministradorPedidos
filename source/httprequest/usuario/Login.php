<?php
include '../../query/UsuarioDao.php';
include '../../cripto/Cripto.php';

header('Content-Type: application/json');
$cripto = new Cripto();
$respuesta = '0';
$nombre = filter_input(INPUT_POST, 'usuario');
$password = base64_encode(Cripto::encriptar(filter_input(INPUT_POST, 'password')));
//$password = filter_input(INPUT_POST, 'password');
$usuarioDao = new UsuarioDao();
$usuario = $usuarioDao->getUsuario($nombre, $password);
if ($usuario->getId() > 0)
{
    session_start();
    $_SESSION['agente']=$usuario->getId();
    $_SESSION['nick']=$usuario->getUsuario();
    $_SESSION['tipo']=$usuario->getTipo();
    $respuesta = $_SESSION['agente'];
    $tipo = $_SESSION['tipo'];
}
echo "{\"usuario_id\":".$respuesta.",\"usuario_tipo\":".$tipo."}";