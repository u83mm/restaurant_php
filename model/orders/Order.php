<?php
    namespace model\orders;

    class Order
    {
        public function __construct(
            private int $table = 0,
            private int $people = 0,
            private array $aperitif = [],
            private array $aperitif_qty = [],
            private array $first = [],
            private array $first_qty = [],
            private array $second = [],
            private array $second_qty = [],
            private array $dessert = [],
            private array $dessert_qty = [],
            private array $drink = [],
            private array $drink_qty = [],
            private array $coffee = [],
            private array $coffee_qty = [],
        )
        {
            
        } 
        
        public function __toString()
        {
            return $this->getAperitif();
        }

        public function setTable(int $table): void
        {
            $this->table = $table;
        }

        public function getTable(): int
        {
            return $this->table;
        }

        public function setPeople(int $people): void
        {
            $this->people = $people;
        }

        public function getPeople(): int
        {
            return $this->people;
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

        public function setSecond(array $second): void
        {
            $this->second = $second;
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

        public function getSecondQty(): array
        {
            return $this->second_qty;

        }

        public function setDessert(array $dessert): void
        {
            $this->dessert = $dessert;
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

        public function setDrink(array $drink): void
        {
            $this->drink = $drink;
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

        public function setCoffee(array $coffee): void
        {
            $this->coffee = $coffee;
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
    }
    
?>