<?php
require_once "ConexaoBD.php";
require "src/Util.php";

class FilmeDAO
{
    public static function inserir($dados)
    {
        $conexao = ConexaoBD::conectar();

        $titulo = $dados['titulo'];
        $diretor = $dados['diretor'];
        $elenco = $dados['elenco'];
        $ano = $dados['ano'];
        $oscar = $dados['oscar'];
        $imagem = Util::salvarArquivo();
        $idcategoria = $dados['idcategoria'];
        $idclassificacao = $dados['idclassificacao'];

        // Removido 'idfilme' da instrução INSERT para que o banco de dados cuide da numeração
        $sql = "INSERT INTO Filme (titulo, diretor, elenco, ano, oscar, imagem, idcategoria, idclassificacao) 
                VALUES (:titulo, :diretor, :elenco, :ano, :oscar, :imagem, :idcategoria, :idclassificacao)";
        
        $stmt = $conexao->prepare($sql);
        
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':diretor', $diretor);
        $stmt->bindParam(':elenco', $elenco);
        $stmt->bindParam(':ano', $ano);
        $stmt->bindParam(':oscar', $oscar);
        $stmt->bindParam(':imagem', $imagem);
        $stmt->bindParam(':idcategoria', $idcategoria);
        $stmt->bindParam(':idclassificacao', $idclassificacao);
        
        $stmt->execute();
    }

    public static function listar()
    {
        $conexao = ConexaoBD::conectar();
        
        $sql = "SELECT * FROM Filme";
        $stmt = $conexao->prepare($sql);
        $stmt->execute();
        $filmes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $filmes;
    }
}
?>