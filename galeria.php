<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Filmes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: "Figtree", sans-serif;
        }
    </style>
</head>

<body class="bg-gray-200 min-h-screen">
    <div class="max-w-xl mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Adicionar Novo Filme</h1>
        
        <form action="cadastro.php" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
            
            <div class="mb-4">
                <label for="titulo" class="block text-gray-700 font-semibold mb-2">Título:</label>
                <input type="text" name="titulo" id="titulo" class="w-full px-3 py-2 border rounded-md" required>
            </div>
            
            <div class="mb-4">
                <label for="diretor" class="block text-gray-700 font-semibold mb-2">Diretor:</label>
                <input type="text" name="diretor" id="diretor" class="w-full px-3 py-2 border rounded-md">
            </div>

            <div class="mb-4">
                <label for="elenco" class="block text-gray-700 font-semibold mb-2">Elenco:</label>
                <input type="text" name="elenco" id="elenco" class="w-full px-3 py-2 border rounded-md">
            </div>
            
            <div class="mb-4">
                <label for="ano" class="block text-gray-700 font-semibold mb-2">Ano:</label>
                <input type="number" name="ano" id="ano" class="w-full px-3 py-2 border rounded-md">
            </div>
            
            <div class="mb-4">
                <label for="oscar" class="block text-gray-700 font-semibold mb-2">Oscar:</label>
                <input type="number" name="oscar" id="oscar" class="w-full px-3 py-2 border rounded-md">
            </div>
            
            <div class="mb-4">
                <label for="idcategoria" class="block text-gray-700 font-semibold mb-2">ID Categoria:</label>
                <input type="number" name="idcategoria" id="idcategoria" class="w-full px-3 py-2 border rounded-md">
            </div>
            
            <div class="mb-4">
                <label for="idclassificacao" class="block text-gray-700 font-semibold mb-2">ID Classificação:</label>
                <input type="number" name="idclassificacao" id="idclassificacao" class="w-full px-3 py-2 border rounded-md">
            </div>
            
            <div class="mb-4">
                <label for="imagem" class="block text-gray-700 font-semibold mb-2">Imagem:</label>
                <input type="file" name="imagem" id="imagem" class="w-full">
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 transition-colors">
                Cadastrar Filme
            </button>
        </form>
    </div>
</body>
</html>