<?php
    declare(strict_types=1);
    
    namespace Application\model\repositories;

    use Application\model\classes\Query;
    use Application\model\classes\User;

    class UserRepository extends Query
    {
        public function save(User $user): void
        {
            $this->insertInto('user', [
                'user_name' => $user->getName(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
                'id_role' => $user->getRole() ?? 2
            ]);
        }
    }
?>