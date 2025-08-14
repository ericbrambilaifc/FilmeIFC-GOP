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
$filmes = FilmeDAO::listar();
?>

<div class="relative bg-gray-50 py-8 group">
    <!-- Botão Anterior -->
    <button id="prevBtn" class="absolute left-4 top-1/2 transform -translate-y-1/2 z-10  bg-opacity-90 hover:bg-opacity-100 text-gray-700 p-3 rounded-full shadow-lg transition-all duration-300 opacity-0 group-hover:opacity-100">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
    </button>

    <!-- Container do Carrossel -->
    <div class="carousel-container overflow-hidden mx-16">
        <div class="carousel-track flex transition-transform duration-500 ease-in-out" id="carouselTrack">
            <?php foreach ($filmes as $filme) { ?>
                <div class="carousel-item flex-none w-48 mx-2 group/item">
                    <div class="relative bg-gray-900 rounded-lg overflow-hidden cursor-pointer transform transition-transform duration-300 hover:scale-110 hover:z-20 aspect-[2/3]">
                        <img src="uploads/<?= htmlspecialchars($filme['imagem']) ?>"
                             alt="<?= htmlspecialchars($filme['titulo']) ?>"
                             class="w-full h-full object-cover">
                        
                        <!-- Overlay com informações (aparece no hover) -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-0 group-hover/item:opacity-100 transition-opacity duration-300">
                            <div class="absolute bottom-0 left-0 right-0 p-4">
                                <h3 class="text-white font-semibold text-sm mb-1 line-clamp-2">
                                    <?= htmlspecialchars($filme['titulo']) ?>
                                </h3>
                                <p class="text-gray-300 text-xs line-clamp-3">
                                    <?= htmlspecialchars($filme['detalhes'] ?? '') ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- Duplicar os primeiros itens para loop contínuo -->
            <?php foreach (array_slice($filmes, 0, 6) as $filme) { ?>
                <div class="carousel-item flex-none w-48 mx-2 group/item">
                    <div class="relative bg-gray-900 rounded-lg overflow-hidden cursor-pointer transform transition-transform duration-300 hover:scale-110 hover:z-20 aspect-[2/3]">
                        <img src="uploads/<?= htmlspecialchars($filme['imagem']) ?>"
                             alt="<?= htmlspecialchars($filme['titulo']) ?>"
                             class="w-full h-full object-cover">
                        
                        <!-- Overlay com informações (aparece no hover) -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-0 group-hover/item:opacity-100 transition-opacity duration-300">
                            <div class="absolute bottom-0 left-0 right-0 p-4">
                                <h3 class="text-white font-semibold text-sm mb-1 line-clamp-2">
                                    <?= htmlspecialchars($filme['titulo']) ?>
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

    <!-- Botão Próximo -->
    <button id="nextBtn" class="absolute right-4 top-1/2 transform -translate-y-1/2 z-10  bg-opacity-90 hover:bg-opacity-100 text-gray-700 p-3 rounded-full shadow-lg transition-all duration-300 opacity-0 group-hover:opacity-100">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
    </button>
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
            // Reset sem animação
            track.style.transition = 'none';
            currentIndex = 0;
            updateCarousel();
            // Restaurar animação após um frame
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

    function startAutoSlide() {
        autoSlideInterval = setInterval(nextSlide, 4000); // Muda a cada 4 segundos
    }

    function stopAutoSlide() {
        clearInterval(autoSlideInterval);
    }

    // Event listeners
    nextBtn.addEventListener('click', () => {
        stopAutoSlide();
        nextSlide();
        startAutoSlide();
    });

    prevBtn.addEventListener('click', () => {
        stopAutoSlide();
        prevSlide();
        startAutoSlide();
    });

    // Pausar quando hover no carrossel
    const carousel = document.querySelector('.carousel-container').parentElement;
    carousel.addEventListener('mouseenter', stopAutoSlide);
    carousel.addEventListener('mouseleave', startAutoSlide);

    // Iniciar o auto slide
    startAutoSlide();
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

/* Garantir que o hover funcione corretamente */
.carousel-item:hover {
    z-index: 30;
}
</style>
</div>

    </div>
</body>

</html>