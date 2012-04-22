<?php

namespace Highco\SphinxBundle\Pager;

/**
 * SphinxPager
 *
 * @author Stephane PY <py.stephane1@gmail.com>
 */
interface InterfaceSphinxPager
{
    /**
     * setSphinxResults
     *
     * @param array $results
     *
     * @return void
     */
    public function setSphinxResults($results);

    /**
     * getPager
     *
     * @return InterfaceSphinxPager
     */
    public function getPager();
}
