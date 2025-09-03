<?php
require_once "ConexaoBD.php";
require_once "src/Util.php";

class SerieDAO
{
    public static function inserir($dados)
    {
        $conexao = ConexaoBD::conectar();

        $titulo = $dados['titulo'];
<<<<<<< HEAD
        $diretor = $dados['diretor'] ?? null;
        $elenco = $dados['elenco'] ?? null;
        $ano = $dados['ano'] ?? null;
        $temporadas = $dados['temporadas'] ?? null;
        $episodios = $dados['episodios'] ?? null;
        $imagem = Util::salvarArquivo();
        $idcategoria = $dados['idcategoria'] ?? null;
        $idclassificacao = $dados['idclassificacao'] ?? null;
        $detalhes = $dados['detalhes'] ?? null;
        $imagemBanner = Util::salvarArquivo();


        $sql = "INSERT INTO serie (titulo, diretor, elenco, ano, temporadas, episodios, imagem, idcategoria, idclassificacao, detalhes, imagemBanner) 
                VALUES (:titulo, :diretor, :elenco, :ano, :temporadas, :episodios, :imagem, :idcategoria, :idclassificacao, :detalhes, :imagemBanner)";

=======
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
        
>>>>>>> 236adbfc864eac61cccb8083bc427f1a8124d982
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
<<<<<<< HEAD
        $stmt->bindParam(':imagemBanner', $imagemBanner);

=======
        $stmt->bindParam(':episodios', $episodios);
        
>>>>>>> 236adbfc864eac61cccb8083bc427f1a8124d982
        $stmt->execute();
    }

    public static function listar()
    {
        $conexao = ConexaoBD::conectar();
        $sql = "SELECT s.*, c.nomecategoria, cl.nomeclassificacao
            FROM serie s
            JOIN categoria c ON s.idcategoria = c.idcategoria
            JOIN classificacao cl ON s.idclassificacao = cl.idclassificacao";
        $stmt = $conexao->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function listarPorClassificacao($idClassificacao)
    {
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

    public static function listarPorCategoria($idCategoria)
    {
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
