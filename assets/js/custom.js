// Here goes your custom javascript
(function () {
    var toggleButton = document.querySelector(".sidebar-toggle");
    var themeButtons = document.querySelectorAll("[data-theme]");
    var themeKey = "dashboard-theme";
    var gradientKey = "dashboard-gradient";
    var gradientStartInput = document.querySelector("#gradientStart");
    var gradientEndInput = document.querySelector("#gradientEnd");
    var gradientDirectionSelect = document.querySelector("#gradientDirection");

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

    function applyGradient(settings) {
        if (!settings) {
            return;
        }

        if (settings.start) {
            document.body.style.setProperty("--gradient-start", settings.start);
        }

        if (settings.end) {
            document.body.style.setProperty("--gradient-end", settings.end);
        }

        if (settings.angle) {
            document.body.style.setProperty("--gradient-angle", settings.angle);
        }
    }

    function persistGradient() {
        var settings = {
            start: gradientStartInput ? gradientStartInput.value : null,
            end: gradientEndInput ? gradientEndInput.value : null,
            angle: gradientDirectionSelect ? gradientDirectionSelect.value : null,
        };

        localStorage.setItem(gradientKey, JSON.stringify(settings));
        applyGradient(settings);
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

    if (gradientStartInput && gradientEndInput && gradientDirectionSelect) {
        var savedGradient = localStorage.getItem(gradientKey);
        if (savedGradient) {
            try {
                var parsed = JSON.parse(savedGradient);
                if (parsed.start) {
                    gradientStartInput.value = parsed.start;
                }
                if (parsed.end) {
                    gradientEndInput.value = parsed.end;
                }
                if (parsed.angle) {
                    gradientDirectionSelect.value = parsed.angle;
                }
                applyGradient(parsed);
            } catch (error) {
                localStorage.removeItem(gradientKey);
            }
        }

        gradientStartInput.addEventListener("input", persistGradient);
        gradientEndInput.addEventListener("input", persistGradient);
        gradientDirectionSelect.addEventListener("change", persistGradient);
    }
})();
