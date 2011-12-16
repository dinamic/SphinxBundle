<?php

namespace Highco\SphinxBundle\Pager\Bridge;

use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Doctrine\ORM\EntityManager;

/**
 * WhiteOctoberDoctrineORMBridge
 *
 * @package
 * @version $id$
 * @author Stephane PY <py.stephane1(at)gmail.com>
 */
class WhiteOctoberDoctrineORMBridge
{
    protected $em;
    protected $repository_class;
    protected $pk_column = "id";
    protected $results;

    /**
     * __construct
     *
     * @param mixed $em
     * @return void
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * setRepositoryClass
     *
     * @param mixed $repositoryClass
     * @return void
     */
    public function setRepositoryClass($repositoryClass)
    {
        $this->repository_class = $repositoryClass;
    }

    /**
     * setPkColumn
     *
     * @param mixed $pkColumn
     * @return void
     */
    public function setPkColumn($pkColumn)
    {
        $this->pk_column = $pkColumn;
    }

    /**
     * setSphinxResults
     *
     * @param mixed $results
     * @return void
     */
    public function setSphinxResults($results)
    {
        $this->results = $results;
    }

    /**
     * getPager
     *
     * @return void
     */
    public function getPager()
    {
        if(is_null($this->repository_class))
        {
            throw new \RuntimeException('You should define a repository class on '.__CLASS__);
        }

        if(is_null($this->results))
        {
            throw new \RuntimeException('You should define sphinx results on '.__CLASS__);
        }

        $pks = $this->__extractPksFromResults();

        if(empty($pks))
        {
            return array();
        }

        $qb = $this->em
            ->createQueryBuilder()
            ->select('r')
            ->from($this->repository_class, sprintf('r INDEX BY r.%s', $this->pk_column));

        $qb = $qb->where($qb->expr()->in('r.'.$this->pk_column, $pks))
            ->getQuery()
            ;
        //@todo watching on doctrine FIELD extension ... we cannot use it natively . . . .

        $results = $qb->getResult();

        $orderedResults = array();
        foreach($pks as $pk)
        {
            if(isset($results[$pk]))
            {
                $orderedResults[$pk] = $results[$pk];
            }
        }

        return new Pagerfanta(new ArrayAdapter($orderedResults));
    }

    /**
     * __extractPksFromResults
     *
     * @return rray
     */
    private function __extractPksFromResults()
    {
        $matches = isset($this->results['matches']) ? $this->results['matches'] : array();

        $pks     = array();
        foreach($matches as $id => $match)
        {
            $pks[$id] = $id;
        }

        return $pks;
    }
}
