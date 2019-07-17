function like () {
    var node = document.getElementById('currentSong'),
    textContent = node.textContent;
    "<?php $_SESSION['cancionActual']; ?>" = textContent;
}