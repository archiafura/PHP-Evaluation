<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 09/05/2018
 * Time: 15:58
 */


require_once "./function/classAutoLoad.php";
spl_autoload_register('classAutoLoader');

$chat1 = new Chat("Praline", 36, "Beige", "male", "Luxe");

$chat2 = new Chat("Miaoux", 8, "Marron", "male", "Pokemon");

$chat3 = new Chat("Isidor", 12, "Orange", "male", "Gouttière");

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LES CHATS</title>
</head>
<body>
<h1>Les CHATS :</h1>
<?php $chat1 -> getInfos(); ?><br>
<?php $chat2 -> getInfos(); ?><br>
<?php $chat3 -> getInfos(); ?>
</body>
</html>