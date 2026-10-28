(function () {
    var toggle = document.querySelector("[data-nav-toggle]");
    var nav = document.getElementById("site-nav");
    if (toggle && nav) {
        toggle.addEventListener("click", function () {
            var open = toggle.getAttribute("aria-expanded") === "true";
            toggle.setAttribute("aria-expanded", open ? "false" : "true");
            nav.hidden = open;
            document.body.classList.toggle("nav-open", !open);
            toggle.querySelector(".sr").textContent = open ? "Open menu" : "Close menu";
        });
    }

    var slides = Array.prototype.slice.call(document.querySelectorAll("[data-hero] .hero-slide"));
    if (!slides.length) return;
    var index = 0;
    function show(next) {
        slides[index].classList.remove("is-active");
        index = (next + slides.length) % slides.length;
        slides[index].classList.add("is-active");
    }
    var prev = document.querySelector("[data-hero-prev]");
    var next = document.querySelector("[data-hero-next]");
    if (prev) prev.addEventListener("click", function () { show(index - 1); });
    if (next) next.addEventListener("click", function () { show(index + 1); });
    var timer = setInterval(function () { show(index + 1); }, 5000);
    var hero = document.querySelector(".hero");
    if (hero) {
        hero.addEventListener("mouseenter", function () { clearInterval(timer); });
    }
})();
