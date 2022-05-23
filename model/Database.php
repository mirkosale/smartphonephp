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
        include('config.php');

        try
        {   
            $this->connector = new PDO("mysql:host=$DB_SERVER;dbname=$DB_NAME;charset=utf8" , $DB_USER, $DB_PASSWORD);
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
    public function getAllPhones(){
    
        // avoir la requête sql
        $queryPhone = 'SELECT * FROM `t_smartphone`';

        // appeler la méthode pour executer la requête
        $getQueryPhone = $this -> querySimpleExecute($queryPhone);

        // appeler la méthode pour avoir le résultat sous forme de tableau
        // retour tous les enseignants
        return $this -> formatData($getQueryPhone);
        
    }

    /**
     * récupère la liste de tous les enseignants de la BD    
     */
    public function getAllBrands(){
    
        // avoir la requête sql
        $query = 'SELECT smaBrand FROM `t_smartphone` GROUP BY smaBrand';

        // appeler la méthode pour executer la requête
        $req = $this -> querySimpleExecute($query);

        // appeler la méthode pour avoir le résultat sous forme de tableau
        // retour tous les enseignants
        return $this -> formatData($req);
        
    }
    
    /**
     * récupère la liste des informations pour 1 enseignant
     */
    public function getOnePhone($id){

        // avoir la requête sql pour 1 enseignant (utilisation de l'id)
        $queryOnePhone = "SELECT * FROM `t_smartphone` WHERE idSmartphone = :varId";

        $bindPhone = array(
            array("name" => "varId" , "value" => $id, "type"=> PDO::PARAM_INT)
        );

        // appeler la méthode pour executer la requête
        $getQueryOnePhone = $this -> queryPrepareExecute($queryOnePhone, $bindPhone);

        // appeler la méthode pour avoir le résultat sous forme de tableau
        // retour l'enseignant
        return $this -> formatData($getQueryOnePhone);    
    }

    /**
     * Fontion pour afficher toute les sections
     */
    public function getAllOs()
    {
        //requête permettant de selectionner et de grouper par os
        $getQueryOnePhone = 'SELECT * FROM `t_os` GROUP BY `idOs`';

        //appeler la méthode pour l'executer
        $result = $this->querySimpleExecute($getQueryOnePhone);

        // appeler la méthode pour avoir le résultat sous forme de tableau
        // retour tous les enseignants
        return $this->formatData($result);
    }

    public function getOs($id)
    {
        //requête permettant de selectionner et de grouper par os
        $query = 'SELECT * FROM `t_os` WHERE `idOs` = :id';

        $binds = [
            ["name" => "id", "value" => $id, "type" => PDO::PARAM_INT]
        ];

        //appeler la méthode pour l'executer
        $result = $this->queryPrepareExecute($query, $binds);

        // appeler la méthode pour avoir le résultat sous forme de tableau
        // retour tous les enseignants
        return $this->formatData($result);
    }

    public function orderPhoneByOS($id)
    {
        //requête permettant de selectionner et de grouper par os
        $query = 'SELECT * FROM t_smartphone WHERE fkOS = :varId';

        $binds = array(
            array("name" => "varId" , "value" => $id, "type"=> PDO::PARAM_INT)
        );

        //appeler la méthode pour l'executer
        $result = $this->queryPrepareExecute($query, $binds);

        // appeler la méthode pour avoir le résultat sous forme de tableau
        // retour tous les enseignants
        return $this->formatData($result);
    }

    public function orderPhoneByBatteryLife()
    {
        $query = 
        "SELECT * FROM t_smartphone ORDER BY smaBatteryLastedMinutes DESC LIMIT 5;";
        //appeler la méthode pour l'executer
        $result = $this->querySimpleExecute($query);


        // appeler la méthode pour avoir le résultat sous forme de tableau
        // retour tous les enseignants
        return $this->formatData($result);
    }


    public function orderPhoneByScreen($limit){

        //requête permettant de selectionner et de grouper par taille de l'écran
        $queryClassPhone = 'SELECT * FROM `t_smartphone` ORDER BY `smaDisplaySize` ASC';
        
        $binds = array(
            array("name" => "varId" , "value" => $limit, "type"=> PDO::PARAM_INT)
        );

        //appeler la méthode pour l'executer
        $result = $this->querySimpleExecute($queryClassPhone);

        // appeler la méthode pour avoir le résultat sous forme de tableau
        // retour tous les iphones
        return $this->formatData($result);
    }

    /**
     * Requête permettant de voir l'évolution du prix avec aussi toute les informations du smartphone
     */
    public function getSmartphonePrice($idPhone){

        //requête permettant de selectionner les infos et de voir l'évolution du prix par date
        $queryPriceEvolution = 'SELECT * FROM `t_price` as p INNER JOIN t_smartphone as s on s.idSmartphone = p.fkSmartphone WHERE fkSmartphone = :idPhone ORDER BY p.priDate';

        //regroupe  les info dans un tableau
        $bindPhone = array(
            array("name" => "idPhone" , "value" => $idPhone, "type"=> PDO::PARAM_INT)
        );
        //appeler la màthode pour s'éxecuter
        $result = $this->queryPrepareExecute($queryPriceEvolution, $bindPhone);

        //retourne les informations 
        return $this->formatData($result);
    }

    /**
     * Requête pour regourper par cosntructeur les smartphone
     */
    public function orderPhoneByBrand($brand){

        //requête permettant de sélectionenr le constructeur
        $query = 'SELECT * FROM `t_smartphone` WHERE `smaBrand` = :brandName';

        $binds = array(
            array("name" => "brandName" , "value" => $brand, "type"=> PDO::PARAM_INT)
        );

        $req = $this->queryPrepareExecute($query, $binds);

       
        // appeler la méthode pour avoir le résultat
        // retour tous les infos
        $result = $this->formatData($req);

        return $result;
    }

    /**
     * Requête permettant d'ordonner par prix, par os
     */
    public function orderPhoneByCPU($limit)
    {
        $query = 
        "SELECT * FROM t_smartphone ORDER BY (smaCPUCores * smaCPUClockSpeed) DESC LIMIT :varId;";

        $binds = array(
            array("name" => "varId" , "value" => $limit, "type"=> PDO::PARAM_INT)
        );
        //appeler la méthode pour l'executer
        $result = $this->queryPrepareExecute($query, $binds);


        // appeler la méthode pour avoir le résultat sous forme de tableau
        // retour tous les enseignants
        return $this->formatData($result);
    }

    public function orderPhoneByRAM()
    {
        $query = 
        "SELECT * FROM t_smartphone ORDER BY smaRAM DESC LIMIT 5;";
        //appeler la méthode pour l'executer
        $result = $this->querySimpleExecute($query);


        // appeler la méthode pour avoir le résultat sous forme de tableau
        // retour tous les enseignants
        return $this->formatData($result);
    }

    public function orderMostExpensiveSmartphone()
    {
        $query = 
        "SELECT * FROM t_smartphone as s INNER JOIN t_price as p on s.idSmartphone = p.fkSmartphone GROUP BY smaFullName WHERE SELECT priAmount FROM t_price ORDER BY priAmount ASC
        ;";

        //appeler la méthode pour l'executer
        $result = $this->querySimpleExecute($query);


        // appeler la méthode pour avoir le résultat sous forme de tableau
        // retour tous les enseignants
        return $this->formatData($result);
    }

    public function orderByLowestPricePerBrandPerOs($idOS)
    {
        $query = 
        "SELECT * FROM t_smartphone as s INNER JOIN t_price as p on s.idSmartphone = p.fkSmartphone 
        WHERE fkOS = :varId AND (SELECT priAmount FROM t_price ORDER BY priAmount DESC LIMIT 1);";

        $binds = array(
            array("name" => "varId" , "value" => $idOS, "type"=> PDO::PARAM_INT)
        );

        //appeler la méthode pour l'executer
        $result = $this->queryPrepareExecute($query, $binds);

        // appeler la méthode pour avoir le résultat sous forme de tableau
        // retour tous les enseignants
        return $this->formatData($result);
    }
}
?>