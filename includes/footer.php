<?php
$redes = array_filter([
    "GitHub"    => ["url" => GITHUB_URL,    "icone" => "fa-brands fa-github"],
    "LinkedIn"  => ["url" => LINKEDIN_URL,  "icone" => "fa-brands fa-linkedin"],
    "Instagram" => ["url" => INSTAGRAM_URL, "icone" => "fa-brands fa-instagram"],
], fn($r) => $r["url"] !== "");
$base = url("");
?>
<footer>

    <div class="container footer-container">

        <div class="footer-about">
            <a href="<?= e($base) ?>#inicio" class="logo">Pedro<span>.</span></a>
            <p>Desenvolvedor Full Stack criando experiências digitais modernas, funcionais e feitas para crescer.</p>
            <a class="footer-contact-link" href="<?= e($base) ?>#contato">
                Vamos conversar <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </a>
        </div>

        <div>
            <h3>Explore</h3>
            <ul class="footer-links">
                <li><a href="<?= e($base) ?>#inicio">Início</a></li>
                <li><a href="<?= e($base) ?>#servicos">Serviços</a></li>
                <li><a href="<?= e($base) ?>#projetos">Projetos</a></li>
                <li><a href="<?= e($base) ?>#processo">Como trabalho</a></li>
                <li><a href="<?= e($base) ?>#contato">Contato</a></li>
            </ul>
        </div>

        <div class="footer-specialties">
            <h3>O que eu faço</h3>
            <ul>
                <li>Sites e landing pages</li>
                <li>Sistemas web</li>
                <li>Scripts e sites para FiveM</li>
                <li>Bots para Discord</li>
                <li>Extensões de navegador</li>
            </ul>
        </div>

    </div>

    <div class="container copyright">
        <span>© <?= date("Y") ?> <?= e(APP_NAME) ?>. Todos os direitos reservados.</span>
        <?php if ($redes): ?>
            <span class="social-links">
                <?php foreach ($redes as $nome => $rede): ?>
                    <a href="<?= e($rede["url"]) ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= e($nome) ?>">
                        <i class="<?= e($rede["icone"]) ?>" aria-hidden="true"></i>
                    </a>
                <?php endforeach; ?>
            </span>
        <?php else: ?>
            <a href="<?= e($base) ?>#inicio">Voltar ao topo <i class="fa-solid fa-arrow-up" aria-hidden="true"></i></a>
        <?php endif; ?>
    </div>

</footer>

<script src="<?= e(asset("assets/js/app.js")) ?>" defer></script>

</body>
</html>
