<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/gruposinal/config/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/gruposinal/controller/cadastrarCarros.php';

if (isset($_GET['IdVeiculo'])) {
    $idVeiculo = $_GET['IdVeiculo'];

    // Prepara e executa a consulta para pegar os detalhes do carro
    $stmt = $conn->prepare("
    SELECT 
        v.IdVeiculo, 
        v.imagemCarro, 
        v.DescricaoMoldeoID, 
        v.Quilometragem, 
        c.Descricao AS CambioNome, 
        co.Descricao AS CombustivelNome, 
        v.AnoModelo, 
        v.PrecoNormal, 
        v.AnoFabricacao, 
        cor.Nome AS CorNome, 
        v.Descricao, 
        cat.Descricao AS CategoriaNome
    FROM 
        veiculo v
    INNER JOIN 
        cambio c ON v.CambioID = c.IdCambio
    INNER JOIN 
        cor cor ON v.CorID = cor.IdCor
    INNER JOIN 
        categoria cat ON v.CategoriaID = cat.IdCategoria
    INNER JOIN 
        combustivel co ON v.CombustivelID = co.IdCombustivel
    WHERE v.IdVeiculo = ?
");


    $stmt->bind_param("i", $idVeiculo);
    $stmt->execute();
    $result = $stmt->get_result();
    $carro = $result->fetch_assoc();
    
    // Se o carro não for encontrado
    if (!$carro) {
        echo "Carro não encontrado!";
        exit;
    }

    $DescricaoMoldeoID = $carro['DescricaoMoldeoID'];
    $Quilometragem = $carro['Quilometragem'];
    $Cambio = $carro['CambioNome'];
    $ImagemCarro = base64_encode($carro['imagemCarro']);
    $Combustivel = $carro['CombustivelNome'];
    $AnoModelo = $carro['AnoModelo'];
    $PrecoNormal = $carro['PrecoNormal'];
    $anoFabricacao = $carro['AnoFabricacao'];
    $cor = $carro ['CorNome'];
    $Descricao = $carro['Descricao'];
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zero KM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/gruposinal/assets/css/style.css">
</head>

<body>
    <header>
    <div style="width: 100%; text-align: center; background-color: #19467E; color: white;"><h2 style="font-size: 15px; padding: 10px;">Os melhores veículos</h2></div>
        <!-- Barra de navegação -->
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="/gruposinal/main.php">Grupo Sinal</a>
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

    <main>
        <div class="container">
            <div class="carrouselCarros">
                <div id="carouselExampleCaptions" class="carousel slide">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                            aria-current="true" aria-label="Slide 1"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item">
                        <img src="data:image/jpg;base64,<?php echo $ImagemCarro; ?>" alt="imagem1">
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
        
        <div class="container">
            <div class="infoCarro">
                <h3><?php echo $DescricaoMoldeoID?></h3>
                <div class="infoRow">
                    <div class="infoColumn">
                        <h4>Ano</h4>
                        <strong><?php echo $anoFabricacao?> / <?php echo $AnoModelo?></strong>
                    </div>
                    <div class="infoColumn">
                        <h4>Cor</h4>
                        <strong><?php echo $cor?></strong>
                    </div>
                    <div class="infoColumn">
                        <h4>Combustível</h4>
                        <strong><?php echo $Combustivel?></strong>
                    </div>
                    <div class="infoColumn">
                        <h4>Quilometragem</h4>
                        <strong><?php echo number_format($Quilometragem)?> KM</strong>
                    </div>
                </div>

                <h5><strong>Descrição do Veículo</strong></h5>
                <p><?php echo $Descricao?></p>
                <hr>
                <p>Entre em contato com nossas lojas pelo telefone</p>
                <label title="Loja" class="sc-d57b19ea-0 fOEtJn">
                    <select name="Loja">
                        <option value="" disabled selected>Loja</option>
                        <option value="nissan-sinal-japan-alphaville">Nissan Sinal Japan Alphaville</option>
                        <option value="nissan-sinal-japan">Nissan Sinal Japan</option>
                    </select>
                </label>
            </div>




            <h2>Veículos em destaque</h2>
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
            <div>
                <div class="form-novidades">
                    <div class="novidades-sinal">
                        <h1><strong>Novidades da Sinal</strong></h1>
                        <form action="" class="formSinal">
                            <input type="text" placeholder="Nome">
                            <input type="email" placeholder="Email">
                            <div class="checkbox-container">
                                <input type="checkbox">
                                <p>Quero receber oferta e informações sobre lançamentos de carros por e-mail</p>
                            </div>
                            <input type="submit" value="INSCREVA-SE">
                            <form action="">
                    </div>
                    <img src="/gruposinal/assets/img/moça.webp" alt="">
                </div>
            </div>
        </div>


    </main>

    <footer>
        <p><strong>Copyright © 2024 Grupo Sinal</strong></p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>

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