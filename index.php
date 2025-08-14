<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lumio OS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200 min-h-screen">
    <div class="max-w-6xl mx-auto p-4">
        <div class="bg-slate-800 rounded-lg p-4 mb-6 flex justify-between items-center">
            <h1 class="text-white text-xl font-semibold">GOP</h1>
            <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                Adicionar
            </button>
        </div>

        <div class="flex flex-wrap gap-3 mb-6">
            <button class="bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded-full text-sm transition-colors">
                Pesquise filmes, séries, animes
            </button>
            <button class="bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded-full text-sm transition-colors">
                Escolha
            </button>
            <button class="bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded-full text-sm transition-colors">
                Gênero
            </button>
            <button class="bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded-full text-sm transition-colors">
                Classificação
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                <div class="h-48 bg-gray-100 rounded-t-lg"></div>
                <div class="p-4">
                    <div class="h-4 bg-gray-200 rounded mb-2"></div>
                    <div class="h-3 bg-gray-200 rounded w-3/4"></div>
                </div>
            </div>

            
        </div>

        <!-- Load More Button -->
        <div class="text-center mt-8">
            <button class="bg-slate-700 hover:bg-slate-600 text-white px-6 py-3 rounded-md transition-colors">
                Carregar mais
            </button>
        </div>
    </div>
</body>
</html>