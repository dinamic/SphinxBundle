HighcoSphinxBundle
==================

This bundle use sphinx php api, you have to include on *dir*/vendor/sphinx/sphinxapi.php your version of sphinxapi which is on package found on http://sphinxsearch.com/downloads/

# Example:

    $client = $this->get('highco.sphinx.client');

    $bridge = $this->get('highco.sphinx.pager.white_october.doctrine_orm');
    $bridget->setEntityManagerName('my_customer_em'); // default is null
    $bridge->setRepositoryClass('HighcoUserBundle:User');
    $bridge->setPkColumn('id');
    $bridge->setSphinxResults($client->Query('Stéphane'));

    $pager = $bridge->getPager();

# Paging example

    $itemsPerPage = 50;
    $page = 1;

    $client = $this->get('highco.sphinx.client');
    $client->SetLimits( ($page -1) * $itemsPerPage, $itemsPerPage);

    $bridge = $this->get('highco.sphinx.pager.white_october.doctrine_orm');
    $bridge->setRepositoryClass('HighcoUserBundle:User');
    $bridge->setPkColumn('id');
    $bridge->setSphinxResults($client->Query('Stéphane'));

    $pager = $bridge->getPager();
    $pager->setMaxPerPage($itemsPerPage);
    $pager->setCurrentPage($page);

# Todo

- Let user can modify client options on config.yml
- Create default pager

- Looking for doctrine FIELD extension, to be able to pass a DoctrineORMAdapter at PagerFanta !
OR
- Overwride the array adapter of pager fanta to set the nb of results !

# Whishlist

- Provide other pager bridge
