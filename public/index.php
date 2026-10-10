<!-- public/index.php -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento | HUMANANUCLEO</title>
    <!-- Reaproveitando o CSS de header/footer caso existam e o home.css -->
    <link rel="stylesheet" href="assets/styles/header.css">
    <link rel="stylesheet" href="assets/styles/home.css">
    <link rel="stylesheet" href="assets/styles/footer.css">
</head>
<body>

    <!-- Inclua seu header.php aqui se quiser modularizar -->
    <header class="main-header">
        <h1>HUMANANUCLEO</h1>
    </header>

    <main class="container">
        <section class="agendamento-panel">
            <h2>Agende seu Horário</h2>
            <p>Preencha os dados abaixo para reservar um serviço.</p>

            <form id="form-agendamento" action="#" method="POST">
                
                <div class="form-group">
                    <label for="nome">Nome Completo</label>
                    <input type="text" id="nome" name="nome" required placeholder="Digite seu nome">
                </div>

                <div class="form-group">
                    <label for="servico">Serviço</label>
                    <select id="servico" name="servico_id" required>
                        <option value="" disabled selected>Selecione um serviço</option>
                        <option value="1">Consulta Padrão (30 min) - R$ 100,00</option>
                        <option value="2">Avaliação Completa (1h) - R$ 180,00</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="data">Data</label>
                    <input type="date" id="data" name="data" required>
                </div>

                <!-- Esta div será preenchida dinamicamente pelo JS -->
                <div class="form-group">
                    <label>Horários Disponíveis</label>
                    <div id="grid-horarios" class="horarios-grid">
                        <span class="placeholder-msg">Selecione uma data para ver os horários.</span>
                    </div>
                    <input type="hidden" id="horario_selecionado" name="horario" required>
                </div>

                <button type="submit" class="btn-submit">Confirmar Agendamento</button>
            </form>
        </section>
    </main>

    <script src="assets/scripts/script.js"></script>
</body>
</html>