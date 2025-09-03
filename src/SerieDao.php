<?php
require_once "ConexaoBD.php";

class SerieDAO
{
    public static function inserir($dados)
    {
        $conexao = ConexaoBD::conectar();

        // SALVAMENTO DIRETO DA IMAGEM (substituindo Util::salvarArquivo())
        $imagem = null;
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $diretorioUpload = "uploads/";
            
            // Verifica se o diretório existe, senão, cria
            if (!is_dir($diretorioUpload)) {
                mkdir($diretorioUpload, 0755, true);
            }
            
            $arquivoTmp = $_FILES['imagem']['tmp_name'];
            $nomeOriginal = basename($_FILES['imagem']['name']);
            $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));
            
            // Gera um nome único para o arquivo
            $nomeUnico = uniqid("img_", true) . "." . $extensao;
            $caminhoFinal = $diretorioUpload . $nomeUnico;

            // Move o arquivo
            if (move_uploaded_file($arquivoTmp, $caminhoFinal)) {
                $imagem = $nomeUnico;
                error_log("Arquivo salvo com sucesso: " . $imagem);
            } else {
                error_log("Falha ao mover arquivo");
                $imagem = 'default_serie.jpg';
            }
        } else {
            error_log("Arquivo não enviado ou com erro: " . ($_FILES['imagem']['error'] ?? 'N/A'));
            $imagem = 'default_serie.jpg';
        }

        $titulo = $dados['titulo'];
        $diretor = $dados['diretor'] ?? null;
        $elenco = $dados['elenco'] ?? null;
        $ano = $dados['ano'] ?? null;
        $temporadas = $dados['temporadas'] ?? null;
        $episodios = $dados['episodios'] ?? null;
        $idcategoria = $dados['idcategoria'] ?? null;
        $idclassificacao = $dados['idclassificacao'] ?? null;
        $detalhes = $dados['detalhes'] ?? null;

        $sql = "INSERT INTO serie (titulo, diretor, elenco, ano, temporadas, episodios, imagem, idcategoria, idclassificacao, detalhes) 
                VALUES (:titulo, :diretor, :elenco, :ano, :temporadas, :episodios, :imagem, :idcategoria, :idclassificacao, :detalhes)";
        
        $stmt = $conexao->prepare($sql);
        
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':diretor', $diretor);
        $stmt->bindParam(':elenco', $elenco);
        $stmt->bindParam(':ano', $ano);
        $stmt->bindParam(':temporadas', $temporadas);
        $stmt->bindParam(':episodios', $episodios);
        $stmt->bindParam(':imagem', $imagem);
        $stmt->bindParam(':idcategoria', $idcategoria);
        $stmt->bindParam(':idclassificacao', $idclassificacao);
        $stmt->bindParam(':detalhes', $detalhes);
        
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