// Here goes your custom javascript
(function () {
    var toggleButton = document.querySelector(".sidebar-toggle");

    if (toggleButton) {
        toggleButton.addEventListener("click", function (event) {
            event.preventDefault();
            document.body.classList.toggle("sidebar-collapsed");
        });
    }
})();
