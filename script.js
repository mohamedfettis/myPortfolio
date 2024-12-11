// Récupère le bouton et le menu
const menuToggle = document.getElementById("menuToggle");
const menu = document.getElementById("menu");

// Ajoute un événement au clic du bouton pour afficher/masquer le menu
menuToggle.addEventListener("click", function () {
  menu.classList.toggle("show"); // Ajoute ou enlève la classe "show"
});
