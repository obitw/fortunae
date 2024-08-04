<!DOCTYPE html>
<html>
<body>
<?php
/** @var string $erreur */
if(empty($erreur)){
    echo "Problème avec la machine à sous";
}
else{
    echo "Problème avec la machine à sous : " . $erreur;
}
?>
</body>
</html>
