<?php
    namespace Application\model\classes;

    trait AccessControl
    {
        public function testAccess(array $roles = []) : bool {
            if(!isset($_SESSION['role'])) {
                header("Location: /");
                return false;
            }	                        
            else if(!in_array($_SESSION['role'], $roles)) {
                $_SESSION['message'] = "<p class='alert alert-danger text-center'>You don't have priveleges to do that.</p>";
                header("Location: /");
                return false;
            }
            return true;
        }
    }    
?>