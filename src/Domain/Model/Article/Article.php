<?php

namespace Domain\Model\Article;

class Article
{

    private $id;
    private $isPublished;
    private $title;
    private $content;

    public function __construct(string $id, bool $isPublished, string $title, string $content)
    {
        $this->id = $id;
        $this->isPublished = $isPublished;
        $this->title = $title;
        $this->content = $content;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function isPublished(): boolean
    {
        return $this->isPublished;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['isPublished'],
            $data['title'],
            $data['content']
        );
    }

}