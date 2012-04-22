<?php

namespace Highco\SphinxBundle\Pager\Bridge\PagerFantaAdapter;

use Pagerfanta\Adapter\AdapterInterface;

/**
 * SphinxAdapter
 *
 * @uses AdapterInterface
 * @author Stephane PY <py.stephane1@gmail.com>
 */
class SphinxAdapter implements AdapterInterface
{
    /**
     * @var array
     */
    protected $array = array();

    /**
     * @var integer
     */
    protected $nbResults = 0;

    /**
     * Constructor.
     *
     * @param array $array The array.
     *
     * @api
     */
    public function __construct(array $array = null)
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
     * @param array $array
     *
     * @return void
     */
    public function setArray(array $array)
    {
        $this->array = $array;
    }

    /**
     * {@inheritdoc}
     */
    public function getNbResults()
    {
        return $this->nbResults;
    }

    /**
     * setNbResults
     *
     * @param integer $v nbOfResults
     * @return void
     */
    public function setNbResults($v)
    {
        $this->nbResults = $v;
    }

    /**
     * {@inheritdoc}
     */
    public function getSlice($offset, $length)
    {
        if ($offset >= count($this->array)) {
            return $this->array;
        }

        return array_slice($this->array, $offset, $length);
    }

}
