<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/gruposinal/config/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/gruposinal/controller/cadastrarCarros.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar carros</title>
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
            <div class="form-AdicionarCarro">
                <form action="/gruposinal/controller/cadastrarCarros.php" method="POST" enctype="multipart/form-data">
                    <label for="cor">Cor</label>
                    <select name="cor" id="cor" required>
                        <?php if (!empty($cores)): ?>
                            <option value="">Selecionar</option>
                            <?php foreach ($cores as $cor): ?>
                                <option value="<?= $cor['IdCor']; ?>"><?= htmlspecialchars($cor['Nome']); ?></option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="">Nenhuma cor cadastrada</option>
                        <?php endif; ?>
                    </select>

                    <label for="Cambio">Cambio</label>
                    <select name="cambio" id="cambio" required>
                        <option value="">Selecionar</option>
                        <?php if (!empty($cambios)): ?>
                            <?php foreach ($cambios as $cambio): ?>
                                <option value="<?= $cambio['IdCambio']; ?>"><?= htmlspecialchars($cambio['Descricao']); ?></option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="">Nenhuma cor cadastrada</option>
                        <?php endif; ?>
                    </select>
                    
                    <label for="Categoria">Categoria</label>
                    <select name="categoria" id="categoria" required>
                        <option value="">Selecionar</option>
                        <?php if (!empty($categorias)):?>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?= $categoria['IdCategoria']; ?>"><?= htmlspecialchars($categoria['Descricao']); ?></option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="">Nenhuma cor cadastrada</option>
                        <?php endif; ?>
                    </select>

                    <label for="Combustivel">Combustivel</label>
                    <select name="combustivel" id="combustivel" required>
                        <option value="">Selecionar</option>
                        <?php if (!empty($combustiveis)): ?>
                            <?php foreach ($combustiveis as $combustivel): ?>   
                                <option value="<?= $combustivel['IdCombustivel']; ?>"><?= htmlspecialchars($combustivel['Descricao']); ?></option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="">Nenhuma cor cadastrada</option>
                        <?php endif; ?>
                    </select>
                                
                    <label for="portas">Portas</label>
                    <select name="portas" id="portas" required>
                        <option value="">Selecionar</option>
                        <option value="2">2</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                    <label for="descricao">Descricao do carro</label>
                    <input type="text" name="descricao" id="descricao" required>

                    <label for="descricaoModelo">Descricao do modelo</label>
                    <input type="text" name="descricaoModelo" id="descricaoModelo" required>

                    <label for="placa">Final da placa</label>
                    <input type="text" name="finalPlaca" id="finalPlaca" required maxlength="4" pattern="\d{4}" title="Digite 4 números" />
                    
                    <label for="quilometragem">Quilometragem</label>
                    <input type="number" id="quilometragem" name="quilometragem" required>

                    <label for="anoFabicacao">Ano de fabricação</label>
                    <input type="number" id="anoFabricacao" name="anoFabricacao" min="1900" max="2024" required>

                    <label for="anoModelo">Ano do Modelo</label>
                    <input type="number" id="anoModelo" name="anoModelo" min="1900" max="2024" required>

                    <label for="preco">Preço</label>
                    <input type="number" name="precoNormal" id="PrecoNormal" required>  
                    
                    

                    <input type="file" name="imagemCarro" accept="image/*" placeholder="Imagem do carro" required>          
                    <input type="submit" value="adicionar">
                    
                </form>
            </div>
        </div>
    </main>

    <footer>
        <p><strong>Copyright © 2024 Grupo Sinal</strong></p>
    </footer>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>                          
</html>
