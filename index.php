<?php 
$cidade = trim($_GET['cidade'] ?? '');

if ($cidade !== '') {
    $data = require 'api/clima.php';
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clima-PHP</title>
</head>
<body>

    <h1>Clima PHP</h1>

    <p>Cidade</p>

    <form action="" method="GET">
        <input type="text" 
            name="cidade" 
            placeholder="Cidade" 
            maxlength="50">
        
            <button type="submit">
                Buscar
            </button>
    </form>

<?php if (!empty($data['results'])): ?>

    <h2>
        <?= htmlspecialchars($data['results']['city']) ?>
    </h2>

    <p>
        Temperatura: <?= htmlspecialchars($data['results']['temp']) ?>°C
    </p>

<?php endif; ?>

</body>
</html>



