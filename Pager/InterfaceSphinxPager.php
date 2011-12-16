<?php

namespace Highco\SphinxBundle\Pager;

interface InterfaceSphinxPager
{
    public function setSphinxResults($results);
    public function getPager();
}
