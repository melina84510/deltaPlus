<div class="case">
    <?php 
        require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
        foreach ($listeservices as $a => $b) {
            echo "<div>";
                echo '<a href="' . $a . '">' . $b . '</a>';
            echo "</div>";
        }
    ?>
