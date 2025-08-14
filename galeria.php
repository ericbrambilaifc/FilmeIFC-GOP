<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h3>Meus Filmes</h3>
    <?php
    
    require_once 'src/FilmeDAO.php';

  
    $filmes = FilmeDAO::listar();

  
    foreach ($filmes as $filme){
    ?>
    <p><?=$filme['titulo']?></p>
    <img src="uploads/<?=$filme['imagem']?>" alt="<?=$filme['titulo']?>" width="200">
    <?php
    }
    ?>
</body>
</html>