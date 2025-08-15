<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mona+Sans:ital,wght@0,200..900;1,200..900&display=swap"
        rel="stylesheet">
    <title>Cadastro de Filmes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: "Mona Sans", sans-serif;
            background: linear-gradient(293deg, #07182F 0%, #094492 100%);
        }

        .file-upload-area {
            border: 2px dashed #d1d5db;
            transition: all 0.3s ease;
        }

        .file-upload-area:hover {
            border-color: #3b82f6;
            background-color: #f8fafc;
        }
    </style>
</head>

<body class="bg-gray-200 min-h-screen">
    <?php
    // Inclua os arquivos DAO para buscar os dados do banco
    require_once 'src/ConexaoBD.php';
    require_once 'src/CategoriaDAO.php'; 
    require_once 'src/ClassificacaoDAO.php'; 
    
    $categorias = CategoriaDAO::listar();
    $classificacoes = ClassificacaoDAO::listar();
    ?>

    <h3 class="text-3xl text-white font-semibold text-center my-12">Faça o cadastro de seu filme/série agora!</h3>

    <div class="max-w-4xl mx-auto p-4">
        <div class="bg-gray-100 rounded-2xl p-8 shadow-xl">
            <div class="flex mb-8">
                <button class="flex items-center space-x-2 bg-gray-800 text-white px-4 py-2 rounded-lg">
                    <div class="w-2 h-2 bg-white rounded-full"></div>
                    <span class="text-sm">Filme</span>
                </button>
                <button class="flex items-center space-x-2 text-gray-600 px-4 py-2 rounded-lg ml-4">
                    <span class="text-sm">Série</span>
                </button>
            </div>

            <form action="cadastro.php" method="POST" enctype="multipart/form-data">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                    <div class="space-y-4">
                        <div>
                            <label for="titulo" class="block text-sm font-medium text-gray-700 mb-1">Título *</label>
                            <input type="text" name="titulo" id="titulo" placeholder="Digite o nome do seu filme"
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                required>
                        </div>

                        <div>
                            <label for="diretor" class="block text-sm font-medium text-gray-700 mb-1">Diretor</label>
                            <input type="text" name="diretor" id="diretor" placeholder="Digite o nome do diretor"
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        </div>

                        <div>
                            <label for="elenco" class="block text-sm font-medium text-gray-700 mb-1">Elenco</label>
                            <input type="text" name="elenco" id="elenco" placeholder="Digite o nome do elenco"
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="ano" class="block text-sm font-medium text-gray-700 mb-1">Ano</label>
                                <input type="number" name="ano" id="ano" placeholder="2024" min="1900" max="2030"
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            </div>
                            <div>
                                <label for="oscar" class="block text-sm font-medium text-gray-700 mb-1">Oscars</label>
                                <input type="number" name="oscar" id="oscar" placeholder="0" min="0"
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="idcategoria"
                                    class="block text-sm font-medium text-gray-700 mb-1">Categoria</label>
                                <select name="idcategoria" id="idcategoria"
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                    <option value="">Selecione a Categoria</option>
                                    <?php foreach ($categorias as $categoria): ?>
                                        <option value="<?= htmlspecialchars($categoria['idcategoria']); ?>">
                                            <?= htmlspecialchars($categoria['nomecategoria']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label for="idclassificacao"
                                    class="block text-sm font-medium text-gray-700 mb-1">Classificação</label>
                                <select name="idclassificacao" id="idclassificacao"
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                    <option value="">Selecione a Classificação</option>
                                    <?php foreach ($classificacoes as $classificacao): ?>
                                        <option value="<?= htmlspecialchars($classificacao['idclassificacao']); ?>">
                                            <?= htmlspecialchars($classificacao['nomeclassificacao']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="detalhes"
                                class="block text-sm font-medium text-gray-700 mb-1">Detalhes/Sinopse</label>
                            <textarea name="detalhes" id="detalhes" placeholder="Digite os detalhes do seu filme"
                                rows="4"
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm resize-none"></textarea>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="imagem" class="block text-sm font-medium text-gray-700 mb-2">Inserir a imagem da
                                capa</label>
                            <div class="file-upload-area bg-white rounded-lg p-8 text-center cursor-pointer"
                                onclick="document.getElementById('imagem').click()">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <p class="text-gray-500 text-sm">Clique para fazer upload</p>
                                    <p class="text-gray-400 text-xs mt-1">PNG, JPG, JPEG até 5MB</p>
                                </div>
                            </div>
                            <input type="file" name="imagem" id="imagem" class="hidden" accept="image/*">
                        </div>

                        <input type="hidden" name="tipo" value="filme">

                        </div>
                </div>

                <div class="mt-8 flex justify-center">
                    <button type="submit"
                        class="bg-gray-800 hover:bg-gray-900 text-white px-12 py-3 rounded-lg transition-colors duration-200 font-medium">
                        Cadastrar Filme
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>