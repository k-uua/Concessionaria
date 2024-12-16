<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/gruposinal/config/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/gruposinal/controller/cadastrarCarros.php';


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/gruposinal/assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body style="background: rgb(248, 248, 248);">
    <header>
        <div style="width: 100%; text-align: center; background-color: #19467E; color: white;">
            <h2 style="font-size: 15px; padding: 10px;">Os melhores veículos</h2>
        </div>

        <!-- Barra de navegação -->
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Grupo Sinal</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Zero Km</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Seminovos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/gruposinal/views/adicionarCarro.php">Adicionar carros</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main style="width: 100%; display: flex; flex-direction: column; align-items: center; gap: 30px;">
        <!--Carrousel pagina principal-->
        <div class="container mt-4">
            <div class="carrouselCarros2">
                <div id="carouselExampleCaptions" class="carousel slide">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0"
                            class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                            aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                            aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item">
                            <img src="/gruposinal/assets/img/banner-fraude.png" alt="banner1" class="d-block w-100">
                        </div>
                        <div class="carousel-item active">
                            <img src="/gruposinal/assets/img/banner-2008.png" alt="banne2" class="d-block w-100">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Busca de veículos -->
        <div class="container">
            <section id="section-pesquisa-carros" class="shadow">
                <h2 style="text-align: center;">Busca de veículos</h2>
                <div id="pesquisa-carros">
                    <div>
                        <select name="marca" id="">
                            <option value="">Marca</option>
                            <option value="">Motos</option>
                        </select>

                        <select name="modelo" id="">
                            <option value="">Modelo</option>
                            <option value="">Motos</option>
                        </select>

                        <select name="versao" id="">
                            <option value="">Versão</option>
                            <option value="">Motos</option>
                        </select>

                        <input type="text" placeholder="Pesquisa de veículos" id="pesquisa">
                    </div>

                    <div style="display: flex; flex-direction: column; align-items: center; gap: 15px;">
                        <div>
                            <input type="checkbox" id="novo" checked>
                            <label for="novo">Novo</label>
                            <input type="checkbox" id="seminovo" checked>
                            <label for="seminovo">Seminovo</label>
                        </div>
                        <button
                            style="width: 250px; height: 40px; background: linear-gradient(to right, #19467E, white); border: none; color: white; font-weight: bold;">Ver
                            veículos</button>
                    </div>
                </div>
            </section>
        </div>

        <!--Scroll horizontal produtos em destaque-->
        <div class="container mt-4">
            <div class="scroll-wrapper">
                <button type="button" class="btn scroll-btn nxt-button"><strong>></strong></button>
                <div class="scroll-horizontal">
                    <?php $carroController->exibirCarros($conn);?>
                </div>   
                <button type="button" class="btn scroll-btn bck-button"><strong><</strong></button>
            </div>
        </div>


    </main>

    <footer>
        <p><strong>Copyright &copy; 2024 Grupo Sinal</strong></p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script>
        document.querySelectorAll(".scroll-wrapper").forEach(wrapper => {
            const scrollContainer = wrapper.querySelector(".scroll-horizontal");
            const nextButton = wrapper.querySelector(".nxt-button");
            const bckButton = wrapper.querySelector(".bck-button");

            nextButton.addEventListener("click", () => {
                scrollContainer.scrollLeft += 900; // Ajuste conforme necessário
            });

            bckButton.addEventListener("click", () => {
                scrollContainer.scrollLeft -= 900; // Ajuste conforme necessário
            });
        });

    </script>
</body>

</html>