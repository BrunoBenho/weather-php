<?php 
$cidade = trim($_GET['cidade'] ?? '');

if ($cidade !== '') {
    $data = require 'api/clima.php';
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="stylesheet" href="assets/css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clima-PHP</title>
</head>
<body>

    <div class="container">

        <h1>Clima PHP</h1>

        <p class="label">Cidade</p>

        <form action="" method="GET" id="form-clima">
            <input type="text" 
                name="cidade" 
                id="input-cidade"
                placeholder="Cidade" 
                maxlength="50">

                <button type="submit" id="btn-buscar">
                    Buscar
                </button>
        </form>

    <?php if (!empty($data['results'])): ?>

        <div class="resultado">

            <h2>
                <span id="icone-clima"></span>
                <?= htmlspecialchars($data['results']['city']) ?>
            </h2>

            <p id="descricao-clima" data-descricao="<?= htmlspecialchars($data['results']['description']) ?>" hidden></p>

            <p>
                <strong>Temperatura:</strong> <?= htmlspecialchars($data['results']['temp']) ?>°C
            </p>
            
            <?php $hoje = $data['results']['forecast'][0] ?? null; ?>

            <?php if ($hoje): ?>
                <p>
                    <strong>Máxima:</strong> <?= htmlspecialchars($hoje['max']) ?>°C
                </p>

                <p>
                    <strong>Mínima:</strong> <?= htmlspecialchars($hoje['min']) ?>°C
                </p>
            <?php endif; ?>           

            <p>
                <strong>Descrição:</strong> <?= htmlspecialchars($data['results']['description'])?>
            </p>

            <p>
                <strong>Horário:</strong> <?= htmlspecialchars($data['results']['time'])?>
            </p>

            <p>
                <strong>Lua:</strong> <?= htmlspecialchars($data['results']['moon_phase'])?>
            </p>
            <p>
                <strong>Probabilidade de Chuva:</strong> <?= htmlspecialchars($data['results']['rain'])?>
            </p>

            <p>
                <strong>Fuso Horario:</strong> <?= htmlspecialchars($data['results']['timezone'])?>
            </p>

            <?php if (!empty($data['results']['forecast'])): ?>
                <div class="previsao">
                    <?php foreach ($data['results']['forecast'] as $dia): ?>
                        <div class="previsao-dia">
                            <div class="weekday"><?= htmlspecialchars($dia['weekday']) ?></div>
                            <div class="data"><?= htmlspecialchars($dia['date']) ?></div>
                            <span class="icone" data-descricao="<?= htmlspecialchars($dia['description']) ?>"></span>
                            <div class="max"><?= htmlspecialchars($dia['max']) ?>°C</div>
                            <div class="min"><?= htmlspecialchars($dia['min']) ?>°C</div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    <?php endif; ?>

    </div>

    <script>
        // Estado de carregamento ao buscar (não interfere no envio do form em si)
        const form = document.getElementById('form-clima');
        const input = document.getElementById('input-cidade');
        const botao = document.getElementById('btn-buscar');

        form.addEventListener('submit', function (event) {
            const valor = input.value.trim();

            if (valor === '') {
                event.preventDefault();
                input.focus();
                return;
            }

            botao.disabled = true;
            botao.textContent = 'Buscando...';
        });

        // Ícone dinâmico baseado na descrição vinda do PHP
        function descricaoParaIcone(descricao) {
            descricao = descricao.toLowerCase();

            if (descricao.includes('chuv')) return '🌧️';
            if (descricao.includes('nuvem') || descricao.includes('nublado')) return '☁️';
            if (descricao.includes('sol') || descricao.includes('limpo') || descricao.includes('claro')) return '☀️';
            if (descricao.includes('tempestade') || descricao.includes('trovoada')) return '⛈️';
            if (descricao.includes('neve')) return '❄️';
            if (descricao.includes('neblina') || descricao.includes('nevoeiro')) return '🌫️';

            return '🌡️';
        }

        const descricaoEl = document.getElementById('descricao-clima');
        const iconeEl = document.getElementById('icone-clima');

        if (descricaoEl) {
            iconeEl.textContent = descricaoParaIcone(descricaoEl.dataset.descricao);
        }

        // Ícones dos cards de previsão dos próximos dias
        document.querySelectorAll('.previsao-dia .icone').forEach(function (span) {
            span.textContent = descricaoParaIcone(span.dataset.descricao);
        });
    </script>

</body>
</html>