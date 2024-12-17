<?php
    namespace model\classes;

    trait AccessControl
    {
        public function testAccess(array $roles = []) : void {
            if(!isset($_SESSION['role'])) header("Location: /");	                        
            else if(!in_array($_SESSION['role'], $roles)) {
                $_SESSION['message'] = "<p class='alert alert-danger text-center'>You don't have priveleges to do that.</p>";
                header("Location: /");
                die;
            }
        }
    }    
?>