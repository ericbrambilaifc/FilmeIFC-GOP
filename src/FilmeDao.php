<?php
require_once "ConexaoBD.php";
require_once "src/Util.php";

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
        $detalhes = $dados['detalhes']; 

        $sql = "INSERT INTO Filme (titulo, diretor, elenco, ano, oscar, imagem, idcategoria, idclassificacao, detalhes) 
                VALUES (:titulo, :diretor, :elenco, :ano, :oscar, :imagem, :idcategoria, :idclassificacao, :detalhes)";
        
        $stmt = $conexao->prepare($sql);
        
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':diretor', $diretor);
        $stmt->bindParam(':elenco', $elenco);
        $stmt->bindParam(':ano', $ano);
        $stmt->bindParam(':oscar', $oscar);
        $stmt->bindParam(':imagem', $imagem);
        $stmt->bindParam(':idcategoria', $idcategoria);
        $stmt->bindParam(':idclassificacao', $idclassificacao);
        $stmt->bindParam(':detalhes', $detalhes);
        
        $stmt->execute();
    }

    public static function listar()
    {
        $conexao = ConexaoBD::conectar();
        
        // Esta query irá buscar todos os filmes.
        // Adicionei joins para buscar os nomes da categoria e classificação, que podem ser úteis.
        $sql = "SELECT f.*, c.nomecategoria, cl.nomeclassificacao 
                FROM Filme f
                LEFT JOIN Categoria c ON f.idcategoria = c.idcategoria
                LEFT JOIN Classificacao cl ON f.idclassificacao = cl.idclassificacao";
        
        $stmt = $conexao->prepare($sql);
        $stmt->execute();
        $filmes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $filmes;
    }

    /**
     * Lista filmes por ID de categoria.
     * @param int $idcategoria O ID da categoria para filtrar.
     * @return array Um array de filmes que correspondem à categoria.
     */
    public static function listarPorCategoria($idcategoria)
    {
        $conexao = ConexaoBD::conectar();
        
        // A query agora usa a cláusula WHERE para filtrar os resultados.
        $sql = "SELECT f.*, c.nomecategoria, cl.nomeclassificacao 
                FROM Filme f
                LEFT JOIN Categoria c ON f.idcategoria = c.idcategoria
                LEFT JOIN Classificacao cl ON f.idclassificacao = cl.idclassificacao
                WHERE f.idcategoria = :idcategoria";
        
        $stmt = $conexao->prepare($sql);
        
        // Vincula o parâmetro da query com o valor passado para a função.
        $stmt->bindParam(':idcategoria', $idcategoria, PDO::PARAM_INT);
        $stmt->execute();
        
        $filmes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $filmes;
    }
}
?>