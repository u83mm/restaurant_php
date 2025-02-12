<?php
declare(strict_types=1);

namespace Application\Controller\admin;

use Application\Core\Controller;
use Application\model\classes\Query;

final class CategoriesController extends Controller
{
    public function __construct(
        private string $message = "",
        private Query $query = new Query()
    ) 
    {       
    }

    public function index(): void
    {
        try {
            /** Check for user`s sessions */
            $this->testAccess(['ROLE_ADMIN']);

            /** Get all categories */
            $categories = $this->query->selectAll('dishes_menu');

            $this->render('/view/admin/categories/index.php', [
                'categories' => $categories
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

    public function new(): void
    {
        try {
            /** Check for user`s sessions */
            $this->testAccess(['ROLE_ADMIN']);

            $this->render('/view/admin/categories/new_view.php', []);

        } catch (\Throwable $th) {
            $this->message = "<p class='alert alert-danger text-center'>{$th->getMessage()}</p>";

            if(isset($_SESSION['role']) && $_SESSION['role'] === 'ROLE_ADMIN') {
                $this->message = "<p class='alert alert-danger text-center'>
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