<?php
require_once "ConexaoBD.php";
require_once "src/Util.php";

class SerieDAO
{
    public static function inserir($dados)
    {
        $conexao = ConexaoBD::conectar();

        $titulo = $dados['titulo'];
        $diretor = $dados['diretor'] ?? null;
        $elenco = $dados['elenco'] ?? null;
        
        // CORRIGIDO: Tratar campos numéricos vazios como NULL
        $ano = (!empty($dados['ano']) && is_numeric($dados['ano'])) ? (int)$dados['ano'] : null;
        $temporadas = (!empty($dados['temporadas']) && is_numeric($dados['temporadas'])) ? (int)$dados['temporadas'] : null;
        $episodios = (!empty($dados['episodios']) && is_numeric($dados['episodios'])) ? (int)$dados['episodios'] : null;
        $idcategoria = (!empty($dados['idcategoria']) && is_numeric($dados['idcategoria'])) ? (int)$dados['idcategoria'] : null;
        $idclassificacao = (!empty($dados['idclassificacao']) && is_numeric($dados['idclassificacao'])) ? (int)$dados['idclassificacao'] : null;
        
        $imagem = Util::salvarArquivo();
        $detalhes = $dados['detalhes'] ?? null;

        $sql = "INSERT INTO Serie (titulo, diretor, elenco, ano, temporadas, episodios, imagem, idcategoria, idclassificacao, detalhes)
            VALUES (:titulo, :diretor, :elenco, :ano, :temporadas, :episodios, :imagem, :idcategoria, :idclassificacao, :detalhes)";

        $stmt = $conexao->prepare($sql);

        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':diretor', $diretor);
        $stmt->bindParam(':elenco', $elenco);
        $stmt->bindParam(':ano', $ano, PDO::PARAM_INT);
        $stmt->bindParam(':temporadas', $temporadas, PDO::PARAM_INT);
        $stmt->bindParam(':episodios', $episodios, PDO::PARAM_INT);
        $stmt->bindParam(':imagem', $imagem);
        $stmt->bindParam(':idcategoria', $idcategoria, PDO::PARAM_INT);
        $stmt->bindParam(':idclassificacao', $idclassificacao, PDO::PARAM_INT);
        $stmt->bindParam(':detalhes', $detalhes);

        $stmt->execute();
    }

    public static function listar()
    {
        $conexao = ConexaoBD::conectar();
        $sql = "SELECT s.*, c.nomecategoria, cl.nomeclassificacao
            FROM serie s
            LEFT JOIN categoria c ON s.idcategoria = c.idcategoria
            LEFT JOIN classificacao cl ON s.idclassificacao = cl.idclassificacao";
        $stmt = $conexao->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function listarPorClassificacao($idClassificacao)
    {
        $conexao = ConexaoBD::conectar();
        $sql = "SELECT s.*, c.nomecategoria, cl.nomeclassificacao
            FROM serie s
            LEFT JOIN categoria c ON s.idcategoria = c.idcategoria
            LEFT JOIN classificacao cl ON s.idclassificacao = cl.idclassificacao
            WHERE s.idclassificacao = :idclassificacao";
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':idclassificacao', $idClassificacao, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function listarPorCategoria($idCategoria)
    {
        $conexao = ConexaoBD::conectar();
        $sql = "SELECT s.*, c.nomecategoria, cl.nomeclassificacao
            FROM serie s
            LEFT JOIN categoria c ON s.idcategoria = c.idcategoria
            LEFT JOIN classificacao cl ON s.idclassificacao = cl.idclassificacao
            WHERE s.idcategoria = :idcategoria";
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':idcategoria', $idCategoria, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>