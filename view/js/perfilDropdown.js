document.getElementById("profileDropdown").addEventListener("click", function(event){
    event.preventDefault();
    var dropdown = document.getElementById("dropdownMenu");
    dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";
});

// Para fechar o dropdown se clicar fora dele
window.onclick = function(event) {
    if (!event.target.matches('#profileDropdown')) {
        var dropdown = document.getElementById("dropdownMenu");
        if (dropdown.style.display === "block") {
            dropdown.style.display = "none";
        }
    }
};
