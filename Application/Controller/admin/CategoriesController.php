<?php
declare(strict_types=1);

namespace Application\Controller\admin;

use Application\Core\Controller;
use Application\model\classes\DishCategory;
use Application\model\classes\Language;
use Application\model\classes\Query;
use Application\model\classes\Validate;
use Application\model\repositories\dishe\CategoryRepository;

final class CategoriesController extends Controller
{
    /** Create array and object for diferent languages */    
    private Language $languageObject;

    public function __construct(
        private string $message = "",
        private array $fields = [],
        private array $language = [],
        private Query $query = new Query(),
        private Validate $validate = new Validate(),
        private CategoryRepository $categoryRepository = new CategoryRepository()
    ) 
    {
        /** Configure page language */
        $this->languageObject = new Language(); 
        $this->language = $_SESSION['language'] == "spanish" ? $this->languageObject->spanish() : $this->languageObject->english();       
    }

    public function index(): void
    {
        try {
            /** Check for user`s sessions */
            $this->testAccess(['ROLE_ADMIN']);

            /** Get all categories */
            $categories = $this->query->selectAllOrderByField('dishes_menu', "{$_SESSION['language']}_menu_category");

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

            if($_SERVER['REQUEST_METHOD'] === 'POST') {                
                if(isset($_POST['category'])) {
                    $this->fields = [
                        'category' => $_POST['category'] ?? "",
                        'emoji'    => $_POST['emoji'] ?? ""
                    ];
    
                    if(!$this->validate->validate_form($this->fields)) {                    
                        $_SESSION['message'] = "<p class='alert alert-danger text-center'>" . $this->validate->get_msg() . "</p>";
    
                        $this->render('/view/admin/categories/new_view.php', [
                            'fields' => $this->fields
                        ]);
    
                    }
                    else {
                        // Test if category already exists
                        if($this->query->selectOneBy('dishes_menu', "{$_SESSION['language']}_menu_category", $this->fields['category'])) {
                            $_SESSION['message'] = "<p class='alert alert-danger text-center'>Category already exists!</p>";
    
                            $this->render('/view/admin/categories/new_view.php', [
                                'fields' => $this->fields
                            ]);                        
                        }
    
                        // Save category
                        $this->categoryRepository->saveCategory(new DishCategory($this->fields));
                        $_SESSION['message'] = "<p class='alert alert-success text-center'>" . ucfirst($this->fields["category"]) .  " category was successfully added!</p>";
                    }                            
    
                    header('Location: /admin/categories/index');
                    die();
                }
            }

            $this->render('/view/admin/categories/new_view.php', [
                'fields' => ['category' => '', 'emoji' => '']
            ]);

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

    public function edit(): void
    {
        try {
            /** Check for user`s sessions */
            $this->testAccess(['ROLE_ADMIN']);

            global $id;
            $category = $this->categoryRepository->selectOneBy('dishes_menu', 'menu_id', $id);

            $this->fields = [
                'category' => $category->getCategory(),
                'emoji'    => $category->getEmoji()
            ];

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                if(isset($_POST['language'])) {
                    $this->render('/view/admin/categories/edit_view.php', [
                        'fields' => $this->fields,
                    ]);
                }

                if(!isset($_POST['category']) || !isset($_POST['emoji'])) {
                    $this->fields = [
                        'category' => $category->getCategory(),
                        'emoji'    => $category->getEmoji()
                    ];                 
                }
                else {
                     // The keys must labeled as the same as in the database table
                    $this->fields = [
                        'menu_id'                               => $id,
                        "{$_SESSION['language']}_menu_category" => $_POST['category'] ?? $this->fields['category'],
                        'menu_emoji'                            => $_POST['emoji'] ?? $this->fields['emoji']
                    ];
                }

                /** Validate form */
                if(!$this->validate->validate_form($this->fields)) {
                    $_SESSION['message'] = $this->validate->get_msg();

                    $this->render('/view/admin/categories/edit_view.php', [
                        'fields' => $this->fields
                    ]);
                }
                else {                    
                    // Update category
                    $this->categoryRepository->updateRegistry('dishes_menu', $this->fields, 'menu_id');

                    $_SESSION['message'] = "<p class='alert alert-success text-center'>" . ucfirst($this->fields["{$_SESSION['language']}_menu_category"]) .  " category was successfully updated!</p>";
                }

                header('Location: /admin/categories/index');
                die();
            }
            
            $this->render('/view/admin/categories/edit_view.php', [
                'fields'    => $this->fields,
            ]);

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

    public function delete(): void
    {
        try {
            /** Check for user`s sessions */
            $this->testAccess(['ROLE_ADMIN']);

            $id = $this->validate->test_input($_POST['id']);

            if($id) {
                $this->categoryRepository->deleteRegistry('dishes_menu', 'menu_id', $id);
                $_SESSION['message'] = "<p class='alert alert-success text-center'>Category was successfully deleted!</p>";
            }

            header('Location: /admin/categories/index');

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

    public function search(): void
    {
        /** Check for user`s sessions */
        $this->testAccess(['ROLE_ADMIN']);

        try {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                if(isset($_POST['category'])) {
                    $this->fields = [
                        'category' => $this->validate->test_input($_POST['category']),
                    ];
                       
                    /** Validate form */
                    if(!$this->validate->validate_csrf_token()) {
                        $_SESSION['message'] = "<p class='alert alert-warning text-center'>" . ucfirst($this->language['invalid_token']) . "</p>";                        
                    }
                    else if(!$this->validate->validate_form($this->fields)) {
                        $this->message = "<p class='alert alert-warning text-center'>{$this->validate->get_msg()}</p>";
                        $this->render('/view/admin/categories/search_view.php', [
                            'active'       => 'administration',
                            'form_message' => $this->message
                        ]);
                    }
                    else {                                                
                        $result = $this->query->selectAllFromTableWhereFieldLike('dishes_menu', "{$_SESSION['language']}_menu_category", $this->fields['category']);

                        if($result) {                                                        
                            $this->render('/view/admin/categories/index.php', [
                                'categories' => $result
                            ]);
                        }
                        else {
                            $_SESSION['message'] = "<p class='alert alert-warning text-center'>" . ucfirst($this->language['rows_not_found']) . "</p>";                            
                        }
                    }
                }
            }            

            $this->render('/view/admin/categories/search_view.php', [
                'active' => 'administration',
            ]);

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