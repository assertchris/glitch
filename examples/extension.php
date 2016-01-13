<?php

require __DIR__ . "/../vendor/autoload.php";

use Glitch\Extensible;
use Glitch\ExtensibleTrait;
use Glitch\Extension;
use Glitch\ExtensionTrait;

class Product implements Extensible
{
    use ExtensibleTrait;

    /**
     * @var string
     */
    private $title = "New Product";

    /**
     * @return string
     */
    public function render()
    {
        $markup = "<h1>{$this->title}</h1>";
        $markup = $this->extend("onMarkup", $markup);

        return $markup;
    }
}

final class ProductExtension implements Extension
{
    use ExtensionTrait;

    /**
     * @var int
     */
    private $price = 5;

    /**
     * @param mixed $caller
     * @param string $markup
     *
     * @return string
     */
    public function onMarkup($caller, $markup)
    {
        if (!stristr($markup, "Price")) {
            $markup .= "<p>Price: {$this->price}</p>";
        }

        return $markup;
    }
}

$product = new Product();
$product->addExtension(ProductExtension::class);

$product->render(); // <h1>New Product</h1><p>Price: 5</p>
