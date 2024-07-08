<?php

namespace App\DataTransferObjects;

class PostDTO
{
    public string $title;
    public string $news_content;
    public int $author;

    public function __construct(array $data)
    {
        $this->title = $data['title'];
        $this->news_content = $data['news_content'];
        $this->author = $data['author'];
    }

    // Optional static method for easier instantiation
    public static function fromArray(array $data): self
    {
        return new self($data);
    }
}
