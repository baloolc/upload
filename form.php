<?php
$errs = [];
$errors = [];




if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $contact = array_map('trim', $_POST);
    $tmpName = $_FILES['avatar']['tmp_name'];
    $name = $_FILES['avatar']['name'];
    $uniqueName = uniqid('avatar', true);
    $uploadDir = 'public/uploads/';
    
   
    
    $extension = pathinfo($name, PATHINFO_EXTENSION);
    $authorizedExtensions = ['jpg', 'gif', 'png', 'webp'];
    $maxFileSize = 1000000;
    $file = $uniqueName . "." . $extension;
    $uploadFile = $uploadDir . $file;
   
   
   
    
    


    if ( (!in_array($extension, $authorizedExtensions))) {

        $errors[] = 'Veuillez sélectionner une image de type Jpg ou Gif ou Png ou webp !';
    }


    if (file_exists($tmpName) && filesize($tmpName) > $maxFileSize) {

        $errors[] = "Votre fichier doit faire moins de 1M !";
    }


        move_uploaded_file($tmpName, $uploadFile);

    
        
    
        
        
    
   


    if (empty($contact["lastname"])) {
        $errs[] = "Le nom est requis";
    }

    if (empty($contact["firstname"])) {
        $errs[] = "Le prénom est requis";
    }

    $lastnameMaxLength = 70;
    if (strlen($contact['lastname']) > $lastnameMaxLength) {
        $errs[] = 'Le nom doit faire moins de ' . $lastnameMaxLength . ' caractères';
    }

    $firstnameMaxLength = 70;
    if (strlen($contact['firstname']) > $firstnameMaxLength) {
        $errs[] = 'Le prénom doit faire moins de ' . $firstnameMaxLength . ' caractères';
    }

    if (empty($contact["age"])) {
        $errs[] = "L'âge est requis";
    }
    $ageMaxLength = 3;
    if (strlen($contact['age']) > $ageMaxLength) {
        $errs[] = 'L\'âge doit faire moins de ' . $ageMaxLength . ' nombres';
    }
   
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire</title>
</head>

<body>
    <form method="post" enctype="multipart/form-data">
        <ul>
            <?php foreach ($errs as $err) : ?>
                <li><?= $err ?></li>
            <?php endforeach; ?>
        </ul>
        <div>

            <label for="imageUpload">Upload an profile image</label>
            <input type="file" name="avatar" id="imageUpload" />
            <label for="firstname">Prénom</label>
            <input type="text" name="firstname" id="firstname" value=" <?= htmlentities($contact['firstname'] ?? '') ?>">
            <label for="lastname">Nom</label>
            <input type="text" name="lastname" id="lastname" value="<?= htmlentities($contact['lastname'] ?? '') ?>">
            <label for="age">âge</label>
            <input type="number" name="age" id="age" value="<?= htmlentities($contact['age'] ?? '') ?>">
            <button name="send">Send</button>
            
        </div>
    </form>
    <div>
       
        <ul>
            <?php foreach ($contact as $info) : ?>
                <li><?= $info; ?></li>
            <?php endforeach; ?>
        </ul>
        <img src="<?= $uploadFile; ?>" alt="" width="100" height="100">
    </div>
    



</body>

</html>