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
            require_once 'src/ClassificacaoDAO.php';

            $classificacoes = ClassificacaoDAO::listar();
            ?>

            <?php
            require_once 'src/ConexaoBD.php';
            require_once 'src/ClassificacaoDAO.php';

            $classificacoes = ClassificacaoDAO::listar();
            ?>

            <div class="relative inline-block text-left">
                <!-- Botão principal do select -->
                <button type="button" id="dropdownButton" class="bg-gradient-to-r from-[#07182F] to-[#174D95] text-white px-8 py-2 rounded-full text-[18px] transition-all whitespace-nowrap">
                    Genêro
                </button>

                <!-- Dropdown -->
                <?php
                require_once 'src/ConexaoBD.php';
                require_once 'src/ClassificacaoDAO.php';

                $classificacoes = ClassificacaoDAO::listar();
                ?>

                <div class="relative inline-block text-left">
                    <button type="button" id="dropdownClassificacaoButton" class="bg-gradient-to-r from-[#07182F] to-[#174D95] text-white px-8 py-2 rounded-full text-[18px] transition-all whitespace-nowrap ms-2">
                        Classificações
                    </button>

                    <!-- Dropdown de classificações -->
                    <ul id="dropdownClassificacaoMenu" class="hidden absolute mt-2 w-full bg-[#07182F] text-white rounded shadow-lg z-10">
                        <?php foreach ($classificacoes as $classificacao): ?>
                            <li>
                                <a href="?classificacao=<?= htmlspecialchars($classificacao['idclassificacao']) ?>"
                                    class="block px-6 py-2 hover:bg-[#174D95] transition-colors">
                                    <?= htmlspecialchars($classificacao['nomeclassificacao']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <script>
                    const classButton = document.getElementById('dropdownClassificacaoButton');
                    const classMenu = document.getElementById('dropdownClassificacaoMenu');

                    classButton.addEventListener('click', () => {
                        classMenu.classList.toggle('hidden');
                    });

                    // Fecha o menu ao clicar fora
                    document.addEventListener('click', (e) => {
                        if (!classButton.contains(e.target) && !classMenu.contains(e.target)) {
                            classMenu.classList.add('hidden');
                        }
                    });
                </script>

            </div>

            <script>
                const button = document.getElementById('dropdownButton');
                const menu = document.getElementById('dropdownMenu');

                button.addEventListener('click', () => {
                    menu.classList.toggle('hidden');
                });

                // Fecha o menu ao clicar fora
                document.addEventListener('click', (e) => {
                    if (!button.contains(e.target) && !menu.contains(e.target)) {
                        menu.classList.add('hidden');
                    }
                });
            </script>


            <?php
            require_once 'src/ConexaoBD.php';
            require_once 'src/ClassificacaoDAO.php';

            $classificacoes = ClassificacaoDAO::listar();
            ?>
        </div>

        <?php
        require_once 'src/FilmeDAO.php';

        $categoria_id = $_GET['categoria'] ?? null;

        if ($categoria_id) {
            $filmes = FilmeDAO::listarPorCategoria($categoria_id);
        } else {
            $filmes = FilmeDAO::listar();
        }
        ?>

        <div class="relative bg-gray-50 py-8 group">
            <button id="prevBtn" class="absolute left-4 top-1/2 transform -translate-y-1/2 z-10 bg-opacity-90 hover:bg-opacity-100 text-gray-700 p-3 rounded-full shadow-lg transition-all duration-300 opacity-0 group-hover:opacity-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <div class="carousel-container overflow-hidden mx-16">
                <div class="carousel-track flex transition-transform duration-500 ease-in-out" id="carouselTrack">
                    <?php foreach ($filmes as $filme) { ?>
                        <div class="carousel-item flex-none w-48 mx-2 group/item">
                            <div class="relative bg-gray-900 rounded-lg overflow-hidden cursor-pointer transform transition-transform duration-300 hover:scale-110 hover:z-20 aspect-[2/3]">
                                <img src="uploads/<?= htmlspecialchars($filme['imagem']) ?>"
                                    alt="<?= htmlspecialchars($filme['titulo']) ?>"
                                    class="w-full h-full object-cover">

                                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-0 group-hover/item:opacity-100 transition-opacity duration-300">
                                    <div class="absolute bottom-0 left-0 right-0 p-4">
                                        <h3 class="text-white font-semibold text-sm mb-1 line-clamp-2">
                                            <?= htmlspecialchars($filme['titulo']) ?>
                                            <p>Oscar:<?= htmlspecialchars($filme['oscar']) ?></p>
                                            <p>Elenco<?= htmlspecialchars($filme['elenco']) ?></p>
                                            <p>Categoria<?= htmlspecialchars($filme['categoria']) ?></p>
                                            <p>Classificação<?= htmlspecialchars($filme['classificacao']) ?></p>
                                            <p>Ano<?= htmlspecialchars($filme['ano']) ?></p>
                                            <p>ID<?= htmlspecialchars($filme['categoria']) ?></P>
                                            <p>idfilme<?= htmlspecialchars($filme['idfilme']) ?></p>

                                        </h3>
                                        <p class="text-gray-300 text-xs line-clamp-3">
                                            <?= htmlspecialchars($filme['detalhes'] ?? '') ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <button id="nextBtn" class="absolute right-4 top-1/2 transform -translate-y-1/2 z-10 bg-opacity-90 hover:bg-opacity-100 text-gray-700 p-3 rounded-full shadow-lg transition-all duration-300 opacity-0 group-hover:opacity-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const track = document.getElementById('carouselTrack');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');

            const totalFilmes = <?= count($filmes) ?>;
            const itemWidth = 200; // 192px (w-48) + 16px margin
            let currentIndex = 0;
            let autoSlideInterval;

            function updateCarousel() {
                const translateX = -currentIndex * itemWidth;
                track.style.transform = `translateX(${translateX}px)`;
            }

            function nextSlide() {
                currentIndex++;
                if (currentIndex >= totalFilmes) {
                    track.style.transition = 'none';
                    currentIndex = 0;
                    updateCarousel();
                    requestAnimationFrame(() => {
                        track.style.transition = 'transform 0.5s ease-in-out';
                        currentIndex = 1;
                        updateCarousel();
                    });
                } else {
                    updateCarousel();
                }
            }

            function prevSlide() {
                if (currentIndex === 0) {
                    track.style.transition = 'none';
                    currentIndex = totalFilmes;
                    updateCarousel();
                    requestAnimationFrame(() => {
                        track.style.transition = 'transform 0.5s ease-in-out';
                        currentIndex--;
                        updateCarousel();
                    });
                } else {
                    currentIndex--;
                    updateCarousel();
                }
            }

            // Event listeners
            if (nextBtn) {
                nextBtn.addEventListener('click', () => {
                    stopAutoSlide();
                    nextSlide();
                    startAutoSlide();
                });
            }
            if (prevBtn) {
                prevBtn.addEventListener('click', () => {
                    stopAutoSlide();
                    prevSlide();
                    startAutoSlide();
                });
            }

            // Pausar quando hover no carrossel
            const carousel = document.querySelector('.carousel-container') ? document.querySelector('.carousel-container').parentElement : null;
            if (carousel) {
                carousel.addEventListener('mouseenter', stopAutoSlide);
                carousel.addEventListener('mouseleave', startAutoSlide);
            }

            // Iniciar o auto slide se houver filmes
            if (totalFilmes > 0) {
                startAutoSlide();
            }

        });
    </script>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }


        .carousel-item:hover {
            z-index: 30;
        }
    </style>
    </div>
</body>

</html>