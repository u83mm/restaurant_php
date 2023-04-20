<?php
    namespace Controller\admin;

    class ComandasController
    {
        public function __construct(private object $dbcon)
        {
            
        }

        public function index(): void           
        {
            include(SITE_ROOT . "/../view/admin/comandas/admin_comandas_view.php");
        }
    }

?>