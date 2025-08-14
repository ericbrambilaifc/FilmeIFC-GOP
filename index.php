<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mona+Sans:ital,wght@0,200..900;1,200..900&display=swap"
        rel="stylesheet">
    <title>Lumio OS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<style>
    body {
        font-family: "Mona Sans", sans-serif;
    }
</style>

<body class="bg-gray-200 min-h-screen">
    <div class="max-w-6xl mx-auto p-4">
        <div class="bg-slate-800 rounded-lg p-4 mb-6 flex justify-between items-center">
            <h1 class="text-white text-2xl font-semibold">Filmes IFC+</h1>
            <a href="adicionarFilme.php" class="text-white py-4 px-12 rounded-3xl text-7 font-bold transition-colors"
                style="background: linear-gradient(94deg, #6E061C 1.22%, #E80D3A 100%)">
                Adicionar
            </a>
        </div>

        <div class="flex flex-wrap gap-3 mb-6 items-center">
            <div class="relative">
                <input type="text" placeholder="Pesquise filmes, séries"
                    class="w-full bg-gradient-to-r from-[#07182F] to-[#174D95] text-white placeholder-gray-300 px-8 py-2 rounded-full text-[18px] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-gradient-to-r focus:from-[#07182F] focus:to-[#174D95] transition-colors">
                <svg class="absolute right-3 top-2.5 h-6 w-6 text-gray-300" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>

            <select
                class="bg-gradient-to-r from-[#07182F] to-[#174D95] hover:opacity-90 text-white px-8 py-2 rounded-full text-[18px] transition-opacity whitespace-nowrap appearance-none text-center">
                <option class="bg-[#07182F] text-white">Filme</option>
                <option class="bg-[#174D95] text-white">Série</option>
            </select>

            <?php
            require_once 'src/ConexaoBD.php';
            require_once 'src/CategoriaDAO.php'; 
            
            $categorias = CategoriaDAO::listar();
            ?>

            <select
                class="bg-gradient-to-r from-[#07182F] to-[#174D95] hover:opacity-90 text-white px-4 py-2 rounded-full text-[18px] transition-opacity whitespace-nowrap appearance-none text-center"
                name="genero" id="genero">
                <option class="bg-[#174D95] text-white" value="">Selecione o Gênero</option>


                <?php foreach ($categorias as $categoria): ?>
                    <option class="bg-[#174D95] text-white"
                        value="<?php echo htmlspecialchars($categoria['idcategoria']); ?>">
                        <?php echo htmlspecialchars($categoria['nome']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <?php
            require_once 'src/ConexaoBD.php';
            require_once 'src/ClassificacaoDAO.php';
            
            $classificacoes = ClassificacaoDAO::listar();
            ?>

            <select
                class="bg-gradient-to-r from-[#07182F] to-[#174D95] hover:opacity-90 text-white px-4 py-2 rounded-full text-[18px] transition-opacity whitespace-nowrap appearance-none text-center"
                name="classificacao" id="classificacao">
                <option class="bg-[#174D95] text-white" value="">Selecione a Classificação</option>
                <?php foreach ($classificacoes as $classificacao): ?>
                    <option class="bg-[#174D95] text-white"
                        value="<?php echo htmlspecialchars($classificacao['idclassificacao']); ?>">
                        <?php echo htmlspecialchars($classificacao['nome']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

        </div>

        <!--   // card filmes -->
        <?php
        require_once 'src/FilmeDAO.php';
        $clientes = FilmeDAO::listar();

        foreach ($clientes as $cliente) {


            ?>
            <p><?= $cliente['nome'] ?></p>


            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow cursor-pointer">

                    <div class="h-48 bg-red-100 rounded-t-lg">
                        <img src="uploads/<?= $cliente['imagem'] ?>" alt="<?= $cliente['nome'] ?>" width="400">


                    </div>
                    <div class="p-4">
                        <div class="h-4 bg-red-200 rounded mb-2"></div>
                        <div class="h-3 bg-gray-200 rounded w-3/4"></div>
                    </div>
                </div>


            </div>
            <?php
        }
        ?>
    </div>
</body>

</html>