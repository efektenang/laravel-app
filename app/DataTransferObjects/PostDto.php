<?php

namespace App\DataTransferObjects;

class PostDto {
    public function __construct(
        public readonly string $title,
        public readonly string $news_content,
        public readonly int $author
    )
    {
        
    }

}