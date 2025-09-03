<?php
require_once 'src/FilmeDAO.php';
$dados = $_POST;
FilmeDAO::inserir($dados);

echo "Cadastro realizado com sucesso ✅";
echo "Voltar para ";
?>
