<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 09/05/2018
 * Time: 15:22
 */

class Chat
{

    private $prenom;
    private $age;
    private $couleur;
    private $sexe;
    private $race;

    public function getPrenom(){
        return  $this->prenom;
    }

    public function setPrenom($prenom){
        $this->prenom = $prenom;
    }

    public function getAge(){
        return  $this->age;
    }

    public function setAge($age){
        $this->age = $age;
    }

    public function getCouleur(){
        return  $this->couleur;
    }

    public function setCouleur($couleur){
        $this->couleur = $couleur;
    }

    public function getSexe(){
        return  $this->sexe;
    }

    public function setSexe($sexe){
        $this->sexe = $sexe;
    }

    public function getRace(){
        return  $this->race;
    }

    public function setRace($race){
        $this->public = $race;
    }


    function __construct($prenom, $age, $couleur, $sexe, $race)
    {
        if(is_string($prenom) && strlen($prenom) > 3 && strlen($prenom) < 20)
        {
            $this->prenom = $prenom;
        }
        else
            {
            echo "Entrez un nom comportant de 3 à 20 caractères";
            }

        if(is_int($age))
        {
            $this->age = $age;
        }
        else
            {
            echo "Entre un chiffre entier";
        }

        if(is_string($couleur) && strlen($couleur) > 3 && strlen($couleur) < 10)
        {
            $this->couleur = $couleur;
        }
        else
            {
            echo "Entrez une couleur comportant de 3 à 10 caractères";
        }

        if(is_string($sexe) && ($sexe === "male" || $sexe === "femelle"))
        {
            $this->sexe = $sexe;
        }
        else
            {
            echo "Entrez male ou femelle";
        }

        if(is_string($race) && strlen($race) > 3 && strlen($race) < 20)
        {
            $this->race = $race;
        }
        else{
            echo "Entrer une race comportant de 3 à 20 caractères";
        }
    }


    public function getInfos() {
        echo "<table>
            <tr>
              <th>Prénom</th>
              <th>Age</th>
              <th>Couleur</th>
              <th>Sexe</th>
              <th>Race</th>
            </tr>
            <tr>
              <td>".$this->prenom."</td>
              <td>".$this->age."</td>
              <td>".$this->couleur."</td>
              <td>".$this->sexe."</td>
              <td>".$this->race."</td>
            </tr>
          </table>";
    }

}