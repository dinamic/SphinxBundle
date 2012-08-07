HighcoSphinxBundle
==================

This bundle use sphinx php api, you have to include on *dir*/vendor/sphinx/sphinxapi.php your version of sphinxapi which is on package found on http://sphinxsearch.com/downloads/

# Simple example:

````php
<?php
$client = $this->get('highco.sphinx.client');

$bridge = $this->get('highco.sphinx.pager.white_october.doctrine_orm');
// $bridge->setEntityManagerByName('my_custom_em');
// $bridge->setEntityManager($em);
$bridge->setRepositoryClass('HighcoUserBundle:User');
$bridge->setPkColumn('id');
$bridge->setSphinxResults($client->Query('Stéphane'));

$pager = $bridge->getPager();
`````


# Paging example

````php
<?php
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
`````

# Paging example with multiple queries

````php
<?php
$itemsPerPage = 50;
$page = 1;

$client = $this->get('highco.sphinx.client');
$client->SetLimits( ($page -1) * $itemsPerPage, $itemsPerPage);

$bridge = $this->get('highco.sphinx.pager.white_october.doctrine_orm');
$bridge->setRepositoryClass('HighcoUserBundle:User');
$bridge->setPkColumn('id');

$client->AddQuery('Stéphane', 'address_book');
$client->AddQuery('Nikola', 'address_book');
$bridge->setSphinxResults($client->RunQueries(), true);

$pager = $bridge->getPager();
$pager->setMaxPerPage($itemsPerPage);
$pager->setCurrentPage($page);
`````

# Paging example /w discriminator attribute

$itemsPerPage = 50;
$page = 1;

$client = $this->get('highco.sphinx.client');
$client->SetLimits( ($page -1) * $itemsPerPage, $itemsPerPage);

$bridge = $this->get('highco.sphinx.pager.white_october.doctrine_orm');

/**
 * Make sure you have this column defined as attribute in Sphinx (i.e: sql_attr_string = type).
 * Sphinx prior version 1.10 does not have support for sql_attr_string, but you can use sql_attr_uint
 * and have your discriminators defined as constants in PHP.
 */
$bridge->setDiscriminatorColumn('type');

$bridge->setDiscriminatorRepositories(array(
    'article'       => array(
        'class' => 'BlogBundle:Article',
        'em'    => 'default',
    ),
    'category'      => array(
        'class' => 'BlogBundle:Category',
        'em'    => 'default',
    ),
    'note'         => array(
        'class' => 'NotesBundle:Message',
        'em'    => 'notes'
    ),
));

$bridge->setPkColumn('id');
$bridge->setSphinxResults($client->Query('Stéphane'));

$pager = $bridge->getPager();
$pager->setMaxPerPage($itemsPerPage);
$pager->setCurrentPage($page);
````

# Todo

- Watch for coding conventions, I....should be ....Interface, line should be wrapped, etc...
- Let user can modify client options on config.yml
- Create default pager

- Looking for doctrine FIELD extension, to be able to pass a DoctrineORMAdapter at PagerFanta !

# Whishlist

- Provide other pager bridge
