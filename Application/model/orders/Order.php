<?php
    namespace Application\model\orders;

    class Order
    {
        public function __construct(
            // Define the properties of the Order class with their types and default values
            // Order header
            private int $id = 0,
            private int $table = 0,
            private int $people = 0,

            // Order items
            // Aperitif
            private array $aperitif_id       = [],
            private array $aperitif          = [],
            private array $aperitif_qty      = [],
            private array $aperitif_finished = [],
            // Firsts
            private array $first_id          = [],
            private array $first             = [],
            private array $first_qty         = [],
            private array $first_finished    = [],
            // Seconds
            private array $second_id         = [],
            private array $second            = [],
            private array $second_qty        = [],
            private array $second_finished   = [],
            // Desserts
            private array $dessert_id        = [],
            private array $dessert           = [],
            private array $dessert_qty       = [],
            private array $dessert_finished  = [],
            // Drinks
            private array $drink_id          = [],
            private array $drink             = [],
            private array $drink_qty         = [],
            private array $drink_finished    = [],
            // Coffees and liquors
            private array $coffee_id         = [],
            private array $coffee            = [],
            private array $coffee_qty        = [],
            private array $coffee_finished   = [],
        )
        {
            
        } 
        
        public function __toString()
        {
            return $this->getAperitif();
        }

        public function setId(int $id): self
        {
            $this->id = $id;
            return $this;            
        }

        public function getId(): int
        {
            return $this->id;
        }

        public function setTable(int $table): self
        {
            $this->table = $table;
            return $this;
        }

        public function getTable(): int
        {
            return $this->table;
        }

        public function setPeople(int $people): self
        {
            $this->people = $people;
            return $this;
        }

        public function getPeople(): int
        {
            return $this->people;
        }

        public function setAperitifId(array $aperitif_id): self
        {
            $this->aperitif_id = $aperitif_id;
            return $this;
        }

        public function getAperitifId(): array
        {
            return $this->aperitif_id;
        }

        public function setAperitif(array $aperitif): self
        {
            $this->aperitif = $aperitif;
            return $this;
        }

        public function getAperitif(): array
        {
            return $this->aperitif;
        }

        public function setAperitifQty(array $aperitif_qty): self
        {
            $this->aperitif_qty = $aperitif_qty;
            return $this;
        }

        public function getAperitifQty(): array
        {
            return $this->aperitif_qty;
        }

        public function setAperitifFinished(array $aperitif_finished): self
        {
            $this->aperitif_finished = $aperitif_finished;
            return $this;
        }

        public function getAperitifFinished(): array
        {
            return $this->aperitif_finished;
        }

        public function setFirstId(array $first_id): self
        {
            $this->first_id = $first_id;
            return $this;
        }

        public function getFirstId(): array
        {
            return $this->first_id;
        }

        public function setFirst(array $first): self
        {
            $this->first = $first;
            return $this;
        }

        public function getFirst(): array
        {
            return $this->first;
        }

        public function setFirstQty(array $first_qty): self
        {
            $this->first_qty = $first_qty;
            return $this;
        }

        public function getFirstQty(): array
        {
            return $this->first_qty;
        }

        public function setFirstFinished(array $first_finished): self
        {
            $this->first_finished = $first_finished;
            return $this;
        }

        public function getFirstFinished(): array
        {
            return $this->first_finished;
        }

        public function setSecondId(array $second_id): self
        {
            $this->second_id = $second_id;
            return $this;
        }

        public function getSecondId(): array
        {
            return $this->second_id;
        }

        public function setSecond(array $second): self
        {
            $this->second = $second;
            return $this;
        }

        public function getSecond(): array
        {
            return $this->second;
        }

        public function setSecondQty(array $second_qty): self
        {
            $this->second_qty = $second_qty;
            return $this;
        }

        public function setSecondFinished(array $second_finished): self
        {
            $this->second_finished = $second_finished;
            return $this;
        }

        public function getSecondFinished(): array
        {
            return $this->second_finished;
        }

        public function getSecondQty(): array
        {
            return $this->second_qty;
        }

        public function setDessertId(array $dessert_id): self
        {
            $this->dessert_id = $dessert_id;
            return $this;
        }

        public function getDessertId(): array
        {
            return $this->dessert_id;
        }

        public function setDessert(array $dessert): self
        {
            $this->dessert = $dessert;
            return $this;
        }

        public function getDessert(): array
        {
            return $this->dessert;
        }

        public function setDessertQty(array $dessert_qty): self
        {
            $this->dessert_qty = $dessert_qty;
            return $this;
        }

        public function getDessertQty(): array
        {
            return $this->dessert_qty;
        }

        public function setDessertFinished(array $dessert_finished): self
        {
            $this->dessert_finished = $dessert_finished;
            return $this;
        }

        public function getDessertFinished(): array
        {
            return $this->dessert_finished;
        }

        public function setDrinkId(array $drink_id): self
        {
            $this->drink_id = $drink_id;
            return $this;
        }

        public function getDrinkId(): array
        {
            return $this->drink_id;
        }

        public function setDrink(array $drink): self
        {
            $this->drink = $drink;
            return $this;
        }

        public function getDrink(): array
        {
            return $this->drink;
        }

        public function setDrinkQty(array $drink_qty): self
        {
            $this->drink_qty = $drink_qty;
            return $this;
        }

        public function getDrinkQty(): array
        {
            return $this->drink_qty;
        }

        public function setDrinkFinished(array $drink_finished): self
        {
            $this->drink_finished = $drink_finished;
            return $this;
        }

        public function getDrinkFinished(): array
        {
            return $this->drink_finished;
        }

        public function setCoffeeId(array $coffee_id): self
        {
            $this->coffee_id = $coffee_id;
            return $this;
        }

        public function getCoffeeId(): array
        {
            return $this->coffee_id;
        }

        public function setCoffee(array $coffee): self
        {
            $this->coffee = $coffee;
            return $this;
        }

        public function getCoffee(): array
        {
            return $this->coffee;
        }

        public function setCoffeeQty(array $coffee_qty): self
        {
            $this->coffee_qty = $coffee_qty;
            return $this;
        }

        public function getCoffeeQty(): array
        {
            return $this->coffee_qty;
        }

        public function setCoffeeFinished(array $coffee_finished): self
        {
            $this->coffee_finished = $coffee_finished;
            return $this;
        }

        public function getCoffeeFinished(): array
        {
            return $this->coffee_finished;
        }
    }
    
?>