<?php
require_once 'src/FilmeDAO.php';
$dados = $_POST;
FilmeDAO::inserir($dados);

echo "Cadastro realizado com sucesso ✅";
echo "Voltar para <a href='/adicionarFilme.php'>Adcionar Filme/Série</a>";
echo "</br>";
echo "Ir para <a href='/newDesing.php'>Ver Filmes/Série</a>";
?>
