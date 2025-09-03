<?php
require_once "ConexaoBD.php";
require_once "src/Util.php";

class SerieDAO
{
    public static function inserir($dados)
    {
        $conexao = ConexaoBD::conectar();

        $titulo = $dados['titulo'];
        $diretor = $dados['diretor'];
        $elenco = $dados['elenco'];
        $ano = $dados['ano'];
        $temporadas = $dados['temporadas']; 
        $imagem = Util::salvarArquivo();
        $idcategoria = $dados['idcategoria'];
        $idclassificacao = $dados['idclassificacao'];
        $detalhes = $dados['detalhes'];

        $sql = "INSERT INTO Serie (titulo, diretor, elenco, ano, temporadas, imagem, idcategoria, idclassificacao, detalhes)
            VALUES (:titulo, :diretor, :elenco, :ano, :temporadas, :imagem, :idcategoria, :idclassificacao, :detalhes)";

        $stmt = $conexao->prepare($sql);

        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':diretor', $diretor);
        $stmt->bindParam(':elenco', $elenco);
        $stmt->bindParam(':ano', $ano);
        $stmt->bindParam(':temporadas', $temporadas);
        $stmt->bindParam(':imagem', $imagem);
        $stmt->bindParam(':idcategoria', $idcategoria);
        $stmt->bindParam(':idclassificacao', $idclassificacao);
        $stmt->bindParam(':detalhes', $detalhes);

        $stmt->execute();
    }

    public static function listar()
    {
        $conexao = ConexaoBD::conectar();
        $sql = "SELECT f.*, c.nomecategoria, cl.nomeclassificacao
            FROM serie f
            JOIN categoria c ON f.idcategoria = c.idcategoria
            JOIN classificacao cl ON f.idclassificacao = cl.idclassificacao";
        $stmt = $conexao->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function listarPorClassificacao($idClassificacao)
    {
        $conexao = ConexaoBD::conectar();
        $sql = "SELECT f.*, c.nomecategoria, cl.nomeclassificacao
            FROM serie f
            JOIN categoria c ON f.idcategoria = c.idcategoria
            JOIN classificacao cl ON f.idclassificacao = cl.idclassificacao
            WHERE f.idclassificacao = :idclassificacao";
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':idclassificacao', $idClassificacao, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function listarPorCategoria($idCategoria)
    {
        $conexao = ConexaoBD::conectar();
        $sql = "SELECT f.*, c.nomecategoria, cl.nomeclassificacao
            FROM serie f
            JOIN categoria c ON f.idcategoria = c.idcategoria
            JOIN classificacao cl ON f.idclassificacao = cl.idclassificacao
            WHERE f.idcategoria = :idcategoria";
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':idcategoria', $idCategoria, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>