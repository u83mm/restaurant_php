<?php
    declare(strict_types = 1);

    namespace Application\model\classes;

    class Dishe
    {
        private ?int    $dishe_id    = null;
        private ?string $name        = null;
        private ?string $description = null;
        private ?float  $price       = null;
        private ?string $picture     = null;
        private ?int    $category_id = null;
        private ?int    $menu_id     = null;
        private ?string $available   = null;
        
        public function __construct(
            private array $fields = []
        )
        {
            $this->setDishe($this->fields);  
        }

        public function setDishe(array $fields): self
        {            
            foreach ($fields as $key => $value) {
                $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));                

                if (method_exists($this, $method)) {
                    $this->$method($value);
                }
            }

            return $this;
        }

        public function setDisheId(int $dishe_id): self
        {
            $this->dishe_id = $dishe_id;
            return $this;
        }

        public function getDisheId(): int
        {
            return $this->dishe_id;
        }

        public function setName(string $name): self
        {
            $this->name = $name;
            return $this;
        }

        public function getName(): string
        {
            return $this->name;
        }

        public function setDescription(string $description): self
        {
            $this->description = $description;
            return $this;
        }

        public function getDescription(): string
        {
            return $this->description;
        }

        public function setPrice(string $price): self
        {
            $this->price = floatval($price);
            return $this;
        }

        public function getPrice(): float
        {
            return $this->price;
        }

        public function setPicture(string $picture): self
        {
            $this->picture = $picture;
            return $this;
        }

        public function getPicture(): string
        {
            return $this->picture;
        }

        public function setCategoryId(int $category_id): self
        {
            $this->category_id = $category_id;
            return $this;
        }

        public function getCategoryId(): int
        {
            return $this->category_id;
        }

        public function setMenuId(int $menu_id): self
        {
            $this->menu_id = $menu_id;
            return $this;
        }

        public function getMenuId(): int
        {
            return $this->menu_id;
        }

        public function setAvailable(string $available): self
        {
            $this->available = $available;
            return $this;
        }

        public function getAvailable(): string
        {
            return $this->available;
        }

        public function getFields(): array
        {
            return $this->fields;
        }
    }
?>