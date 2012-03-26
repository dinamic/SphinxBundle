<?php

namespace Highco\SphinxBundle\Pager\Bridge;

use Highco\SphinxBundle\Pager\Bridge\PagerFantaAdapter\SphinxAdapter;
use Pagerfanta\Pagerfanta;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;

use Highco\SphinxBundle\Pager\InterfaceSphinxPager;
use Highco\SphinxBundle\Pager\AbstractSphinxPager;

/**
 * WhiteOctoberDoctrineORMBridge
 *
 * @uses AbstractSphinxPager
 * @uses InterfaceSphinxPager
 * @author Stephane PY <py.stephane1(at)gmail.com>
 * @author Nikola Petkanski <nikola@petkanski.com>
 */
class WhiteOctoberDoctrineORMBridge extends AbstractSphinxPager implements InterfaceSphinxPager
{
    /**
     * @var EntityManager|null
     */
    protected $em;

    /**
     * @var string
     */
    protected $repository_class;

    /**
     * @var string
     */
    protected $pk_column = "id";

    /**
     * @var QueryBuilder
     */
    protected $query = null;

    /**
     * The results obtained from sphinx
     *
     * @var array
     */
    protected $results;

    /**
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        if ($this->em === null) {
            $this->em = $this->container->get('doctrine')->getEntityManager();
        }

        return $this->em;
    }

    /**
     * Sets the name of the entity manager which should be used to transform Sphinx results to entities.
     *
     * @param string $name
     *
     * @return WhiteOctoberDoctrineORMBridge
     *
     * @throws \LogicException
     */
    public function setEntityManagerByName($name)
    {
        if ($this->em !== null) {
            throw new \LogicException('Entity manager can only be set before any results are fetched');
        }

        $this->em = $this->container->get('doctrine')->getEntityManager($name);

        return $this;
    }

    /**
     * Sets the exact instance of entity manager which should be used to transform Sphinx results to entities.
     *
     * @param EntityManager $name
     *
     * @return WhiteOctoberDoctrineORMBridge
     */
    public function setEntityManager(EntityManager $em)
    {
        if ($this->em !== null) {
            throw new \LogicException('Entity manager can only be set before any results are fetched');
        }

        $this->em = $em;

        return $this;
    }

    /**
     * setRepositoryClass
     *
     * @param mixed $repositoryClass
     *
     * @return WhiteOctoberDoctrineORMBridge
     */
    public function setRepositoryClass($repositoryClass)
    {
        $this->repository_class = $repositoryClass;

        return $this;
    }

    /**
     * setPkColumn
     *
     * @param mixed $pkColumn
     *
     * @return WhiteOctoberDoctrineORMBridge
     */
    public function setPkColumn($pkColumn)
    {
        $this->pk_column = $pkColumn;

        return $this;
    }

    /**
     * setSphinxResults
     *
     * @param mixed $results
     *
     * @return WhiteOctoberDoctrineORMBridge
     */
    public function setSphinxResults($results)
    {
        $this->results = $results;

        return $this;
    }

    /**
     * Returns an instance of the pager
     *
     * @return Pagerfanta
     */
    public function getPager()
    {
        if (is_null($this->repository_class)) {
            throw new \RuntimeException('You should define a repository class on '.__CLASS__);
        }

        if (is_null($this->results)) {
            throw new \RuntimeException('You should define sphinx results on '.__CLASS__);
        }

        $pks = $this->_extractPksFromResults();

        $results = array();

        if (false === empty($pks)) {
            $qb = $this->getQuery();

            $qb = $qb->where($qb->expr()->in('r.'.$this->pk_column, $pks))
                //->addOrderBy('FIELD(r.id,...)', 'ASC')
                ->getQuery()
                ;
            //@todo watching on doctrine FIELD extension ... we cannot use it natively . . . .

            $unordoredResults = $qb->getResult();

            foreach ($pks as $pk) {
                if (isset($unordoredResults[$pk])) {
                    $results[$pk] = $unordoredResults[$pk];
                }
            }
        }

        $adapter = $this->container->get('highco.sphinx.pager.white_october.doctrine_orm.adapter');
        $adapter->setArray($results);

        $adapter->setNbResults(isset($this->results['total_found']) ? $this->results['total_found'] : 0);

        return new Pagerfanta($adapter);
    }

    /**
     * @return QueryBuilder query
     */
    public function getDefaultQuery()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        /* @var $qb \Doctrine\DBAL\Query\QueryBuilder */

        return $qb->select('r') ->from($this->repository_class, sprintf('r INDEX BY r.%s', $this->pk_column));

    }

    /**
     * @param QueryBuilder $query
     */
    public function setQuery($query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * setDefaultQuery
     *
     * @return QueryBuilder
     */
    public function getQuery()
    {
        if ($this->query == null) {
            return $this->getDefaultQuery();
        }

        return $this->query;
    }
}
