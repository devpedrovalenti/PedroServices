(function () {
    "use strict";

    document.documentElement.classList.add("js");

    var reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

    /* ---------- Efeito de digitação do terminal ---------- */
    var typing = document.getElementById("typing");
    var texto = [
        "> Inicializando projeto...",
        "",
        "✔ PHP",
        "✔ JavaScript / React",
        "✔ Node.js",
        "✔ Lua (FiveM)",
        "✔ Bots Discord",
        "✔ Extensões de navegador",
        "✔ APIs e integrações",
        "",
        "Projeto compilado com sucesso..."
    ].join("\n");

    if (typing) {
        if (reduceMotion) {
            typing.textContent = texto;
        } else {
            var i = 0;
            (function digitar() {
                if (i < texto.length) {
                    typing.textContent += texto.charAt(i++);
                    window.setTimeout(digitar, 22);
                }
            })();
        }
    }

    /* ---------- Cabeçalho ao rolar ---------- */
    var header = document.querySelector("header");
    function atualizarHeader() {
        if (header) header.classList.toggle("scrolled", window.scrollY > 40);
    }
    window.addEventListener("scroll", atualizarHeader, { passive: true });
    atualizarHeader();

    /* ---------- Menu mobile ---------- */
    var menuToggle = document.querySelector(".menu-toggle");
    var navigation = document.getElementById("site-navigation");

    function fecharMenu() {
        if (!menuToggle || !navigation) return;
        menuToggle.setAttribute("aria-expanded", "false");
        menuToggle.setAttribute("aria-label", "Abrir menu");
        navigation.classList.remove("is-open");
    }

    if (menuToggle && navigation) {
        menuToggle.addEventListener("click", function () {
            var aberto = menuToggle.getAttribute("aria-expanded") === "true";
            menuToggle.setAttribute("aria-expanded", String(!aberto));
            menuToggle.setAttribute("aria-label", aberto ? "Abrir menu" : "Fechar menu");
            navigation.classList.toggle("is-open", !aberto);
        });

        navigation.querySelectorAll("a").forEach(function (link) {
            link.addEventListener("click", fecharMenu);
        });

        document.addEventListener("keydown", function (ev) {
            if (ev.key === "Escape") {
                fecharMenu();
                menuToggle.focus();
            }
        });
    }

    /* ---------- Link ativo no menu conforme a seção visível ---------- */
    var secoes = document.querySelectorAll("main section[id]");
    if ("IntersectionObserver" in window && navigation && secoes.length) {
        var linkPorId = {};
        navigation.querySelectorAll("a").forEach(function (a) {
            var hash = a.hash ? a.hash.slice(1) : "";
            if (hash) linkPorId[hash] = a;
        });

        var obsMenu = new IntersectionObserver(function (entradas) {
            entradas.forEach(function (entrada) {
                if (!entrada.isIntersecting) return;
                Object.keys(linkPorId).forEach(function (id) {
                    linkPorId[id].classList.toggle("is-active", id === entrada.target.id);
                });
            });
        }, { rootMargin: "-45% 0px -50% 0px" });

        secoes.forEach(function (s) { obsMenu.observe(s); });
    }

    /* ---------- Animação de entrada dos blocos ---------- */
    var reveals = document.querySelectorAll(".reveal");
    if (reduceMotion || !("IntersectionObserver" in window)) {
        reveals.forEach(function (el) { el.classList.add("is-visible"); });
    } else {
        var obsReveal = new IntersectionObserver(function (entradas, obs) {
            entradas.forEach(function (entrada) {
                if (entrada.isIntersecting) {
                    entrada.target.classList.add("is-visible");
                    obs.unobserve(entrada.target);
                }
            });
        }, { threshold: 0.12 });
        reveals.forEach(function (el) { obsReveal.observe(el); });
    }

    /* ---------- Filtro de projetos ---------- */
    var botoes = document.querySelectorAll(".filter");
    var cards = document.querySelectorAll(".project-card");

    botoes.forEach(function (botao) {
        botao.addEventListener("click", function () {
            var alvo = botao.getAttribute("data-filter");

            botoes.forEach(function (b) {
                var ativo = b === botao;
                b.classList.toggle("is-active", ativo);
                b.setAttribute("aria-pressed", String(ativo));
            });

            cards.forEach(function (card) {
                var mostrar = alvo === "todos" || card.getAttribute("data-category") === alvo;
                card.hidden = !mostrar;
                if (mostrar) card.classList.add("is-visible");
            });
        });
    });

    /* ---------- Formulário: evita duplo envio ---------- */
    var form = document.querySelector(".contact-form");
    if (form) {
        form.addEventListener("submit", function () {
            var botao = form.querySelector("button[type=submit]");
            if (botao) {
                botao.disabled = true;
                botao.textContent = "Enviando...";
            }
        });
    }
})();
