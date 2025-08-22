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

        

              $sql = "INSERT INTO Filme (itulo, diretor, elenco, ano, oscar, imagem, idcategoria, idclassificacao, detalhes) 
                VALUES (?, ?, ?, ?, ?,?,?,?,?)";
        
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

          public static function listar() {
        $conexao = ConexaoBD::conectar();
        $sql = "select * from filme";
        $stmt = $conexao->prepare($sql);
        $stmt->execute();
        $evento = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $evento;
        
       
    }
        
}

    

?>