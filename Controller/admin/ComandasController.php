<?php
    namespace Controller\admin;

use model\classes\Query;

    class ComandasController
    {
        public function __construct(private object $dbcon)
        {
            
        }

        public function index(): void           
        {
            $query = new Query();

            $result = $query->selectAll('orders', $this->dbcon);

            var_dump($result[0]['aperitifs']);die;


            include(SITE_ROOT . "/../view/admin/comandas/admin_comandas_view.php");
        }
    }

?>