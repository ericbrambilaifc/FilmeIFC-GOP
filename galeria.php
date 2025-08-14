<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h3>Meus Clientes</h3>
    <?php
    require_once 'src/ClienteDAO.php';
    $clientes = ClienteDAO::listar();

    foreach ($clientes as $cliente){

    
    ?>
    <p><?=$cliente['nome']?></p>
    <img src="uploads/<?=$cliente['imagem']?>" alt="<?=$cliente['nome']?>" width="200">
    <?php
    }
    ?>
</body>
</html>