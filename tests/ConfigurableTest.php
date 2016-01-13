<?php

namespace Glitch\Tests;

use Glitch\Configurable;
use Glitch\ConfigurableTrait;
use Glitch\Extensible;
use Glitch\ExtensibleTrait;
use Glitch\Extension;
use Glitch\ExtensionTrait;

final class ConfigurableTestExtensible implements Configurable, Extensible
{
    use ConfigurableTrait;
    use ExtensibleTrait;

    /**
     * @inheritdoc
     *
     * @param array $config
     *
     * @return array
     */
    public function onConfig(array $config = [])
    {
        return [
            "cache" => 5,
            "widgets" => false,
        ];
    }
}

final class ConfigurableTestExtension1 implements Configurable, Extension
{
    use ConfigurableTrait;
    use ExtensionTrait;

    /**
     * @inheritdoc
     *
     * @param array $config
     *
     * @return array
     */
    public function onConfig(array $config = [])
    {
        return [
            "widgets" => true,
        ];
    }
}

final class ConfigurableTestExtension2 implements Configurable, Extension
{
    use ConfigurableTrait;
    use ExtensionTrait;

    /**
     * @inheritdoc
     *
     * @param array $config
     *
     * @return array
     */
    public function onConfig(array $config = [])
    {
        return [
            "private" => true,
        ];
    }
}

class ConfigurableTest extends Test
{
    public function testConfigurable()
    {
        $extensible = new ConfigurableTestExtensible();

        $expected = [
            "cache" => 5,
            "widgets" => false,
        ];

        $actual = $extensible->getConfig();

        ksort($expected);
        ksort($actual);

        $this->assertEquals($expected, $actual);

        $extensible->addExtension(ConfigurableTestExtension1::class);
        $extensible->addExtension(ConfigurableTestExtension2::class);

        $expected = [
            "cache" => 5,
            "widgets" => true,
            "private" => true,
        ];

        $actual = $extensible->getConfig();

        ksort($expected);
        ksort($actual);

        $this->assertEquals($expected, $actual);

        $extensible->removeExtension(ConfigurableTestExtension1::class);

        $expected = [
            "cache" => 5,
            "widgets" => false,
            "private" => true,
        ];

        $actual = $extensible->getConfig();

        ksort($expected);
        ksort($actual);

        $this->assertEquals($expected, $actual);
    }
}
