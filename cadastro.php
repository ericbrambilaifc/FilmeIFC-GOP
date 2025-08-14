<?php
require_once 'src/FilmeDAO.php';
$dados = $_POST;
FilmeDAO::inserir($dados);

echo "Cliente inserido com sucesso! 😂";
?>