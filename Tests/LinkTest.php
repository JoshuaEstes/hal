<?php

use Hal\Link;

class LinkTest extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $link = new Link('/test', 'self');

        $this->assertEquals(array('self' => array('href' => '/test')), $link->asArray());
    }

}
