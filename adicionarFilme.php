<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Filme/Série</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-bg {
            background: linear-gradient(293deg, #07182F 0%, #094492 100%);
        }

        .file-upload-area {
            border: 2px dashed #d1d5db;
            transition: all 0.3s ease;
        }

        .file-upload-area:hover {
            border-color: #9ca3af;
            background-color: #f9fafb;
        }

        body {
            font-family: "Figtree", sans-serif;
        }
    </style>
</head>

<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-4xl">
        <!-- Título -->
        <h1 class="text-white text-2xl font-semibold text-center mb-8">
            Faça o cadastro de seu filme/série agora!
        </h1>

        <!-- Card Principal -->
        <div class="bg-gray-100 rounded-2xl p-8 shadow-xl">
            <!-- Navegação -->
            <div class="flex mb-8">
                <button class="flex items-center space-x-2 bg-gray-800 text-white px-4 py-2 rounded-lg">
                    <div class="w-2 h-2 bg-white rounded-full"></div>
                    <span class="text-sm">Filme</span>
                </button>
                <button class="flex items-center space-x-2 text-gray-600 px-4 py-2 rounded-lg ml-4">
                    <span class="text-sm">Série</span>
                </button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                <!-- Formulário -->
                <div class="space-y-4">
                    <div>
                        <input type="text" placeholder="Digite o nome do seu filme"
                            class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                    </div>

                    <div>
                        <input type="text" placeholder="Digite o nome do diretor"
                            class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                    </div>

                    <div>
                        <input type="text" placeholder="Digite o nome do elenco"
                            class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                    </div>

                    <div>
                        <input type="text" placeholder="Digite quantos oscars tem seu filme"
                            class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                    </div>

                    <div>
                        <textarea placeholder="Digite os detalhes do seu filme" rows="4"
                            class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm resize-none"></textarea>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-600 mb-2">Inserir a imagem da capa</p>
                        <div class="file-upload-area bg-white rounded-lg p-8 text-center cursor-pointer"
                            onclick="document.getElementById('cover-upload').click()">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <p class="text-gray-500 text-sm">Clique para fazer upload</p>
                            </div>
                        </div>
                        <input type="file" id="cover-upload" class="hidden" accept="image/*">
                    </div>
                </div>
            </div>

            <!-- Botão Cadastrar -->
            <div class="mt-8 flex justify-center">
                <button
                    class="bg-gray-800 hover:bg-gray-900 text-white px-12 py-3 rounded-lg transition-colors duration-200 font-medium">
                    Cadastrar
                </button>
            </div>
        </div>
    </div>

   
</body>

</html>