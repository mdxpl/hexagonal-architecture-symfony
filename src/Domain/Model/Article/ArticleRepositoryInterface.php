<?php

namespace Domain\Model\Article;

use Doctrine\Common\Collections\ArrayCollection;

interface ArticleRepositoryInterface
{

    public function getById(int $id): Article;

    public function create(Article $article): void;

    public function getList(int $limit = 0, int $offset = 0): ArrayCollection;

}