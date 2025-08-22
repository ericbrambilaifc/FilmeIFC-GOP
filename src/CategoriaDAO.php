<?php
require_once "ConexaoBD.php";
require_once "src/Util.php";

class CategoriaDAO
{
    public static function inserir($dados)
    {
        $conexao = ConexaoBD::conectar();

        $nome = $dados['nomecategoria'];
        $sql = "INSERT INTO categoria (nomecategoria) VALUES (:nomecategoria)";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':nomecategoria', $nome);
        $stmt->execute();
    }

    public static function listar()
    {
        $conexao = ConexaoBD::conectar();
        $sql = "SELECT * FROM categoria";
        $stmt = $conexao->prepare($sql);
        $stmt->execute();
        $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $categorias;
    }
}

