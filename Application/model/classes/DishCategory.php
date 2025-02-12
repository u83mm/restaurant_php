<?php

declare(strict_types=1);

namespace Application\model\classes;

class DishCategory
{
    private string $category = "";
    private string $emoji = "";

    public function __construct(
        private array $fields = []
    )
    {
        $this->setEntity($this->fields);  
    }

    private function setEntity(array $fields): self
    {            
        foreach ($fields as $key => $value) {
            $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));                

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }

        return $this;
    }

    // Set a category
    public function setCategory(string $category): self
    {
        $this->category = $category;
        return $this;
    }

    // Get a category
    public function getCategory(): string
    {
        return $this->category;
    }

    // Set an emoji
    public function setEmoji(string $emoji): self
    {
        $this->emoji = $emoji;
        return $this;
    }

    // Get an emoji
    public function getEmoji(): string
    {
        return $this->emoji;
    }

    public function getFields(): array
    {
        return $this->fields;
    }
}
