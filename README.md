HighcoSphinxBundle
==================

This bundle use sphinx php api, you have to include on *dir*/vendor/sphinx/sphinxapi.php your version of sphinxapi which is on package found on http://sphinxsearch.com/downloads/

# Exemple:

    $client = $this->get('highco.sphinx.client');

    $bridge = $this->get('highco.sphinx.pager.white_october.doctrine_orm');
    $bridge->setRepositoryClass('HighcoUserBundle:User');
    $bridge->setPkColumn('id');
    $bridge->setSphinxResults($client->Query('Stéphane'));

    $pager = $bridge->getPager();


# Todo

- Let user can modify client options on config.yml
- Create default pager

- Looking for doctrine FIELD extension, to be able to pass a DoctrineORMAdapter at PagerFanta !
OR
- Overwride the array adapter of pager fanta to set the nb of results !

# Whishlist

- Provide other pager bridge
