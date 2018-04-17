<?php include('inc/head.php');
?>

<p>Vous trouverez ici la liste des repertoires et fichiers.</p>
<?php
function mkmap($dir)
{
    echo "<ul>";
    $folder = opendir($dir);
    while ($file = readdir($folder)) {
        if ($file != "." && $file != "..") {
            $pathfile = $dir . '/' . $file;
            $image = new SplFileInfo($file);
            if($image->getExtension() == 'jpg') {
                echo '<li><a href ="' . $pathfile . '">' . $file . ' </a></li>';
            }
            if($image->getExtension() != 'jpg') {
                echo '<li><a href ="?f=' . $pathfile . '">' . $file . ' </a></li>';

            }
                if (filetype($pathfile) == 'dir') {
                mkmap($pathfile);

            }
        }
    }
    echo "</ul>";
}

mkmap('files');

if (isset ($_GET["f"])) {

    $fichier = $_GET["f"];
    $contenu = file_get_contents($fichier);

    if (isset($_POST["contenu"])) {
        $fichier = $_GET["f"];
        $file = fopen($fichier, "w");
        fwrite($file, $_POST["contenu"]);
        header('Location:index.php');
    }

    ?>
    <form method="POST" action="">
        <p><textarea name="contenu" style="width: 100%; height: 500px;"><?php echo $contenu; ?></textarea>
            <input type="hidden" name="file" value="<?= $_GET["f"] ?>"/>
            <input type="submit" value="Envoyer"/></p>
    </form>
    <?php

    if (isset($_POST["delete"]) && isset($_GET["f"])) {
        $fichier = $_GET["f"];
        unlink($fichier);

        header('Location:index.php');
    }

    if (isset ($_GET["f"])) {


        ?>
        <form method="POST" action="">
            <input type="hidden" name="delete" value="<?= $_GET["f"] ?>"/>
            <input type="submit" value="Supprimer un fichier"/>
        </form>
        <?php
    }
}
?>

<?php include('inc/foot.php'); ?>
