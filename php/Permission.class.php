<?php
require_once('fonctions.php');
class Permission extends Authentification{ 

    public function __construct(){       
        parent::__contruct();
        $this->user_permission();
    }

    private function user_permission(){
        if($_SESSION['type'] == 1){
            $_SESSION['listing'] = "enable";
        }else{$_SESSION['listing'] = "enable";}
    }
    
}

?>