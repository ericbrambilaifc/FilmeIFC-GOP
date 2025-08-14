<?php
require_once "ConexaoBD.php";
require "src/Util.php";

class ClienteDAO
{
    public static function inserir($dados)
    {
        $conexao = ConexaoBD::conectar();

        $nome = $dados['nome'];
        $imagem = Util::salvarArquivo();

        // Mude 'cliente' para 'Filme' aqui
        $sql = "INSERT INTO Filme (nome, imagem) VALUES (:nome, :imagem)";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':imagem', $imagem);
        $stmt->execute();
    }

    public static function listar()
    {
        $conexao = ConexaoBD::conectar();
        // Mude 'cliente' para 'Filme' aqui
        $sql = "SELECT * FROM Filme";
        $stmt = $conexao->prepare($sql);
        $stmt->execute();
        $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $clientes;
    }
}