<?php
    namespace model\classes;

    class User
    {
        public function __construct(
            private int $id_user = 0,
            private string $user_name = "",
            private string $password = "",
            private string $email = "",
            private int $id_role = 0,
        )
        {
           
        }

        public function setId(int $id): void
        {
            $this->id_user = $id;
        }

        public function getId(): int
        {
            return $this->id_user;
        }

        public function setName(string $name): void
        {
            $this->user_name = $name;
        }

        public function getName(): string
        {
            return $this->user_name;
        }

        public function setPassword(string $password): void
        {
            // Configura un password
        }

        public function setEmail(string $email): void
        {
            $this->email = $email;
        }

        public function getEmail(): string
        {
            return $this->email;
        }

        public function setRole(int $role): void
        {
            $this->id_role = $role;
        }

        public function getRole()
        {
            return $this->id_role;
        }
    }    
?>