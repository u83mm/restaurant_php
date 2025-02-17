<?php
    namespace Application\model\classes;

    class User
    {
            private ?int    $id_user    = null;
            private ?string $user_name  = null;
            private ?string $password   = null;
            private ?string $email      = null;
            private ?int    $id_role    = null;

        public function __construct(
            private array $fields = [],
        )
        {
            $this->setUser($fields);           
        }

        public function setUser(array $fields): self
        {
            if(!empty($fields)) {
                foreach($fields as $key => $value) {
                    $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
                    
                    if(method_exists($this, $method)) {
                        $this->$method($value);
                    }
                }
            }

            return $this;
        }

        public function setId(int $id): self
        {
            $this->id_user = $id;
            return $this;
        }

        public function getId(): int
        {
            return $this->id_user;
        }

        public function setName(string $name): self
        {
            $this->user_name = $name;
            return $this;
        }

        public function getName(): string
        {
            return $this->user_name;
        }

        public function setPassword(string $password): self
        {
            $this->password = $password;
            return $this;
        }

        public function getPassword(): string
        {
            return $this->password;
        }

        public function setEmail(string $email): self
        {
            $this->email = $email;
            return $this;
        }

        public function getEmail(): string
        {
            return $this->email;
        }

        public function setRole(int $role): self
        {
            $this->id_role = $role;
            return $this;
        }

        public function getRole()
        {
            return $this->id_role;
        }
    }    
?>