<?php
require_once "ConexaoBD.php";
require_once "src/Util.php";

class SerieDAO
{
    public static function inserir($dados)
    {
        $conexao = ConexaoBD::conectar();

        $titulo = $dados['titulo'];
        $diretor = $dados['diretor'] ;
        $elenco = $dados['elenco'] ;
        $ano = $dados['ano'] ;
        $imagem = Util::salvarArquivo();
        $temporadas = $dados['temporadas'] ;
       
        
        $idcategoria = $dados['idcategoria'] ;
        $idclassificacao = $dados['idclassificacao'] ;
        $detalhes = $dados['detalhes'] ;
         $episodios = $dados['episodios'] ;

        $sql = "INSERT INTO serie (titulo, diretor, elenco, ano, imagem, temporadas, idcategoria, idclassificacao, detalhes,episodios) 
                VALUES (:titulo, :diretor, :elenco, :ano, :imagem, :temporadas,   :idcategoria, :idclassificacao, :detalhes,:episodios)";
        
        $stmt = $conexao->prepare($sql);
        
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':diretor', $diretor);
        $stmt->bindParam(':elenco', $elenco);
        $stmt->bindParam(':ano', $ano);
         $stmt->bindParam(':imagem', $imagem);
        $stmt->bindParam(':temporadas', $temporadas);
       
        $stmt->bindParam(':idcategoria', $idcategoria);
        $stmt->bindParam(':idclassificacao', $idclassificacao);
        $stmt->bindParam(':detalhes', $detalhes);
        $stmt->bindParam(':episodios', $episodios);
        
        $stmt->execute();
    }

    public static function listar() {
        $conexao = ConexaoBD::conectar();
        $sql = "SELECT s.*, c.nomecategoria, cl.nomeclassificacao
            FROM serie s
            JOIN categoria c ON s.idcategoria = c.idcategoria
            JOIN classificacao cl ON s.idclassificacao = cl.idclassificacao";
        $stmt = $conexao->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function listarPorClassificacao($idClassificacao) {
        $conexao = ConexaoBD::conectar();
        $sql = "SELECT s.*, c.nomecategoria, cl.nomeclassificacao
                FROM serie s
                JOIN categoria c ON s.idcategoria = c.idcategoria
                JOIN classificacao cl ON s.idclassificacao = cl.idclassificacao
                WHERE s.idclassificacao = :idclassificacao";
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':idclassificacao', $idClassificacao, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function listarPorCategoria($idCategoria) {
        $conexao = ConexaoBD::conectar();
        $sql = "SELECT s.*, c.nomecategoria, cl.nomeclassificacao
                FROM serie s
                JOIN categoria c ON s.idcategoria = c.idcategoria
                JOIN classificacao cl ON s.idclassificacao = cl.idclassificacao
                WHERE s.idcategoria = :idcategoria";
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':idcategoria', $idCategoria, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>