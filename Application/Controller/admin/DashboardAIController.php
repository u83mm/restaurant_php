<?php
declare(strict_types=1);

namespace Application\Controller\admin;

use Application\Core\Controller;
use Application\model\classes\Language;
use Application\model\classes\QueryLogsAIDashboard;
use Application\model\classes\Validate;
use DateTimeImmutable;

final class DashboardAIController extends Controller
{
    /** Create array and object for diferent languages */
    private array $language = [];
    private Language $languageObject;

    public function __construct(            
        private string $message = "",
        private array $fields = [],
        private QueryLogsAIDashboard $query = new QueryLogsAIDashboard(),
        private Validate $validate = new Validate()            
    )
    {                        
        /** Configure page language */
        $this->languageObject = new Language(); 
        $this->language = $_SESSION['language'] == "spanish" ? $this->languageObject->spanish() : $this->languageObject->english(); 
    }

    public function showAiDashboard(): void
    {
        try {
            /** Check for user`s sessions */
            $this->testAccess(['ROLE_ADMIN']);

            if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['intent_id'])) {
                $intent_id = $_POST['intent_id'];

                if(!empty($_POST['new_pattern'])) {
                    $this->query->insertInto('patterns_ia', [
                        'intent_id' => $intent_id,
                        'pattern_text' => $_POST['new_pattern']                               
                    ]);
                }

                if(!empty($_POST['new_response'])) {
                    $this->query->insertInto('responses_ia', [
                    'intent_id' => $intent_id,
                    'response_text' => $_POST['new_response']
                    ]);
                }
            }                                    
            
            // Formating AI dashboard logs date to show in format (d-m-Y h:m:s) in the view
            $logs = $this->query->selectFieldsFromTableOrderByField( // We get AI dashboard logs from DB
                        table: 'chat_logs', 
                        orderByField: 'created_at', 
                        limit: 20
                    );
                    
            foreach ($logs as $key => $value) {
                $date = new DateTimeImmutable($logs[$key]['created_at']);
                $logs[$key]['created_at'] = $date->format('d-m-Y H:i:s');
            }
            
            $this->render("/view/admin/ai_dashboard/main_view.php", [
                'message'   =>  $this->message,
                'intents'   =>  $this->query->selectAllOrderByField('intents_ia', 'id'),
                'patterns'  =>  $this->query->selectAllOrderByField('patterns_ia', 'id'),
                'responses' =>  $this->query->selectAllOrderByField('responses_ia', 'id'),
                'logs'      =>  $logs,
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

            $this->render("/view/database_error.php", [
                'message' => $this->message
            ]);	
        }
    }

    /** Clear all the logs */
    public function clearAllLogs(): void
    {
        /** Check for user`s sessions */
        $this->testAccess(['ROLE_ADMIN']);

        $this->query->truncateTable('chat_logs');
        header("Location: /admin/dashboardAI/showAiDashboard");
    }

    /** Clear logs beyond 30 days */
    public function clearLogs(): void
    {
        /** Check for user`s sessions */
        $this->testAccess(['ROLE_ADMIN']);

        $this->query->deleteRegistries('chat_logs');
        header("Location: /admin/dashboardAI/showAiDashboard");        
    }
}
