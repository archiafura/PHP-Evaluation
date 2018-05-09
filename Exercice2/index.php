<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 09/05/2018
 * Time: 13:19
 */

/*Cher stagiaire après vérification de ton code et quelques modifications; les classements ASC et DESC fonctionnent
correctement pour toutes les valeurs. Je peux également effectuer sans probleme une insertion en bdd.
Cependant, je t'inviterai à te replonger dans tes cours afin d'être plus performant.
Cordialement, sincères salutations, bisous.
Ta morue de tutrice. */

require_once "connect.php";   //Correction du nom du fichier php (connect.php et non connection.php)


$order = '';
$errors = [];  //Définition variable $errors pour pouvoir l'utiliser dans le tableau d'erreur



//Correction condition pour un classement correct de toutes les valeurs en ASC et DESC

if(isset($_GET['order']) && isset($_GET['column'])) {



    if($_GET['column'] == 'lastname') {

        $order = ' ORDER BY lastname';



        if ($_GET['order'] == 'asc') {

            $order .= ' ASC';



        } elseif ($_GET['order'] == 'desc') {

            $order .= ' DESC';

        }

    }



    elseif($_GET['column'] == 'firstname') {

        $order = ' ORDER BY firstname';



        if ($_GET['order'] == 'asc') {

            $order .= ' ASC';



        } elseif ($_GET['order'] == 'desc') {

            $order .= ' DESC';

        }

    }



    elseif($_GET['column'] == 'birthdate') {

        $order = ' ORDER BY birthdate';



        if ($_GET['order'] == 'asc') {

            $order .= ' ASC';



        } elseif ($_GET['order'] == 'desc') {

            $order .= ' DESC';

        }

    }



}

if(!empty($_POST))
{
    foreach ($_POST as $key => $value)
    {
        $post[$key] = strip_tags(trim($value));
    }

    //Correction parenthèse mal placée après le 3

    if (strlen($post['firstname']) < 3)
    {
        $errors[] = 'Le prénom doit comporter au moins 3 caractères';
    }
    if (strlen($post['lastname']) < 3)
    {
        $errors[] = 'Le nom doit comporter au moins 3 caractères';
    }

    //filter_var et non filter_variable

    if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL))
    {
        $errors[] = 'L\'adresse email est invalide';
    }

    if (empty($post['birthdate']))
    {
        $errors[] = 'La date de naissance doit être complétée';
    }
    if (empty($post['city']))
    {
        $errors[] = 'La ville ne peut être vide';
    }


    //correction nom de la variable $errors et insertion uniquement si === 0

    if (count($errors) === 0)
    {
        $insertUser = $db->prepare('INSERT INTO users (gender, firstname, lastname, email, birthdate, city) VALUES(:gender, :firstname, :lastname, :email, :birthdate, :city)');
        $insertUser->bindValue(':gender', $post['gender']);
        $insertUser->bindValue(':firstname', $post['firstname']); // oubli du ;
        $insertUser->bindValue(':lastname', $post['lastname']);
        $insertUser->bindValue(':email', $post['email']);
        $insertUser->bindValue(':birthdate', date('Y-m-d', strtotime($post['birthdate'])));
        $insertUser->bindValue(':city', $post['city']);


        if ($insertUser->execute())
        {
            $createUser = true;
        }
        else
        {
            $errors[] = 'Erreur SQL';
        }

    }
}
$queryUsers = $db->prepare('SELECT * FROM users'.$order);
if($queryUsers->execute())
{
    $users = $queryUsers->fetchAll(); //tiret en trop pour la fleche supprimé
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Exercice 1</title>
    <meta charset="utf-8">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">

    <h1>Liste des utilisateurs</h1>

    <p>Trier par :
        <a href="index.php?column=firstname&order=asc">Prénom (croissant)</a> |
        <a href="index.php?column=firstname&order=desc">Prénom (décroissant)</a> |
        <a href="index.php?column=lastname&order=asc">Nom (croissant)</a> |
        <a href="index.php?column=lastname&order=desc">Nom (décroissant)</a> |
        <a href="index.php?column=birthdate&order=desc">Âge (croissant)</a> |
        <a href="index.php?column=birthdate&order=asc">Âge (décroissant)</a>
    </p>
    <br>

    <div class="row">
        <?php
        if(isset($createUser) && $createUser == true){
            echo '<div class="col-md-6 col-md-offset-3">';
            echo '<div class="alert alert-success">Le nouvel utilisateur a été ajouté avec succès.</div>';
            echo '</div><br>'; //oubli du ;
        }

        //Si $errors != 0 et non si $errors vide

        if(!empty($errors)){
            echo '<div class="col-md-6 col-md-offset-3">';
            echo '<div class="alert alert-danger">'.implode('<br>', $errors).'</div>';
            echo '</div><br>';
        }
        ?>

        <div class="col-md-7">
            <table class="table">
                <thead>
                <tr>
                    <th>Civilité</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Age</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($users as $user):?>
                    <tr>
                        <td><?php echo $user['gender'];?></td>
                        <td><?php echo $user['firstname'];?></td>
                        <td><?php echo $user['lastname'];?></td>
                        <td><?php echo $user['email'];?></td>
                        <td><?php echo DateTime::createFromFormat('Y-m-d', $user['birthdate'])->diff(new DateTime('now'))->y;?> ans</td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="col-md-5">

            <form method="post" class="form-horizontal well well-sm">
                <fieldset>
                    <legend>Ajouter un utilisateur</legend>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="gender">Civilité</label>
                        <div class="col-md-8">
                            <select id="gender" name="gender" class="form-control input-md" required>
                                <option value="Mlle">Mademoiselle</option>
                                <option value="Mme">Madame</option><option value="M">Monsieur</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="firstname">Prénom</label>
                        <div class="col-md-8">
                            <input id="firstname" name="firstname" type="text" class="form-control input-md" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="lastname">Nom</label>
                        <div class="col-md-8">
                            <input id="lastname" name="lastname" type="text" class="form-control input-md" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="email">Email</label>
                        <div class="col-md-8">
                            <input id="email" name="email" type="email" class="form-control input-md" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="city">Ville</label>
                        <div class="col-md-8">
                            <input id="city" name="city" type="text" class="form-control input-md" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="birthdate">Date de naissance</label>
                        <div class="col-md-8">
                            <input id="birthdate" name="birthdate" type="text" placeholder="AAAA-MM-JJ" class="form-control input-md" required>
                            <span class="help-block">au format AAAA-MM-JJ</span>
                            <!--Changement du format de la date pour insertion correcte en base de données !-->

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-4 col-md-offset-4"><button type="submit" class="btn btn-primary">Envoyer</button></div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
</body>
</html>