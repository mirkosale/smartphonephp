<?php

/**
 * ETML
 * Auteur : Cindy Hardegger
 * Date: 22.01.2019
 * Controler pour gérer les recettes
 */

include_once 'model/database.php';

class PhoneController extends Controller
{

    /**
     * Permet de choisir l'action à effectuer
     *
     * @return mixed
     */
    public function display()
    {

        $action = $_GET['action'] . "Action";

        // Appelle une méthode dans cette classe (ici, ce sera le nom + action (ex: listAction, detailAction, ...))
        return call_user_func(array($this, $action));
    }

    /**
     * Rechercher les données et les passe à la vue (en liste)
     *
     * @return string
     */
    private function listAction()
    {

        // Instancie le modèle et va chercher les informations
        $db = new Database();
        $phones = $db->getAllPhones();

        // Charge le fichier pour la vue
        $view = file_get_contents('view/page/phone/list.php');


        // Pour que la vue puisse afficher les bonnes données, il est obligatoire que les variables de la vue puisse contenir les valeurs des données
        // ob_start est une méthode qui stoppe provisoirement le transfert des données (donc aucune donnée n'est envoyée).
        ob_start();
        // eval permet de prendre le fichier de vue et de le parcourir dans le but de remplacer les variables PHP par leur valeur (provenant du model)
        eval('?>' . $view);
        // ob_get_clean permet de reprendre la lecture qui avait été stoppée (dans le but d'afficher la vue)
        $content = ob_get_clean();

        return $content;
    }

    /**
     * Rechercher les données et les passe à la vue (en détail)
     *
     * @return string
     */
    private function detailAction()
    {
        if (isset($_GET['id']))
        {
            $db = new Database();
            $phone = $db->getOnePhone($_GET['id']);
            $os = $db->getOs($phone[0]['fkOs']);
            if (!isset($phone[0]))
            {
                $view = file_get_contents('view/page/phone/badPhone.php');
            }
        } else {
            $view = file_get_contents('view/page/phone/badPhone.php');
        }

        
        if (!isset($view)) {
            $view = file_get_contents('view/page/phone/detail.php');
        }
        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    private function orderOSAction()
    {

        if (!isset($_GET['id'])) {
            $id = 1;
        } else {
            $id = $_GET['id'];
        }
        
        $db = new Database();
        $os = $db->getAllOs();
        $phones = $db->orderPhoneByOS($id);

        if (!isset($phones[0]))
        {
            $view = file_get_contents('view/page/phone/badOs.php');
        }
        
        if (!isset($view)) {
            $view = file_get_contents('view/page/phone/listOs.php');
        }

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    private function orderScreenAction()
    {
        $db = new Database();
        $phones = $db->orderPhoneByScreen(0);

        $view = file_get_contents('view/page/phone/list.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    private function orderBrandAction()
    {
        $db = new Database();
        $brands = $db->getAllBrands();

        var_dump($brands);
        if (isset($_GET['brand'])) {
            foreach ($brands as $brand) {
                if ($_GET['brand'] == $brand['smaBrand']) {
                    $currentBrand = $_GET['brand'];
                }
            }
        } else {
            $currentBrand = $brands[0]['smaBrand'];
        }

        $phones = $db->orderPhoneByBrand($currentBrand);

        $view = file_get_contents('view/page/phone/list.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    private function orderBatteryAction()
    {
        $db = new Database();
        $phones = $db->orderPhoneByBatteryLife();

        $view = file_get_contents('view/page/phone/list.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    private function orderCpuAction()
    {
        $db = new Database();
        $phones = $db->orderPhoneByCPU(10);

        $view = file_get_contents('view/page/phone/list.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    private function orderRAMAction()
    {
        $db = new Database();
        $phones = $db->orderPhoneByRAM();

        $view = file_get_contents('view/page/phone/list.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    private function orderMostExpensiveAction()
    {
        $db = new Database();
        $phones = $db->orderMostExpensiveSmartphone();

        $view = file_get_contents('view/page/phone/list.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }

    private function orderLeastExpensiveAction()
    {
        if (isset($_GET['os'])) {
            $os = htmlspecialchars(trim($_GET['os']));
        } else {
            $os = 1;
        }
        $db = new Database();
        $phones = $db->orderByLowestPricePerBrandPerOs($os);

        $view = file_get_contents('view/page/phone/list.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }
}
