<?php

namespace Glitch\Tests;

use Mockery;
use PHPUnit_Framework_TestCase;

abstract class Test extends PHPUnit_Framework_TestCase
{
    /**
     * @inheritdoc
     */
    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}
