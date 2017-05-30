

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="bootstrap-3.3-2.7-dist/css/bootstrap.css" type="text/css">
    <link rel="script" href="bootstrap-3.3-2.7-dist/js/bootstrap.js" type="text/script">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="bootstrap-3.3-2.7-dist/css/monstyle.css" type="text/css">

</head>
<body>
<form method="POST" action="index.php" enctype="multipart/form-data">
    Fichier : <input type="file" name="avatar[]" multiple />
    <input type="submit" name="envoyer" value="Envoyer le fichier">
</form>


</body>
</html>



<?php
if(isset($_POST['suppr'])){
    unlink($_POST['path']);
}

if(isset($_POST['envoyer'])) {
    $dossier = 'uploads/';
    $taille_maxi = 10000000;
    $extensions = array('.jpg', '.png', '.gif');

    $nbfichiersEnvoyes = count($_FILES['avatar']['name']);


    for ($i = 0; $i < $nbfichiersEnvoyes; $i++) {

        $fichier = basename($_FILES['avatar']['name'][$i]);
        $fichier_temp = $_FILES['avatar']['tmp_name'][$i];
        $taille = filesize($_FILES['avatar']['tmp_name'][$i]);
        $extension = strrchr($_FILES['avatar']['name'][$i], '.');

        if (!in_array($extension, $extensions)) $erreur = '<span class="non">Vous devez uploader le fichier ' . $i . ' de type PNG, JPEG ou JPG<br></span>';
        if ($taille > $taille_maxi) $erreur = '<span>Le fichier' . $i . ' est trop gros...</span>';
        if (!isset($erreur)) {
            $fichier = strtr($fichier, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
            $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
            $fichier = 'image' . '' . (rand(0, 1000000)) . $extension;
            if (move_uploaded_file($fichier_temp, $dossier . $fichier)) echo '<span class="okdac">Upload ' . $i . ' effectué avec succès !<br></span>';
            else echo '<span class="non">Echec de l\'upload ' . $i . ' !</span>';

        } else echo $erreur;

    }
    ?>

    <div class="container-fluid" >
        <div class="row">
            <div class="col-sm-6">
    <?php
    $images = scandir($dossier);
    foreach ($images as $image)

    {
        if($image !='.' && $image!='..'){


            echo '
                    <div class="thumbnail img-responsive" >
                      <img src="uploads/'.$image .'" class="upload">
                          <div class="caption">
                            <h3>'.$image.'</h3> 
                            <form method="POST" action="index.php">
                            <input type="hidden" value="'.$dossier.'/'.$image.'" name="path">
                            <input type="submit" value= "supprimer :'.$image.'" class="btn btn-danger" role="button" 
                            name="suppr" ></form>
                          </div>
                    </div>';

        }
    }
}
?>
            </div>
    </div>
  </div>





