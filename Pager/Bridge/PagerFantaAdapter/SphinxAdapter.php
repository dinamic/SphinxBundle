<?php

namespace Highco\SphinxBundle\Pager\Bridge\PagerFantaAdapter;

use Pagerfanta\Adapter\AdapterInterface;

class SphinxAdapter implements AdapterInterface
{
    private $array;
    private $nb_results = 0;

    /**
     * Constructor.
     *
     * @param array $array The array.
     *
     * @api
     */
    public function __construct(array $array)
    {
        $this->array = $array;
    }

    /**
     * Returns the array.
     *
     * @return array The array.
     *
     * @api
     */
    public function getArray()
    {
        return $this->array;
    }

    /**
     * {@inheritdoc}
     */
    public function getNbResults()
    {
        return $this->nb_results;
    }

    /**
     * setNbResults
     *
     * @param mixed $v
     * @return void
     */
    public function setNbResults($v)
    {
        $this->nb_results = $v;
    }

    /**
     * {@inheritdoc}
     */
    public function getSlice($offset, $length)
    {
        return array_slice($this->array, $offset, $length);
    }

}
