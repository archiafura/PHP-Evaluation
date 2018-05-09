<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 09/05/2018
 * Time: 15:50
 */
function classAutoLoader($className) {

    require_once "./classes/" . $className . ".php";
}