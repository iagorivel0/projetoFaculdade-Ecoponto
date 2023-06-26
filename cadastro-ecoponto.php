<?php

session_start();

if(!isset($_SESSION['id_usuario']) || empty($_SESSION['id_usuario']))
{
  header('Location: login.php?noLogin=true');
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
  // Conexão com banco de dados
  
  $servername = "localhost";
  $username   = "root";
  $password   = "";
  $db_name    = "ecoponto";
  
  try
  {
      $pdo = new PDO("mysql:dbname=" . $db_name . ";host=" . $servername, $username, $password);
  }
  catch (PDOException $e)
  {
      $msgEroo = $e->getMessage();
  }

  //Usuário
  $nome     = isset($_POST['nome_completo']) && !empty(trim($_POST['nome_completo'])) ? trim($_POST['nome_completo']) : NULL;
  $telefone = isset($_POST['telefone'])      && !empty(trim($_POST['telefone']))      ? trim($_POST['telefone'])      : NULL;

  //Endereço
  $cep         = isset($_POST['cep'])         && !empty($_POST['cep'])         ? trim($_POST['cep'])         : NULL;
  $est_cid     = isset($_POST['est_cid'])     && !empty($_POST['est_cid'])     ? trim($_POST['est_cid'])     : NULL;
  $bairro      = isset($_POST['bairro'])      && !empty($_POST['bairro'])      ? trim($_POST['bairro'])      : NULL;
  $rua         = isset($_POST['rua'])         && !empty($_POST['rua'])         ? trim($_POST['rua'])         : NULL;
  $complemento = isset($_POST['complemento']) && !empty($_POST['complemento']) ? trim($_POST['complemento']) : NULL;

  //Observação
  $obs = isset($_POST['obs']) && !empty($_POST['obs']) ? trim($_POST['obs']) : NULL;

  $sql = $pdo->prepare("SELECT * FROM usuarios WHERE id_usuario = :i");
  $sql->bindValue(":i", $_SESSION['id_usuario']);
  $sql->execute();

  $dados = $sql->fetch();

  $sql = $pdo->prepare("INSERT INTO cadastro_ecoponto (id_usuario, nome, telefone, cep, estado_cidade, bairro, rua, complemento, obs) VALUES (:i, :n, :t, :c, :ec, :b, :r, :co, :o)");
  $sql->bindValue(":i",  $_SESSION['id_usuario']);
  $sql->bindValue(":n",  $nome);
  $sql->bindValue(":t",  $telefone);
  $sql->bindValue(":c",  $cep);
  $sql->bindValue(":ec", $est_cid);
  $sql->bindValue(":b",  $bairro);
  $sql->bindValue(":r",  $rua);
  $sql->bindValue(":co", $complemento);
  $sql->bindValue(":o",  $obs);
  $sql->execute();

  $last_id = $pdo->lastInsertId();

  foreach($_POST['residuo_reciclavel'] as $ln)
  {
    $sql = $pdo->prepare("INSERT INTO tipos_residuos (id_ecoponto, desc_residuo) VALUES (:i, :d)");
    $sql->bindValue(":i", $last_id);
    $sql->bindValue(":d", trim($ln));
    $sql->execute();
  }

  header('Location: logado.php?ecoponto=true');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./css/cadastro/cadastro.css">
  <title>EcoPonto - Login</title>
  <style>
    .group-checkbox {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: .5rem;
    }
  </style>
</head>

<body>

  <div class="container">
    <header>
      <svg width="112" height="92" viewBox="0 0 112 92" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <rect x="-22" y="-22" width="134" height="114" fill="url(#pattern0)" />
        <defs>
          <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
            <use xlink:href="#image0_203_288" transform="matrix(0.002 0 0 0.00235088 0 -0.0877193)" />
          </pattern>
          <image id="image0_203_288" width="500" height="500" xlink:href="data:image/png;base64,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EEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEBA8wL/HwUuVFBeUK25AAAAAElFTkSuQmCC" />
        </defs>
      </svg>
      <h2>RECICLANDO</h2>
    </header>
  </div>
    <div class="d-grid gap-2 mx-auto">
      <h3 class="h3-cadastro">Cadastrando Ecoponto</h3>

        <form action="./cadastro-ecoponto.php" method="POST">
            <p class="topicos">Contato</p>
            <input class="form-control" name="nome_completo" type="text" placeholder="Nome Completo" required>
            <input class="form-control" name="telefone" type="tel" placeholder="Número de Telefone">
            <p class="topicos">Endereço</p>
            <input class="form-control" name="cep" type="text" placeholder="CEP" required>
            <input class="form-control" name="est_cid" type="text" placeholder="Estado - Cidade" required>
            <input class="form-control" name="bairro" type="text" placeholder="Bairro" required>
            <input class="form-control" name="rua" type="text" placeholder="Rua">
            <input class="form-control" name="complemento" type="text" placeholder="Complemento (opcional)">
            
            <p class="topicos">Tipos de Resíduos</p>
            <div class="container">
                <div class="group-checkbox">
                    <input type="checkbox" name="residuo_reciclavel[]" value="Resíduos Recicláveis" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        Resíduos Recicláveis
                    </label>
                </div>
                
                <div class="group-checkbox">
                    <input type="checkbox" name="residuo_reciclavel[]" value="Biodegradáveis" id="flexCheckChecked" checked>
                    <label class="form-check-label" for="flexCheckChecked">
                        Biodegradáveis
                    </label>
                </div>
                
                <div class="group-checkbox">
                    <input type="checkbox" name="residuo_reciclavel[]" value="Metais" id="flexCheckChecked" checked>
                    <label class="form-check-label" for="flexCheckChecked">
                        Metais
                    </label>
                </div>
                
                <div class="group-checkbox">
                    <input type="checkbox" name="residuo_reciclavel[]" value="Materiais Perfurantes" id="flexCheckChecked" checked>
                    <label class="form-check-label" for="flexCheckChecked">
                        Materiais Perfurante
                    </label>
                </div>
            </div>

            <p class="topicos">Observações importantes</p>
            <textarea required class="form-control" name="obs">
            </textarea>
            <input id="cadastrar" type="submit" class="form-control" value="Enviar">
        </form>
    </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>