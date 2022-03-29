<!--
ETML 
Author : Kandasamy Pruthvin
Date   : 28.02.2022
Description: les données sont traitées et affichées directement dans la page d’accueil.
 Mais, nous allons créer plusieurs pages avec des liaisons à la BD. A terme, nous ne voulons pas recopier toujours les mêmes instructions.
 De ce fait, nous allons créer une classe afin de regrouper les méthodes nécessaires à nos requêtes.
-->
<?php
 class Database {
    // Variable de classe
    private $connector;
   
    /**
     *  methode permettant de se connecter a la base de donnée avec PDO
     */
    public function __construct(){
        $pass = '.Etml-';
        $user = 'dbUser_pt41kyp';
        try
        {
        $this->connector = new PDO('mysql:host=localhost;dbname=db_nickname_pt41kyp;charset=utf8' , $user, $pass);
        }
        catch (PDOException $e)
        {
        die('Erreur : ' . $e->getMessage());
        }
        // Se connecter via PDO et utilise la variable de classe $connector
    }

    /**
     * permet de préparer et d’exécuter une requête de type simple (sans where)
     */
    private function querySimpleExecute($query){
        $req = $this -> connector->query($query);
        return $req;
    }

    /**
     * permet de préparer, de binder et d’exécuter une requête (select avec where ou insert, update et delete)
     */
    private function queryPrepareExecute($query, $binds){
        $req =  $this->connector->prepare($query);
        foreach($binds as $key => $value){
            $req->bindValue($value['name'], $value["value"], $value["type"]);
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
     * methode permettant de récupèrer tout les enseignants
     */
    public function getAllTeachers(){
        //récupère la liste de tous les enseignants de la BD
        //avoir la requête sql
        //appeler la méthode pour executer la requête
        //appeler la méthode pour avoir le résultat sous forme de tableau
        //retour tous les enseignants
        $queryTeachers = "SELECT * FROM t_teacher ";
        $reqTeachers = $this->querySimpleExecute($queryTeachers);
         
        $returnTeachers=$this->formatData($reqTeachers);
        $this -> unsetData($reqTeachers);
        return $returnTeachers;
    }

    /**
     * methode permettant de récupèrer un enseignant
     */
    public function getOneTeacher($id){
        // récupère la liste des informations pour 1 enseignant b 
        // avoir la requête sql pour 1 enseignant (utilisation de l'id)
        // appeler la méthode pour executer la requête
        // appeler la méthode pour avoir le résultat sous forme de tableau
        // retour l'enseignant
        $queryOneTeacher = "SELECT * FROM t_teacher INNER JOIN t_section ON t_section.idSection = t_teacher.fkSection WHERE idTeacher=:varId";
        $bindTeacher = array(
            array("name" => "varId" , "value" => $id, "type"=> PDO::PARAM_INT)
        );
        $reqTeachers = $this->queryPrepareExecute($queryOneTeacher,$bindTeacher);
        $returnTeachers=$this->formatData($reqTeachers);
        $this -> unsetData($reqTeachers);
        return $returnTeachers;
    }

    /**
     * methode permettant d'ajouter un enseignant
     */
    public function InsertTeacher($teacherData)
    {
        // insert les informations
        // avoir la requête sql
        // appeler la méthode pour executer la requête
        $query = "INSERT INTO t_teacher (idTeacher, teaFirstname, teaName, teaGender, teaNickname, teaOrigine, fkSection) 
                  VALUES (NULL, :firstName, :name, :genre, :nickName, :origin, :section)";

        $binds = [
            ["name" => 'name', 'value' => $teacherData['name'], 'type' => PDO::PARAM_STR],
            ["name" => 'firstName', 'value' => $teacherData['firstName'], 'type' => PDO::PARAM_STR],
            ["name" => 'genre', 'value' => $teacherData['genre'], 'type' => PDO::PARAM_STR],
            ["name" => 'nickName', 'value' => $teacherData['nickName'], 'type' => PDO::PARAM_STR],
            ["name" => 'origin', 'value' => $teacherData['origin'], 'type' => PDO::PARAM_STR],
            ["name" => 'section', 'value' => $teacherData['section'], 'type' => PDO::PARAM_INT]
        ];

        $this->queryPrepareExecute($query, $binds);
    }

     /**
     * methode permettant de modifier un enseignant
     */
    public function modifyTeacher($teacherData)
    {
        //modifie les informations du teacher
        //avoir la requête sql
        // appeler la méthode pour executer la requête.
        $query = "UPDATE t_teacher SET teaFirstname = :firstName, teaName = :name, teaGender = :genre, teaNickname = :nickName,
                     teaOrigine = :origin, fkSection = :section WHERE t_teacher.idTeacher = :id";

        $binds = [
            ["name" => 'name', 'value' => $teacherData['name'], 'type' => PDO::PARAM_STR],
            ["name" => 'firstName', 'value' => $teacherData['firstName'], 'type' => PDO::PARAM_STR],
             ["name" => 'genre', 'value' => $teacherData['genre'], 'type' => PDO::PARAM_STR],
             ["name" => 'nickName', 'value' => $teacherData['nickName'], 'type' => PDO::PARAM_STR],
             ["name" => 'origin', 'value' => $teacherData['origin'], 'type' => PDO::PARAM_STR],
             ["name" => 'section', 'value' => $teacherData['section'], 'type' => PDO::PARAM_INT],
             ["name" => 'id', 'value' => $teacherData['id'], 'type' => PDO::PARAM_INT]
        ];

        $this->queryPrepareExecute($query, $binds);
    }

    /**
     * methode permettant de delete un enseignant
     */
    public function deleteTeacher($idTeacher)
    {
        //supprime l'enseignant
        //avoir la requête sql 
        //appeler la méthode pour executer la requête
        //appeler la méthode pour avoir le résultat sous forme de tableau.
        $query = 'DELETE FROM t_teacher WHERE idTeacher = :idTeacher';

        //avoir la requête sql pour le delete.
        $binds = [
            ["name" => "idTeacher", "value" => $idTeacher, "type" => PDO::PARAM_INT]
        ];
        $req = $this->queryPrepareExecute($query, $binds);

        return $this->formatData($req);
    }

    /**
     * methode permettant de récupérer les sections
     */
    public function getSections()
    {
        //récupère la liste de toutes les section de la BD
        //appeler la méthode pour executer la requête 
        $query = 'SELECT * FROM t_section';
        $req = $this->querySimpleExecute($query);

        // Retour les sections sous forme de tableau associatif
        return $this->formatData($req);
    }
    
    /**
     * methode permettant de récupérer une sections
     */
    public function getOneSections()
    {
        //récupère la liste de toutes les section de la BD
        //avoir la requête sql
        //appeler la méthode pour executer la requête
        $query = 'SELECT * FROM t_section';
        $binds = [
            ["name" => "idSection", "value" => $idSection, "type" => PDO::PARAM_INT]
        ];
        $req = $this->queryPrepareExecute($query);

        // Retour les sections sous forme de tableau associatif
        return $this->formatData($req);
    }

    /**
     * methode permettant de récupérer un utilisateur
     */
    public function getOneUser($username,$password)
    {
        //récupère un utilisateur de la BD
        //avoir la requête sql
        //appeler la méthode pour executer la requête
        $query = 'SELECT * FROM t_user WHERE useLogin = :username AND usePassword = :password';
        $binds = [
            ["name" => "username", "value" => $username, "type" => PDO::PARAM_STR],
            ["name" => "password", "value" => $password, "type" => PDO::PARAM_STR]
        ];
        $req = $this->queryPrepareExecute($query, $binds);

        // Retour les sections sous forme de tableau associatif
        return $this->formatData($req);

    }

    /**
     * methode permettant de récupérer tout les utilisateurs
     */
    public function getUser($idUser){
        //récupère la liste de tous les utilisateur de la BD
        //avoir la requête sql
        //appeler la méthode pour executer la requête
        $query = 'SELECT * FROM t_user WHERE idUser = :idUser';
        $binds = [
            ["name" => "idUser","value" => $idUser, "type" => PDO::PARAM_INT]
        ];
        $req = $this->queryPrepareExecute($query, $binds);

        // Retour les sections sous forme de tableau associatif
        return $this->formatData($req);

    }
    /** 
     * methode permettant d'ajoute une session dans la base de données
     */
    public function addSession($idUser)
    {
        //insert une session a la BD
        //avoir la requête sql
        //appeler la méthode pour executer la requête
        $query = "INSERT INTO t_session (idSession, fkUser) VALUES (NULL, :idUser)";
        $binds =  [
            ["name" => 'idUser', 'value' => $idUser, 'type' => PDO::PARAM_STR]
        ];

        $this->queryPrepareExecute($query, $binds);

        // Retourne l'id de la session crée
        return $this->getIdSessionByUserId($idUser);
    }

    /*
     * methode permettant de récupèrer l'ID d'une session en fonction d'un idUser ; Retourne null si pas de résultats ; sinon retourne l'idSession
     */
    private function getIdSessionByUserId($idUser)
    {
        $query = "SELECT idSession FROM t_session WHERE fkUser = :idUser";
        $binds = [
            ["name" => 'idUser', 'value' => $idUser, 'type' => PDO::PARAM_STR]
        ];

        $req = $this->queryPrepareExecute($query, $binds);
        $result = $this->formatData($req);

        return $result ? $result[0]['idSession'] : null;
    }

    /**
     * methode permettant de Récupèrer une session avec l'id donné et si elle existe retoune la session sinon null
     */
    public function getOneSession($idSession)
    {
        $query = "SELECT * FROM t_session WHERE idSession = :idSession";
        $binds = [
            ["name" => 'idSession','value' => $idSession, 'type' => PDO::PARAM_INT]
        ];

        $req = $this->queryPrepareExecute($query, $binds);
        $session = $this->formatData($req);

        return !$session ? null : $session[0];
    }

    /**
    * methode permettant de supprimer une session avec l'id donné
    */ 
    public function deleteSession($idSession)
    {
        return !$session ? null : $session[0];
        $query = 'DELETE FROM t_session WHERE idSession = :idSession';
        $binds = [
            ["name" => "idSession", "value" => $idSession, "type" => PDO::PARAM_INT]
        ];
        $req = $this->queryPrepareExecute($query, $binds);
        return $this->formatData($req);
    }
 }
?>