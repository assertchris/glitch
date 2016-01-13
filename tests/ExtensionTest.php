<?php

namespace Glitch\Tests;

use Glitch\Extensible;
use Glitch\ExtensibleTrait;
use Glitch\Extension;
use Glitch\ExtensionTrait;

final class ExtensionTestExtensible implements Extensible
{
    use ExtensibleTrait;

    /**
     * @return int
     */
    public function run()
    {
        return $this->extend("onRun", 5);
    }
}

final class ExtensionTestExtension1 implements Extension
{
    use ExtensionTrait;

    /**
     * @param mixed $caller
     * @param int $value
     *
     * @return int
     */
    public function onRun($caller, $value)
    {
        return $value * 2;
    }
}

final class ExtensionTestExtension2 implements Extension
{
    use ExtensionTrait;

    /**
     * @param mixed $caller
     * @param int $value
     *
     * @return int
     */
    public function onRun($caller, $value)
    {
        return $value * 3;
    }
}

class ExtensionTest extends Test
{
    public function testExtension()
    {
        $extensible = new ExtensionTestExtensible();

        $this->assertEquals(5, $extensible->run());

        $extensible->addExtension(ExtensionTestExtension1::class);
        $extensible->addExtension(ExtensionTestExtension2::class);

        $this->assertEquals(30, $extensible->run());

        $extensible->removeExtension(ExtensionTestExtension2::class);

        $this->assertEquals(10, $extensible->run());
    }
}
