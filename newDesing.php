<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filmes IFC+</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<style>
    body {
        font-family: "Mona Sans", sans-serif;
        background: linear-gradient(180deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    }
</style>

<body class="min-h-screen text-white">
    <nav class="flex items-center justify-start px-8 ms-40 py-6 space-x-8">
        <a href="newDesing.php" class="text-gray-300 hover:text-white transition-colors">home</a>
        <a href="newDesing.php?tipo=filme" class="text-gray-300 hover:text-white transition-colors">filmes</a>
        <a href="newDesing.php?tipo=serie" class="text-gray-300 hover:text-white transition-colors">séries</a>
    </nav>

    <div class="max-w-7xl mx-auto px-8">
        <?php
        require_once 'src/FilmeDAO.php';
        require_once 'src/SerieDAO.php';
        require_once 'src/ClassificacaoDAO.php';
        require_once 'src/CategoriaDAO.php';

        $tipo = $_GET['tipo'] ?? 'filme';
        $idClassificacao = $_GET['classificacao'] ?? null;
        $idCategoria = $_GET['categoria'] ?? null;

        $items = [];
        $itemsDestaque = null;

        if ($tipo === 'serie') {
            if ($idClassificacao && $idClassificacao !== 'null') {
                $items = SerieDAO::listarPorClassificacao($idClassificacao);
            } elseif ($idCategoria && $idCategoria !== 'null') {
                $items = SerieDAO::listarPorCategoria($idCategoria);
            } else {
                $items = SerieDAO::listar();
            }
        } else { // 'filme'
            if ($idClassificacao && $idClassificacao !== 'null') {
                $items = FilmeDAO::listarPorClassificacao($idClassificacao);
            } elseif ($idCategoria && $idCategoria !== 'null') {
                $items = FilmeDAO::listarPorCategoria($idCategoria);
            } else {
                $items = FilmeDAO::listar();
            }
        }

        $itemsDestaque = !empty($items) ? $items[0] : null;

        $filmes = FilmeDAO::listar();
        $series = SerieDAO::listar();
        $classificacoes = ClassificacaoDAO::listar();
        $categorias = CategoriaDAO::listar();
        ?>

        <!-- Destaque -->
        <section class="relative h-96 rounded-2xl overflow-hidden mb-12"
            style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.6)), url('uploads/<?= $itemsDestaque ? htmlspecialchars($itemsDestaque['imagem']) : 'gladiador.jpg' ?>'); background-size: cover; background-position: center;">
            <div class="absolute inset-0 flex items-center">
                <div class="px-12 max-w-2xl">
                    <h1 class="text-5xl font-bold mb-4">
                        <?= $itemsDestaque ? htmlspecialchars($itemsDestaque['titulo']) : ' ' ?> <!-- se nao tem nada fica string vazia -->
                    </h1>
                    <p class="text-lg text-gray-200 mb-8 leading-relaxed">
                        <?= $itemsDestaque && !empty($itemsDestaque['detalhes']) ? htmlspecialchars($itemsDestaque['detalhes']) : ' ' ?> <!-- se nao tem nada fica string vazia -->
                    </p>
                    <div class="flex space-x-4">
                   
                    </div>
                </div>
            </div>
        </section>

        <!-- Filtros -->
        <div class="flex justify-end space-x-4 mb-8">
            <div class="relative">
                <select onchange="window.location.href=this.value"
                    class="bg-gray-700/50 backdrop-blur-sm border border-gray-600/50 text-white px-4 py-2 rounded-full appearance-none cursor-pointer pr-8">
                    <option value="newDesing.php?tipo=filme" <?= $tipo === 'filme' ? 'selected' : '' ?>>Filme</option>
                    <option value="newDesing.php?tipo=serie" <?= $tipo === 'serie' ? 'selected' : '' ?>>Série</option>
                </select>
                <svg class="absolute right-2 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

            <!-- Classificação -->
            <div class="relative">
                <button id="dropdownClassificacaoButton"
                    class="bg-gray-700/50 backdrop-blur-sm border border-gray-600/50 text-white px-4 py-2 rounded-full flex items-center space-x-2">
                    <span>Classificação</span>
                    <svg class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul id="dropdownClassificacaoMenu"
                    class="hidden absolute right-0 mt-2 w-48 bg-gray-800/90 backdrop-blur-sm border border-gray-700/50 rounded-xl shadow-2xl z-20 overflow-hidden">
                    <li>
                        <a href="?tipo=<?= $tipo ?>&classificacao=null"
                            class="block px-4 py-2 hover:bg-gray-700/50 transition-colors text-sm">Todas</a>
                    </li>
                    <?php foreach ($classificacoes as $classificacao): ?>
                        <li>
                            <a href="?tipo=<?= $tipo ?>&classificacao=<?= htmlspecialchars($classificacao['idclassificacao']) ?>"
                                class="block px-4 py-2 hover:bg-gray-700/50 transition-colors text-sm">
                                <?= htmlspecialchars($classificacao['nomeclassificacao']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Categoria -->
            <div class="relative">
                <button id="dropdownCategoriaButton"
                    class="bg-gray-700/50 backdrop-blur-sm border border-gray-600/50 text-white px-4 py-2 rounded-full flex items-center space-x-2">
                    <span>Gênero</span>
                    <svg class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul id="dropdownCategoriaMenu"
                    class="hidden absolute right-0 mt-2 w-48 bg-gray-800/90 backdrop-blur-sm border border-gray-700/50 rounded-xl shadow-2xl z-20 overflow-hidden">
                    <li>
                        <a href="?tipo=<?= $tipo ?>&categoria=null"
                            class="block px-4 py-2 hover:bg-gray-700/50 transition-colors text-sm">Todos</a>
                    </li>
                    <?php foreach ($categorias as $categoria): ?>
                        <li>
                            <a href="?tipo=<?= $tipo ?>&categoria=<?= htmlspecialchars($categoria['idcategoria']) ?>"
                                class="block px-4 py-2 hover:bg-gray-700/50 transition-colors text-sm">
                                <?= htmlspecialchars($categoria['nomecategoria']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- Carrossel Filmes -->
        <section class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-semibold">Filmes em destaque</h2>
                <div class="flex space-x-2">
                    <button id="moviesPrevBtn"
                        class="bg-gray-700/50 hover:bg-gray-600/50 p-2 rounded-full transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button id="moviesNextBtn"
                        class="bg-gray-700/50 hover:bg-gray-600/50 p-2 rounded-full transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="relative overflow-hidden">
                <div id="moviesCarousel" class="flex space-x-4 transition-transform duration-500">
                    <?php foreach ($filmes as $filme): ?>
                        <div class="flex-none w-48">
                            <div
                                class="bg-gray-200 rounded-xl overflow-hidden aspect-[2/3] cursor-pointer hover:scale-105 transition-transform duration-300">
                                <img src="uploads/<?= htmlspecialchars($filme['imagem']) ?>"
                                    alt="<?= htmlspecialchars($filme['titulo']) ?>" class="w-full h-full object-cover">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Carrossel Séries -->
        <section>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-semibold">Séries em destaque</h2>
                <div class="flex space-x-2">
                    <button id="seriesPrevBtn"
                        class="bg-gray-700/50 hover:bg-gray-600/50 p-2 rounded-full transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button id="seriesNextBtn"
                        class="bg-gray-700/50 hover:bg-gray-600/50 p-2 rounded-full transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="relative overflow-hidden">
                <div id="seriesCarousel" class="flex space-x-4 transition-transform duration-500">
                    <?php foreach ($series as $serie): ?>
                        <div class="flex-none w-48">
                            <div
                                class="bg-gray-200 rounded-xl overflow-hidden aspect-[2/3] cursor-pointer hover:scale-105 transition-transform duration-300">
                                <img src="uploads/<?= htmlspecialchars($serie['imagem']) ?>"
                                    alt="<?= htmlspecialchars($serie['titulo']) ?>" class="w-full h-full object-cover">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </div>

    <script>
        // Dropdowns
        function setupDropdown(buttonId, menuId) {
            const button = document.getElementById(buttonId);
            const menu = document.getElementById(menuId);
            if (!button || !menu) return;
            button.addEventListener('click', e => {
                e.stopPropagation();
                menu.classList.toggle('hidden');
                const icon = button.querySelector('svg');
                icon.style.transform = menu.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
            });
            document.addEventListener('click', e => {
                if (!button.contains(e.target) && !menu.contains(e.target)) {
                    menu.classList.add('hidden');
                    const icon = button.querySelector('svg');
                    icon.style.transform = 'rotate(0deg)';
                }
            });
        }
        setupDropdown('dropdownClassificacaoButton', 'dropdownClassificacaoMenu');
        setupDropdown('dropdownCategoriaButton', 'dropdownCategoriaMenu');

        // Carrossel
        function setupCarousel(carouselId, prevBtnId, nextBtnId) {
            const carousel = document.getElementById(carouselId);
            const prevBtn = document.getElementById(prevBtnId);
            const nextBtn = document.getElementById(nextBtnId);
            if (!carousel || !prevBtn || !nextBtn) return;

            const itemWidth = 208;
            let currentIndex = 0;
            const maxItems = carousel.children.length;

            function updateCarousel() {
                const translateX = -currentIndex * itemWidth;
                carousel.style.transform = `translateX(${translateX}px)`;
                prevBtn.disabled = currentIndex === 0;
                nextBtn.disabled = currentIndex >= (maxItems - Math.floor(carousel.parentElement.clientWidth / itemWidth));
            }

            nextBtn.addEventListener('click', () => {
                const visibleItems = Math.floor(carousel.parentElement.clientWidth / itemWidth);
                const maxIndex = Math.max(0, maxItems - visibleItems);
                currentIndex = Math.min(currentIndex + 1, maxIndex);
                updateCarousel();
            });

            prevBtn.addEventListener('click', () => {
                currentIndex = Math.max(currentIndex - 1, 0);
                updateCarousel();
            });

            window.addEventListener('resize', updateCarousel);
            updateCarousel();
        }

        document.addEventListener('DOMContentLoaded', () => {
            setupCarousel('moviesCarousel', 'moviesPrevBtn', 'moviesNextBtn');
            setupCarousel('seriesCarousel', 'seriesPrevBtn', 'seriesNextBtn');
        });
    </script>
</body>

</html>