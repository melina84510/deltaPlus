function AfficherPlus(bouton) {
    var groupe = bouton.getAttribute('data-group');
    var elements = document.querySelectorAll('.cacher[data-group="' + groupe + '"]');
    elements.forEach(function(element) {
        element.style.display = "block";
    });
    bouton.style.display = 'none';
}
 