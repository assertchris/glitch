<?php

require __DIR__ . "/../vendor/autoload.php";

use Glitch\Configurable;
use Glitch\ConfigurableTrait;
use Glitch\Extensible;
use Glitch\ExtensibleTrait;
use Glitch\Extension;
use Glitch\ExtensionTrait;

class Page implements Configurable, Extensible
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

final class PageExtension implements Configurable, Extension
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

$page = new Page();
$page->addExtension(PageExtension::class);

$page->getConfig(); // [ "cache" => 5, "widgets" => true ]
