<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Filmes IFC+</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<style>
    body {
        font-family: "Inter", sans-serif;
        background: linear-gradient(180deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    }
</style>

<body class="min-h-screen text-white">
    <!-- Navigation -->
    <nav class="flex items-center justify-start px-8 ms-40 py-6 space-x-8">
        <a href="#" class="text-gray-300 hover:text-white transition-colors">home</a>
        <a href="#" class="text-gray-300 hover:text-white transition-colors">filmes</a>
        <a href="#" class="text-gray-300 hover:text-white transition-colors">séries</a>
        <a href="/adicionarFilme.php" class="text-gray-300 hover:text-white transition-colors">cadastro</a>
    </nav>

    <div class="max-w-7xl mx-auto px-8">
        <!-- Hero Section -->
        <?php
        require_once 'src/FilmeDAO.php';

        $categoria_id = $_GET['categoria'] ?? null;

        if ($categoria_id) {
            $filmes = FilmeDAO::listarPorCategoria($categoria_id);
        } else {
            $filmes = FilmeDAO::listar();
        }

        // Pega o primeiro filme para usar como destaque
        $filmeDestaque = !empty($filmes) ? $filmes[0] : null;
        ?>

        <section class="relative h-96 rounded-2xl overflow-hidden mb-12"
            style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.6)), url('uploads/<?= $filmeDestaque ? htmlspecialchars($filmeDestaque['imagem']) : 'gladiador.jpg' ?>'); background-size: cover; background-position: center;">
            <div class="absolute inset-0 flex items-center">
                <div class="px-12 max-w-2xl">
                    <h1 class="text-5xl font-bold mb-4">
                        <?= $filmeDestaque ? htmlspecialchars($filmeDestaque['titulo']) : 'GLADIADOR II' ?>
                    </h1>
                    <p class="text-lg text-gray-200 mb-8 leading-relaxed">
                        <?= $filmeDestaque && !empty($filmeDestaque['detalhes']) ? htmlspecialchars($filmeDestaque['detalhes']) : 'Ambientado no coração da Roma Antiga, dirigido por Ridley Scott. Ele traz de volta o épico de Gladiador agora centrado na trajetória de Lucius, que assume sua destino como gladiador após sua casa ser tomada por imperadores tirânicos.' ?>
                    </p>
                    <div class="flex space-x-4">
                        <button class="flex items-center space-x-2 bg-white text-black px-8 py-3 rounded-full font-semibold hover:bg-gray-200 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 5v10l8-5-8-5z" />
                            </svg>
                            <span>Assistir</span>
                        </button>
                        <button class="flex items-center space-x-2 bg-gray-600/70 backdrop-blur-sm text-white px-8 py-3 rounded-full font-semibold hover:bg-gray-600/90 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Detalhes</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Filter Section -->
        <div class="flex justify-end space-x-4 mb-8">
            <?php
            require_once 'src/ConexaoBD.php';
            require_once 'src/ClassificacaoDAO.php';

            $classificacoes = ClassificacaoDAO::listar();
            ?>

            <div class="relative">
                <select class="bg-gray-700/50 backdrop-blur-sm border border-gray-600/50 text-white px-4 py-2 rounded-full appearance-none cursor-pointer pr-8">
                    <option>Tipo</option>
                    <option>Filme</option>
                    <option>Série</option>
                </select>
                <svg class="absolute right-2 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

            <div class="relative">
                <button id="dropdownClassificacaoButton" class="bg-gray-700/50 backdrop-blur-sm border border-gray-600/50 text-white px-4 py-2 rounded-full flex items-center space-x-2">
                    <span>Classificação</span>
                    <svg class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <ul id="dropdownClassificacaoMenu" class="hidden absolute right-0 mt-2 w-48 bg-gray-800/90 backdrop-blur-sm border border-gray-700/50 rounded-xl shadow-2xl z-20 overflow-hidden">
                    <?php foreach ($classificacoes as $classificacao): ?>
                        <li>
                            <a href="?classificacao=<?= htmlspecialchars($classificacao['idclassificacao']) ?>"
                                class="block px-4 py-2 hover:bg-gray-700/50 transition-colors text-sm">
                                <?= htmlspecialchars($classificacao['nomeclassificacao']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="relative">
                <button id="dropdownButton" class="bg-gray-700/50 backdrop-blur-sm border border-gray-600/50 text-white px-4 py-2 rounded-full flex items-center space-x-2">
                    <span>Gênero</span>
                    <svg class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Movies Section -->
        <section class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-semibold">Filmes em destaque</h2>
                <div class="flex space-x-2">
                    <button id="moviesPrevBtn" class="bg-gray-700/50 hover:bg-gray-600/50 p-2 rounded-full transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button id="moviesNextBtn" class="bg-gray-700/50 hover:bg-gray-600/50 p-2 rounded-full transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="relative overflow-hidden">
                <div id="moviesCarousel" class="flex space-x-4 transition-transform duration-500">
                    <?php foreach ($filmes as $filme) { ?>
                        <div class="flex-none w-48">
                            <div class="bg-gray-200 rounded-xl overflow-hidden aspect-[2/3] cursor-pointer hover:scale-105 transition-transform duration-300">
                                <img src="uploads/<?= htmlspecialchars($filme['imagem']) ?>"
                                    alt="<?= htmlspecialchars($filme['titulo']) ?>"
                                    class="w-full h-full object-cover">
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>

        <!-- Series Section -->
        <section>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-semibold">Séries em destaque</h2>
                <div class="flex space-x-2">
                    <button id="seriesPrevBtn" class="bg-gray-700/50 hover:bg-gray-600/50 p-2 rounded-full transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button id="seriesNextBtn" class="bg-gray-700/50 hover:bg-gray-600/50 p-2 rounded-full transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="relative overflow-hidden">
                <div id="seriesCarousel" class="flex space-x-4 transition-transform duration-500">
                    <?php foreach ($filmes as $filme) { ?>
                        <div class="flex-none w-48">
                            <div class="bg-gray-200 rounded-xl overflow-hidden aspect-[2/3] cursor-pointer hover:scale-105 transition-transform duration-300">
                                <img src="uploads/<?= htmlspecialchars($filme['imagem']) ?>"
                                    alt="<?= htmlspecialchars($filme['titulo']) ?>"
                                    class="w-full h-full object-cover">
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>
    </div>

    <script>
        // Dropdown functionality
        const classButton = document.getElementById('dropdownClassificacaoButton');
        const classMenu = document.getElementById('dropdownClassificacaoMenu');

        if (classButton && classMenu) {
            classButton.addEventListener('click', (e) => {
                e.stopPropagation();
                classMenu.classList.toggle('hidden');
                const icon = classButton.querySelector('svg');
                icon.style.transform = classMenu.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
            });

            document.addEventListener('click', (e) => {
                if (!classButton.contains(e.target) && !classMenu.contains(e.target)) {
                    classMenu.classList.add('hidden');
                    const icon = classButton.querySelector('svg');
                    icon.style.transform = 'rotate(0deg)';
                }
            });
        }

        // Carousel functionality
        function setupCarousel(carouselId, prevBtnId, nextBtnId) {
            const carousel = document.getElementById(carouselId);
            const prevBtn = document.getElementById(prevBtnId);
            const nextBtn = document.getElementById(nextBtnId);

            if (!carousel || !prevBtn || !nextBtn) return;

            const itemWidth = 208; // 192px + 16px gap
            let currentIndex = 0;
            const maxItems = carousel.children.length;
            const visibleItems = Math.floor(carousel.parentElement.clientWidth / itemWidth);
            const maxIndex = Math.max(0, maxItems - visibleItems);

            function updateCarousel() {
                const translateX = -currentIndex * itemWidth;
                carousel.style.transform = `translateX(${translateX}px)`;
            }

            nextBtn.addEventListener('click', () => {
                currentIndex = Math.min(currentIndex + 1, maxIndex);
                updateCarousel();
            });

            prevBtn.addEventListener('click', () => {
                currentIndex = Math.max(currentIndex - 1, 0);
                updateCarousel();
            });
        }

        // Setup carousels
        document.addEventListener('DOMContentLoaded', () => {
            setupCarousel('moviesCarousel', 'moviesPrevBtn', 'moviesNextBtn');
            setupCarousel('seriesCarousel', 'seriesPrevBtn', 'seriesNextBtn');
        });


    </script>
</body>

</html>