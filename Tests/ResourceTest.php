<?php

use Hal\Resource;
use Hal\Link;

class ResourceTest extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $resource = new Resource(new Link('/test', 'self'));

        $this->assertEquals(array('_links' => array('self' => array('href' => '/test'))), $resource->asArray());
    }

}
