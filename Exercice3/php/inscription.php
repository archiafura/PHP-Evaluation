<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 09/05/2018
 * Time: 14:22
 */

try
{
    $pdo = new PDO('mysql:host=localhost;dbname=location', "root", "", array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
    ));
}
catch (PDOException $e)
{
    echo 'Erreur de connexion : ' . $e->getMessage();
}


//Définition des variables de récupération du formulaire


$marque = $_REQUEST['marque'] ?? "";
$modele = $_REQUEST['modele'] ?? "";
$annee = $_REQUEST['annee'] ?? "";
$couleur = $_REQUEST['couleur'] ?? "";


//Vérification de la présence des variables

if(isset($_POST['marque']) && isset($_POST['modele']) && isset($_POST['annee']) && isset($_POST['couleur']) )
{
    //Vérifier que les champs ne soient pas vides

    if(($_POST['marque'] != '') && ($_POST['modele'] != '') && ($_POST['annee'] != '') && ($_POST['couleur'] != ''))
    {
        $reponse = 'ok';
    }
     else
        {
        $reponse = 'Les champs sont vides';
        }
}
 else
    {
    $reponse = 'Tous les champs ne sont pas parvenus';
    }


$array['reponse'] = $reponse;


$connect = $pdo ->prepare('INSERT INTO voiture (marque, modele, annee, couleur)
VALUES (:marque, :modele, :annee, :couleur)');

$verficiation = $connect -> execute(array(
    "marque" => $_REQUEST['marque'],
    "modele" => $_REQUEST['modele'],
    "annee" => $_REQUEST['annee'],
    "couleur" => $_REQUEST['couleur']
));


if ($verficiation) {


    header('Content-Type: application/json');


    echo json_encode($array);

}