<?php

declare(strict_types=1);

namespace Application\Controller\chat;

use Application\Core\Controller;
use Application\model\classes\ChatIA;

final class ChatController extends Controller
{
    public function __construct(Object $dbcon = DB_CON)
    {}

    public function index(): void
    {                
        $chatIA = new ChatIA();        

        if(!empty($_POST['msg'])) {
            $res = $chatIA->sendMessage($_POST['msg']);
            
            header('Content-Type: application/json');
            echo json_encode($res);
            exit();
        }
    }
}
