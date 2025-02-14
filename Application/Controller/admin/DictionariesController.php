<?php

declare(strict_types=1);

namespace Application\Controller\admin;

use Application\Core\Controller;
use Application\model\classes\Query;
use Application\model\classes\Validate;

final class DictionariesController extends Controller
{
    public function __construct(
        private string $message = "",
        private array $fields = [],
        private Validate $validate = new Validate(),
        private Query $query = new Query()
    ) 
    {       
    }

    public function index(): void
    {
        try {
            /** Check for user`s sessions */
            $this->testAccess(['ROLE_ADMIN']);

            $this->render('/view/admin/dictionaries/index.php', [
                'active' => 'administration',
                'fields' => $this->fields
            ]);
            
        } catch (\Throwable $th) {
            $$this->message = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

            if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                $$this->message = "<p class='alert alert-danger text-center'>
                                Message: {$th->getMessage()}<br>
                                Path: {$th->getFile()}<br>
                                Line: {$th->getLine()}
                            </p>";
            }                

            $this->render('/view/database_error.php', [
                'message' => $this->message
            ]);
        }
    }

    public function spanish(): void
    {
        try {
            /** Check for user`s sessions */
            $this->testAccess(['ROLE_ADMIN']);

            $this->fields = [
                'key_word' => $this->validate->test_input($_POST['key']),
                'value'    => $this->validate->test_input($_POST['value'])
            ];

            if(!$this->validate->validate_form($this->fields)) {
                $this->message = $this->validate->get_msg();
                $this->render('/view/admin/dictionaries/index.php', [
                    'active'          => 'administration',
                    'sp_dict_message' => $this->message,
                    'fields'          => [
                        'sp_key'   => $this->fields['key_word'], 
                        'sp_value' => $this->fields['value']
                    ]
                ]);
            }

            $this->query->insertInto('spanish_dict', $this->fields);
            $this->message = "<p class='alert alert-success text-center'>Saved in dictionary successfully!</p>";
            $this->render('/view/admin/dictionaries/index.php', [
                'active'          => 'administration',
                'sp_dict_message' => $this->message,
                'fields'          => []
            ]);


        } catch (\Throwable $th) {
            $$this->message = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

            if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                $$this->message = "<p class='alert alert-danger text-center'>
                                Message: {$th->getMessage()}<br>
                                Path: {$th->getFile()}<br>
                                Line: {$th->getLine()}
                            </p>";
            }                

            $this->render('/view/database_error.php', [
                'message' => $this->message
            ]);
        }
    }

    public function english(): void
    {
        try {
            /** Check for user`s sessions */
            $this->testAccess(['ROLE_ADMIN']);

            $this->fields = [
                'key_word' => $this->validate->test_input($_POST['key'] ?? ""),
                'value'    => $this->validate->test_input($_POST['value'] ?? "")
            ];

            if(!$this->validate->validate_form($this->fields)) {
                $this->message = $this->validate->get_msg();
                $this->render('/view/admin/dictionaries/index.php', [
                    'active'          => 'administration',
                    'en_dict_message' => $this->message,
                    'fields'          => [
                        'en_key'   => $this->fields['key_word'], 
                        'en_value' => $this->fields['value']
                    ]
                ]);
            }

            $this->query->insertInto('english_dict', $this->fields);
            $this->message = "<p class='alert alert-success text-center'>Saved in dictionary successfully!</p>";
            $this->render('/view/admin/dictionaries/index.php', [
                'active'          => 'administration',
                'en_dict_message' => $this->message,
                'fields'          => []
            ]);


        } catch (\Throwable $th) {
            $$this->message = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

            if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                $$this->message = "<p class='alert alert-danger text-center'>
                                Message: {$th->getMessage()}<br>
                                Path: {$th->getFile()}<br>
                                Line: {$th->getLine()}
                            </p>";
            }                

            $this->render('/view/database_error.php', [
                'message' => $this->message
            ]);
        }
    }
}

?>