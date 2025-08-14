<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">
    <title>Lumio OS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<style>
    body {
        font-family: "Figtree", sans-serif;
    }
</style>

<body class="bg-gray-200 min-h-screen">
    <div class="max-w-6xl mx-auto p-4">
        <div class="bg-slate-800 rounded-lg p-4 mb-6 flex justify-between items-center">
            <h1 class="text-white text-xl font-semibold">GOP</h1>
            <button class="text-white px-4 py-2 rounded-md text-sm font-medium transition-colors"
                style="background: linear-gradient(94deg, #6E061C 1.22%, #E80D3A 100%)">
                Adicionar
            </button>

        </div>

        <div class="flex flex-wrap gap-3 mb-6 items-center">
            <div class="relative">
                <input type="text" placeholder="Pesquise filmes, séries"
                    class="w-full bg-gradient-to-r from-[#07182F] to-[#174D95] text-white placeholder-gray-300 px-4 py-2 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-gradient-to-r focus:from-[#07182F] focus:to-[#174D95] transition-colors">
                <svg class="absolute right-3 top-2.5 h-4 w-4 text-gray-300" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>

            <button
                class="bg-gradient-to-r from-[#07182F] to-[#174D95] hover:opacity-90 text-white px-4 py-2 rounded-full text-sm transition-opacity whitespace-nowrap">
                Escolha
            </button>

            <button
                class="bg-gradient-to-r from-[#07182F] to-[#174D95] hover:opacity-90 text-white px-4 py-2 rounded-full text-sm transition-opacity whitespace-nowrap">
                Gênero
            </button>

            <button
                class="bg-gradient-to-r from-[#07182F] to-[#174D95] hover:opacity-90 text-white px-4 py-2 rounded-full text-sm transition-opacity whitespace-nowrap">
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