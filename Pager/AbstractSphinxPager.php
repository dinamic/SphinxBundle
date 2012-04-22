<?php

namespace Highco\SphinxBundle\Pager;

use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * AbstractSphinxPager
 *
 * @package HighcoSphinBundle
 * @version 0.1
 * @author Stephane PY <py.stephane1@gmail.com>
 */
abstract class AbstractSphinxPager extends ContainerAware
{
    /**
     * _extractPksFromResults
     *
     * @return rray
     */
    protected function _extractPksFromResults()
    {
        $matches = isset($this->results['matches']) ? $this->results['matches'] : array();

        $pks     = array();
        foreach ($matches as $id => $match) {
            $pks[$id] = $id;
        }

        return $pks;
    }
}
