<?php
require_once "ConexaoBD.php";
require "src/Util.php";

class CategoriaDAO
{
    public static function inserir($dados)
    {
        $conexao = ConexaoBD::conectar();

        $nome = $dados['nome'];
        $sql = "INSERT INTO categoria (nome) VALUES (:nome)";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':nome', $nome);
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