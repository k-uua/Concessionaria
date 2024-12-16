<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/gruposinal/config/database.php';

class Carro
{
    public $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function cadastrarCarro($IdCor, $IdCambio, $IdCategoria, $AnoFabricacao, $PrecoNormal, $Portas, $Quilometragem, $Descricao, $imagemCarro, $IdCombutivel, $AnoModelo, $Placa, $DescricaoModeloID)
    {
        $sql = "INSERT INTO veiculo (CorID, CambioID, CategoriaID , AnoFabricacao, PrecoNormal, Portas, Quilometragem, Descricao, imagemCarro, CombustivelID, AnoModelo, Placa, DescricaoMoldeoID) VALUES (?, ?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$IdCor, $IdCambio, $IdCategoria, $AnoFabricacao, $PrecoNormal, $Portas, $Quilometragem, $Descricao, $imagemCarro, $IdCombutivel, $AnoModelo, $Placa, $DescricaoModeloID]);
    }



    //função para buscar cores
    public function buscarCores()
    {
        $sql = "SELECT IdCor, Nome from cor";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_All(MYSQLI_ASSOC);//retornará um array com todas as cores
        }
        return [];
    }

    public function buscarCambio()
    {
        $sql = "SELECT IdCambio, Descricao from cambio";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_All(MYSQLI_ASSOC);
        }
        return [];
    }

    public function buscarCategoria()
    {
        $sql = "SELECT IdCategoria, Descricao from categoria";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_All(MYSQLI_ASSOC);
        }
        return [];
    }

    public function buscarCombustivel()
    {
        $sql = "SELECT IdCombustivel, Descricao from combustivel";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_All(MYSQLI_ASSOC);
        }
        return [];
    }

    //Função para adicionar carros em minha tela inicial
    function exibirCarros($conn)
    {
        $stmt = $conn->prepare("
    SELECT 
        v.IdVeiculo, 
        v.imagemCarro, 
        v.DescricaoMoldeoID, 
        v.Quilometragem, 
        c.Descricao AS CambioNome, 
        cor.Nome AS CorNome, 
        cat.Descricao AS CategoriaNome,
        co.Descricao AS CombustivelNome, 
        v.Portas, 
        v.AnoModelo, 
        v.PrecoNormal
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
");

        $stmt->execute();
        $result = $stmt->get_result();
        $carros = $result->fetch_All(MYSQLI_ASSOC);

        foreach ($carros as $carro) {
            $IdVeiculo = $carro['IdVeiculo']; // Correção: Remover "v." do nome da coluna
            $DescricaoMoldeoID = $carro['DescricaoMoldeoID'];
            $Quilometragem = $carro['Quilometragem'];
            $CambioID = $carro['CambioNome']; // Correção: Usar o alias CambioNome
            $imagemCarro = $carro['imagemCarro'];
            $CombustivelNome = $carro['CombustivelNome']; // Correção: Usar o alias CombustivelNome
            $AnoModelo = $carro['AnoModelo'];
            $PrecoNormal = $carro['PrecoNormal'];
            
            // Converte a imagem em base64, se a imagem for armazenada como BLOB
            $imagemBase64 = base64_encode($imagemCarro);
            $imagemSrc = 'data:image/jpeg;base64,' . $imagemBase64;
        
            // Exibe o card com a imagem do carro
            echo '<div class="card" style="width: 18rem; margin: 10px;">';
            echo '<a href="/gruposinal/views/infoCarro.php?IdVeiculo=' . $IdVeiculo . '">'; // Correção no link
            echo '     <img src="' . $imagemSrc . '" class="card-img-top" alt="Imagem do Carro">';
            echo '</a>';
            echo '     <div class="card-body">';
            echo '         <h5 class="card-title">' . htmlspecialchars($DescricaoMoldeoID) . '</h5>';
            echo '         <p class="card-text">' . htmlspecialchars($Quilometragem) . ' KM / ' . htmlspecialchars($CambioID) . ' / ' . htmlspecialchars($CombustivelNome) . ' ' . htmlspecialchars($AnoModelo) . '</p>';
            echo '         <h3><strong>R$ ' . htmlspecialchars(number_format($PrecoNormal, 2, ',', '.')) . '</strong></h3>'; // Formatação de preço
            echo '         <p>Disponível em 11 lojas</p>';
            echo '         <a href="#" class="btn btn-primary">Ver parcelas</a>';
            echo '     </div>';
            echo '</div>';
        }
        
    }


}



if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $cor = $_POST['cor'];
    $categoria = $_POST['categoria'];
    $cambio = $_POST['cambio'];
    $portas = $_POST['portas'];
    $quilometragem = $_POST['quilometragem'];
    $anoFabricacao = $_POST['anoFabricacao'];
    $precoNormal = $_POST['precoNormal'];
    $descricao = $_POST['descricao'];
    $combustivel = $_POST['combustivel'];
    $anoModelo = $_POST['anoModelo'];
    $finalPlaca = $_POST['finalPlaca'];
    $descricaoModelo = $_POST['descricaoModelo'];
    if ($_FILES['imagemCarro']['error'] == UPLOAD_ERR_OK) {
        // Obtendo o caminho temporário do arquivo
        $imagemCarroTemp = $_FILES['imagemCarro']['tmp_name'];

        // Verificando se o arquivo foi enviado corretamente
        if ($imagemCarroTemp) {
            // Lendo o conteúdo do arquivo para armazená-lo no banco
            $imagemCarro = file_get_contents($imagemCarroTemp);
        } else {
            echo "Erro ao carregar a imagem.";
        }
    } else {
        echo "Erro no upload da imagem.";
    }

    $carro = new Carro($conn);
    if ($carro->cadastrarCarro($cor, $cambio, $categoria, $anoFabricacao, $precoNormal, $portas, $quilometragem, $descricao, $imagemCarro, $combustivel, $anoModelo, $finalPlaca, $descricaoModelo)) {
        echo "Carro cadastrado com sucesso!";
    } else {
        echo "Erro no cadastro do carro.";
    }


}






$carroController = new Carro(conn: $conn);
$cores = $carroController->buscarCores();
$cambios = $carroController->buscarCambio();
$categorias = $carroController->buscarCategoria();
$combustiveis = $carroController->buscarCombustivel();




?>