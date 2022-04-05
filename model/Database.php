<?php

/**
 * 
 * Fichier database pour appeler les méthodes
 * 
 * Auteur : Diego Da Silva
 * Date : 28.02.2022
 * Description : 
 */


 class Database {


    // Variable de classe
    private $connector;

    /**
     * Se connecter via PDO et utilise la variable de classe $connector
     */
    public function __construct(){

        try
        {
            $this -> connector = new PDO('mysql:host=localhost; dbname=db_nickname_diedasilva; charset=utf8' , 'dbUser_DiegoDaSilva', '.Etml-');
        }
        catch (PDOException $e)
        {
            die('Erreur : ' . $e->getMessage());
        }
    }

    /**
     * permet de préparer et d’exécuter une requête de type simple (sans where)
     */
    private function querySimpleExecute($query){

        $req = $this -> connector->prepare($query);
        $req->execute();
        return $req;
    }

    /**
     * permet de préparer, de binder et d’exécuter une requête (select avec where ou insert, update et delete)
     */
    private function queryPrepareExecute($query, $binds){
        
        $req =  $this->connector->prepare($query);
        foreach($binds as $key => $value){
            $req->bindValue($binds[$key]['name'], $binds[$key]["value"], $binds[$key]["type"]);
        }
        $req->execute();

        return $req;
    }

    /**
     * traiter les données pour les retourner par exemple en tableau associatif (avec PDO::FETCH_ASSOC)
     */
    private function formatData($req){

        $result = $req->fetchALL(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * vider le jeu d’enregistrement
     */
    private function unsetData($req){

        $req->closeCursor();
    }

    /**
     * récupère la liste de tous les enseignants de la BD    
     */
    public function getAllTeachers(){
    
        // avoir la requête sql
        $queryTeacher = 'SELECT idTeacher, `teaFirstname`, `teaName`, `teaGender`, `teaNickname` FROM `t_teacher`';

        // appeler la méthode pour executer la requête
        $getQueryTeacher = $this -> querySimpleExecute($queryTeacher);

        // appeler la méthode pour avoir le résultat sous forme de tableau
        // retour tous les enseignants
        return $this -> formatData($getQueryTeacher);
        
    }

    /**
     * récupère la liste des informations pour 1 enseignant
     */
    public function getOneTeacher($id){

        // avoir la requête sql pour 1 enseignant (utilisation de l'id)
        $queryOneTeacher = "SELECT `teaFirstname`, `teaName`, `teaGender`, `teaNickname`, `teaOrigine`, `secName` FROM `t_teacher` INNER JOIN `t_section` ON t_section.idSection = t_teacher.fkSection WHERE idTeacher=:varId";

        $bindTeacher = array(
            array("name" => "varId" , "value" => $id, "type"=> PDO::PARAM_INT)
        );

        // appeler la méthode pour executer la requête
        $getQueryOneTeacher = $this -> queryPrepareExecute($queryOneTeacher, $bindTeacher);

        // appeler la méthode pour avoir le résultat sous forme de tableau
        // retour l'enseignant
        return $this -> formatData($getQueryOneTeacher);    
    }
    /**
     * créer un enseignant avec toute ses coordenées
     */
    public function insertTeacher($firstname, $name, $gender, $nickname, $origin, $section){
        
        //avoir la requête pour insérer un professeur
            $queryInsertTeacher = "INSERT INTO `t_teacher`(`idTeacher`, `teaFirstname`, `teaName`, `teaGender`, `teaNickname`, `teaOrigine`, `fkSection`) VALUES (NULL, :firstname, :name, :gender, :nickname, :origin, :section)";

            $bindInsertTeacher = array(
                0=>array("name" => "firstname", "value" => $firstname, "type" => PDO::PARAM_STR),
                1=>array("name" => "name", "value" => $name, "type" => PDO::PARAM_STR),
                2=>array("name" => "gender", "value" => $gender, "type" => PDO::PARAM_STR),
                3=>array("name" => "nickname", "value" => $nickname, "type" => PDO::PARAM_STR),
                4=>array("name" => "origin", "value" => $origin, "type" => PDO::PARAM_STR),
                5=>array("name" => "section", "value" => $section, "type" => PDO::PARAM_INT)
            );
            
            // appeler la méthode pour executer la requête
            $this->queryPrepareExecute($queryInsertTeacher, $bindInsertTeacher);
    }
    /**
     * Fontion pour afficher toute les sections
     */
    public function getAllSections()
    {
        //requête pour selectionner les sections
        $querySections='SELECT `idSection`, `secName` FROM `t_section`';

        // appeler la méthode pour executer la requête
        $result=$this->querySimpleExecute($querySections);
    
        // appeler la méthode pour avoir le résultat sous forme de tableau
        // retour tous les enseignants
        return $this->formatData($result);
    }
     /**
      * Permet de modifier un enseignant qui est déjà enregistrer
      */
    public function updateTeacher($id, $firstName,  $name,   $gender, $nickname, $origine, $section, )
    {
        //requête pour modifier 
        $addTeacher = "UPDATE t_teacher SET teaFirstname=:firstname, teaName=:name, teaGender=:gender, teaNickname=:nickname, teaOrigine=:origine, fkSection=:section WHERE idTeacher=:id";

        //tableau pour toute les informations
        $bindTeacher = array(
            0 => array("name" => "firstname", "value" => $firstName, "type" => PDO::PARAM_STR),
            1 => array("name" => "name", "value" => $name, "type" => PDO::PARAM_STR),
            2 => array("name" => "gender", "value" => $gender, "type" => PDO::PARAM_STR),
            3 => array("name" => "nickname", "value" => $nickname, "type" => PDO::PARAM_STR),
            4 => array("name" => "origine", "value" => $origine, "type" => PDO::PARAM_STR),
            5 => array("name" => "section", "value" => $section, "type" => PDO::PARAM_INT),
            6 => array("name" => "id", "value" => $id, "type" => PDO::PARAM_INT)
        );
         //Appeler la méthode pour executer la requète
         $addTeacher = $this->queryPrepareExecute($addTeacher, $bindTeacher);

        // appeler la méthode pour avoir le résultat sous forme de tableau
        // retour tous les enseignants
         $returnTeacher = $this->formatData($addTeacher);

         //Vide le jeu d'enregistrement 
         $this->unsetData($addTeacher);

         //Retourne l'enseignant
         return $returnTeacher;
    }

    /**
     * Permet de supprimer un professeur
     */
    public function deleteTeacher($id){

        //requête pour modifier
        $queryTeacher ="DELETE FROM `t_teacher` WHERE idTeacher =:varId";
 
        //tableau
        $bindTeachers = array( 
             array("name" => "varId", "value" => $id, "type" => PDO::PARAM_INT)
        );

        //Appel la méthode pour exécuter la requête
        $this->queryPrepareExecute($queryTeacher, $bindTeachers);
    }
    public function addVote(){
    }
}
?>