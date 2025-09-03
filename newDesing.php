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
        <?php
        // Criar array com todos os itens (filmes + séries) para o banner
        $todosItensDestaque = array();

        foreach ($filmes as $filme) {
            $filme['tipo'] = 'filme';
            $todosItensDestaque[] = $filme;
        }

        foreach ($series as $serie) {
            $serie['tipo'] = 'serie';
            $todosItensDestaque[] = $serie;
        }

        shuffle($todosItensDestaque); // embaralha para variar a ordem
        ?>

        <section id="bannerDestaque" class="relative h-96 rounded-2xl overflow-hidden mb-12 transition-all duration-1000"
            style="background-size: cover; background-position: center;">
            <div class="absolute inset-0 flex items-center">
                <div class="px-12 max-w-2xl">
                    <h1 id="bannerTitulo" class="text-5xl font-bold mb-4 transition-opacity duration-500"></h1>
                    <p id="bannerDetalhes" class="text-lg text-gray-200 mb-8 leading-relaxed transition-opacity duration-500"></p>
                    <div class="flex items-center space-x-4">
                        <span id="bannerTipo" class="px-3 py-1 rounded-full text-sm font-semibold"></span>
                        <span id="bannerAno" class="text-gray-300"></span>
                    </div>
                </div>
            </div>

            <!-- Controles do banner -->
            <div class="absolute bottom-6 right-6 flex space-x-2">
                <button id="bannerPrev" class="bg-black/30 hover:bg-black/50 p-2 rounded-full transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button id="bannerNext" class="bg-black/30 hover:bg-black/50 p-2 rounded-full transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

            <!-- Indicadores de pontos -->
            <div id="bannerIndicators" class="absolute bottom-6 left-12 flex space-x-2"></div>
        </section>

        <script>
            // Array com todos os itens para o carrossel do banner
            const todosItensDestaque = <?= json_encode($todosItensDestaque) ?>;
            let bannerIndex = 0;
            let bannerInterval;

            // Função para atualizar o banner
            function atualizarBanner(index) {
                if (todosItensDestaque.length === 0) return;

                const item = todosItensDestaque[index];
                const banner = document.getElementById('bannerDestaque');
                const titulo = document.getElementById('bannerTitulo');
                const detalhes = document.getElementById('bannerDetalhes');
                const tipo = document.getElementById('bannerTipo');
                const ano = document.getElementById('bannerAno');

                // Fade out
                titulo.style.opacity = '0';
                detalhes.style.opacity = '0';

                setTimeout(() => {
                    // Atualizar conteúdo
                    banner.style.backgroundImage = `linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.6)), url('uploads/${item.imagem}')`;
                    titulo.textContent = item.titulo || '';
                    detalhes.textContent = item.detalhes || '';
                    ano.textContent = item.ano ? `(${item.ano})` : '';

                    // Configurar badge do tipo
                    if (item.tipo === 'filme') {
                        tipo.textContent = 'FILME';
                        tipo.className = 'px-3 py-1 rounded-full text-sm font-semibold bg-blue-600 text-white';
                    } else {
                        tipo.textContent = 'SÉRIE';
                        tipo.className = 'px-3 py-1 rounded-full text-sm font-semibold bg-green-600 text-white';
                    }

                    // Fade in
                    titulo.style.opacity = '1';
                    detalhes.style.opacity = '1';

                    // Atualizar indicadores
                    atualizarIndicadores();
                }, 250);
            }

            // Função para criar indicadores de pontos
            function criarIndicadores() {
                const container = document.getElementById('bannerIndicators');
                container.innerHTML = '';

                todosItensDestaque.forEach((_, index) => {
                    const dot = document.createElement('button');
                    dot.className = 'w-2 h-2 rounded-full transition-all duration-300';
                    dot.onclick = () => {
                        bannerIndex = index;
                        atualizarBanner(bannerIndex);
                        reiniciarInterval();
                    };
                    container.appendChild(dot);
                });
            }

            // Função para atualizar indicadores ativos
            function atualizarIndicadores() {
                const dots = document.querySelectorAll('#bannerIndicators button');
                dots.forEach((dot, index) => {
                    if (index === bannerIndex) {
                        dot.className = 'w-2 h-2 rounded-full bg-white transition-all duration-300';
                    } else {
                        dot.className = 'w-2 h-2 rounded-full bg-white/30 transition-all duration-300';
                    }
                });
            }

            // Função para próximo item
            function proximoBanner() {
                bannerIndex = (bannerIndex + 1) % todosItensDestaque.length;
                atualizarBanner(bannerIndex);
            }

            // Função para item anterior
            function anteriorBanner() {
                bannerIndex = bannerIndex === 0 ? todosItensDestaque.length - 1 : bannerIndex - 1;
                atualizarBanner(bannerIndex);
            }

            // Função para reiniciar o intervalo automático
            function reiniciarInterval() {
                clearInterval(bannerInterval);
                bannerInterval = setInterval(proximoBanner, 5000); // Muda a cada 5 segundos
            }

            // Inicializar o banner
            if (todosItensDestaque.length > 0) {
                criarIndicadores();
                atualizarBanner(0);

                // Auto-play
                bannerInterval = setInterval(proximoBanner, 5000);

                // Event listeners para os botões
                document.getElementById('bannerPrev').onclick = () => {
                    anteriorBanner();
                    reiniciarInterval();
                };

                document.getElementById('bannerNext').onclick = () => {
                    proximoBanner();
                    reiniciarInterval();
                };

                // Pausar no hover
                const banner = document.getElementById('bannerDestaque');
                banner.onmouseenter = () => clearInterval(bannerInterval);
                banner.onmouseleave = () => bannerInterval = setInterval(proximoBanner, 5000);
            }
        </script>

        <!-- Filtros -->
        <div class="flex justify-end space-x-4 mb-8">
            <div class="relative">
                <select onchange="window.location.href=this.value"
                    class="bg-gray-700/50 backdrop-blur-sm border border-gray-600/50 text-white px-4 py-2 rounded-full appearance-none cursor-pointer pr-8">
                    <option value="newDesing.php?tipo=" <?= $tipo === 'todos' ? 'selected' : '' ?>>Todos</option>
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


        <!-- Carrossel filmes e series filtrados -->
        <section class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-semibold">
                    <?php
                    if (isset($_GET['tipo']) && $_GET['tipo'] === 'serie') {
                        echo 'Séries em Destaque';
                    } elseif (isset($_GET['tipo']) && $_GET['tipo'] === 'filme') {
                        echo 'Filmes em Destaque';
                    } else {
                        echo 'Títulos em Destaque';
                    }
                    ?>
                </h2>
                <div class="flex space-x-2">
                    <button id="mixedPrevBtn"
                        class="bg-gray-700/50 hover:bg-gray-600/50 p-2 rounded-full transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button id="mixedNextBtn"
                        class="bg-gray-700/50 hover:bg-gray-600/50 p-2 rounded-full transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="relative overflow-hidden">
                <div id="mixedCarousel" class="flex space-x-4 transition-transform duration-500">
                    <?php
                    $todosTitulos = array();
                    $tipoSelecionado = isset($_GET['tipo']) ? $_GET['tipo'] : 'todos';

                    // Filtrar baseado na seleção
                    if ($tipoSelecionado === 'filme') {
                        // Mostrar apenas filmes
                        foreach ($filmes as $filme) {
                            $filme['tipo'] = 'filme';
                            $todosTitulos[] = $filme;
                        }
                    } elseif ($tipoSelecionado === 'serie') {
                        // Mostrar apenas séries
                        foreach ($series as $serie) {
                            $serie['tipo'] = 'serie';
                            $todosTitulos[] = $serie;
                        }
                    } else {
                        // Mostrar todos misturados (comportamento padrão)
                        foreach ($filmes as $filme) {
                            $filme['tipo'] = 'filme';
                            $todosTitulos[] = $filme;
                        }

                        foreach ($series as $serie) {
                            $serie['tipo'] = 'serie';
                            $todosTitulos[] = $serie;
                        }

                        shuffle($todosTitulos); // embaralha apenas quando mostra todos
                    }

                    // Exibir os títulos filtrados
                    foreach ($todosTitulos as $titulo):
                    ?>
                        <div class="flex-none w-48">
                            <div class="bg-gray-200 rounded-xl overflow-hidden aspect-[2/3] cursor-pointer hover:scale-105 transition-transform duration-300 relative">
                                <img src="uploads/<?= htmlspecialchars($titulo['imagem']) ?>"
                                    alt="<?= htmlspecialchars($titulo['titulo']) ?>" class="w-full h-full object-cover">

                                <!-- Badge para identificar se é filme ou série -->
                                <div class="absolute top-2 right-2">
                                    <span class="<?= $titulo['tipo'] == 'filme' ? 'bg-blue-600' : 'bg-green-600' ?> text-white text-xs px-2 py-1 rounded-full">
                                        <?= $titulo['tipo'] == 'filme' ? 'FILME' : 'SÉRIE' ?>
                                    </span>
                                </div>

                                <!-- Título na parte inferior -->
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-3">
                                    <h3 class="text-white text-sm font-semibold truncate">
                                        <?= htmlspecialchars($titulo['titulo']) ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Carrossel só de Filmes -->
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
                            <div class="bg-gray-200 rounded-xl overflow-hidden aspect-[2/3] cursor-pointer hover:scale-105 transition-transform duration-300">
                                <img src="uploads/<?= htmlspecialchars($filme['imagem']) ?>"
                                    alt="<?= htmlspecialchars($filme['titulo']) ?>" class="w-full h-full object-cover">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Carrossel só de Séries -->
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
                            <div class="bg-gray-200 rounded-xl overflow-hidden aspect-[2/3] cursor-pointer hover:scale-105 transition-transform duration-300">
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

        // JavaScript para o carrossel misturado
        document.addEventListener('DOMContentLoaded', function() {
            const mixedCarousel = document.getElementById('mixedCarousel');
            const mixedPrevBtn = document.getElementById('mixedPrevBtn');
            const mixedNextBtn = document.getElementById('mixedNextBtn');

            if (mixedCarousel && mixedPrevBtn && mixedNextBtn) {
                let mixedCurrentPosition = 0;
                const mixedItemWidth = 208; // 192px (w-48) + 16px (space-x-4)
                const mixedItemsVisible = Math.floor(window.innerWidth / mixedItemWidth);
                const mixedMaxItems = mixedCarousel.children.length;

                mixedNextBtn.addEventListener('click', () => {
                    if (mixedCurrentPosition < mixedMaxItems - mixedItemsVisible) {
                        mixedCurrentPosition++;
                        mixedCarousel.style.transform = `translateX(-${mixedCurrentPosition * mixedItemWidth}px)`;
                    }
                });

                mixedPrevBtn.addEventListener('click', () => {
                    if (mixedCurrentPosition > 0) {
                        mixedCurrentPosition--;
                        mixedCarousel.style.transform = `translateX(-${mixedCurrentPosition * mixedItemWidth}px)`;
                    }
                });
            }
        });

        // JavaScript para o carrossel misturado
        document.addEventListener('DOMContentLoaded', function() {
            const mixedCarousel = document.getElementById('mixedCarousel');
            const mixedPrevBtn = document.getElementById('mixedPrevBtn');
            const mixedNextBtn = document.getElementById('mixedNextBtn');

            if (mixedCarousel && mixedPrevBtn && mixedNextBtn) {
                let mixedCurrentPosition = 0;
                const mixedItemWidth = 208; // 192px (w-48) + 16px (space-x-4)
                const mixedItemsVisible = Math.floor(window.innerWidth / mixedItemWidth);
                const mixedMaxItems = mixedCarousel.children.length;

                mixedNextBtn.addEventListener('click', () => {
                    if (mixedCurrentPosition < mixedMaxItems - mixedItemsVisible) {
                        mixedCurrentPosition++;
                        mixedCarousel.style.transform = `translateX(-${mixedCurrentPosition * mixedItemWidth}px)`;
                    }
                });

                mixedPrevBtn.addEventListener('click', () => {
                    if (mixedCurrentPosition > 0) {
                        mixedCurrentPosition--;
                        mixedCarousel.style.transform = `translateX(-${mixedCurrentPosition * mixedItemWidth}px)`;
                    }
                });
            }
        });
    </script>
</body>

</html>