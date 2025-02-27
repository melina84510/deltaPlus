<div class="case">
    <?php 
        require_once('config.php');
        foreach ($listeservices as $a => $b) {
            echo "<div>";
                echo '<a href="' . $a . '">' . $b . '</a>';
            echo "</div>";
        }
    ?>
