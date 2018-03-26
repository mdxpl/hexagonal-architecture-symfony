<?php

namespace Infrastructure\Repository\Doctrine;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query;
use Domain\Model\Article\ArticleException;
use Domain\Model\Article\ArticleRepositoryInterface;
use Domain\Model\Article\Article;
use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository implements ArticleRepositoryInterface
{

    public function getById(int $id): Article
    {
        $result = $this->createQueryBuilder('q')
            ->where(['id' => $id])
            ->getQuery()
            ->setHydrationMode(Query::HYDRATE_ARRAY)
            ->getOneOrNullResult();

        if (null === $result) {
            throw new ArticleException("Article doesn't exist.");
        }

        return Article::fromArray($result);
    }

    public function create(Article $article): void
    {
        $this->_em->persist($article);
        $this->_em->flush();
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return ArrayCollection|Article[]
     */
    public function getList(int $limit = 0, int $offset = 0): ArrayCollection
    {
        $q = $this->createQueryBuilder('q');

        if ($offset > 0) {
            $q->setFirstResult($offset);
        }

        if ($limit > 0) {
            $q->setMaxResults($limit);
        }

        $result = $q->getQuery()->getResult(Query::HYDRATE_ARRAY);

        $collection = new ArrayCollection();
        foreach ($result as $row) {
            $collection->set($row['id'], Article::fromArray($row));
        }

        return $collection;
    }
}
