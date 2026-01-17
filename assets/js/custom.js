// Here goes your custom javascript
(function () {
    var toggleButton = document.querySelector(".sidebar-toggle");
    var themeButtons = document.querySelectorAll("[data-theme]");
    var themeKey = "dashboard-theme";

    if (toggleButton) {
        toggleButton.addEventListener("click", function (event) {
            event.preventDefault();
            document.body.classList.toggle("sidebar-collapsed");
        });
    }

    function applyTheme(theme) {
        document.body.classList.remove("theme-blue", "theme-indigo", "theme-slate");

        if (theme) {
            document.body.classList.add(theme);
        }
    }

    if (themeButtons.length) {
        themeButtons.forEach(function (button) {
            button.addEventListener("click", function () {
                var theme = button.getAttribute("data-theme");
                applyTheme(theme);
                localStorage.setItem(themeKey, theme);
            });
        });
    }

    var savedTheme = localStorage.getItem(themeKey);
    if (savedTheme) {
        applyTheme(savedTheme);
    } else {
        applyTheme("theme-blue");
    }
})();
