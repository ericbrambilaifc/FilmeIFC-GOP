<?php
require_once 'src/FilmeDAO.php';
require_once 'src/SerieDAO.php';

// Verifica se é uma requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $dados = $_POST;
        
        // Verifica qual tipo foi selecionado no formulário
        $tipo = $_POST['tipo'] ?? 'filme'; // Default para filme se não especificado
        
        if ($tipo === 'filme') {
            FilmeDAO::inserir($dados);
            $mensagem = "Filme cadastrado com sucesso ✅";
        } elseif ($tipo === 'serie') {
            SerieDAO::inserir($dados);
            $mensagem = "Série cadastrada com sucesso ✅";
        } else {
            throw new Exception("Tipo inválido selecionado");
        }
        
        echo $mensagem;
        echo "<br>Voltar para <a href='/adicionarFilme.php'>Adicionar Filme/Série</a>";
        echo "<br>Ir para <a href='/newDesing.php'>Ver Filmes/Séries</a>";
        
    } catch (Exception $e) {
        echo "Erro no cadastro: " . $e->getMessage();
        echo "<br>Voltar para <a href='/adicionarFilme.php'>Adicionar Filme/Série</a>";
    }
} else {
    echo "Método de requisição inválido.";
    echo "<br>Voltar para <a href='/adicionarFilme.php'>Adicionar Filme/Série</a>";
}
?>