# Glitch

This is an attempt to prototype a robust configuration and extension system. For secret reasons.

## Motivation

### Extension

I want to extend core classes, by creating new extension classes, which hook into lifecycle methods and events in those core classes. I do not want to implement these extensions as traits. For example:

```php
class Product implements Extensible
{
    use ExtensibleTrait;

    public function render()
    {
        $markup = "...some markup";
        $extended = $this->extend("onRender", $markup);
        return $extended;
    }
}
```

I want this to work without any extensions applied to `Product`. However, if I do want to apply extensions, they should simply be allowed to implement `onRender`:

```php
class ProductRenderExtension implements Extension
{
    use ExtensionTrait;

    public function onRender($caller, $markup)
    {
        $markup .= "...some additional markup";
        return $markup;
    }
}
```

This leads to some architectural considerations:

- How do I apply multiple extensions?
- How does the state move between them?
- Should I pass initial state by reference?
- Can I pass multiple pieces of initial state or return multiple pieces of calculated state?

I attempt to answer these in the following ways:

- I should be able to apply multiple extensions. This is demonstrated in the tests.
- Extensions are executed in an unpredictable order. Extensions should be idempotent, and expect any initial state.
- State should be immutable, but this shouldn't be a requirement. The only requirement I think there should be is idempotence of extension hook methods. It's acceptable to return a modified state, but not to expect or use reference state parameters.
- For the sake of simplicity, extension methods should expect 1 piece of initial state and return 1 piece of calculated state. These can be arrays, but their structure should be well documented and validated.

I have created tests for this functionality, with a simple implementation to match.

### Configuration

I want to extend the configuration of core classes, by creating new extension classes, which hook into the config generation of these core classes. I want the final configuration to be cumulative, which means beginning with an initial configuration and adding/changing that with each subsequent extension. For example:

```php
class Product implements Configurable, Extensible
{
    use ConfigurableTrait;
    use ExtensibleTrait;

    public function onConfig(array $config = [])
    {
        return [
            "cache" => 5,
            "price" => 15,
        ];
    }
}
```

I want this to work without any extensions applied to `Product`. However, if I do want to apply extensions, they should simply be allowed to add to and modify the configuration:

```php
class ProductRenderExtension implements Configurable, Extension
{
    use ConfigurableTrait;
    use ExtensionTrait;

    public function onConfig(array $config = [])
    {
        return [
            "price" => 20,
            "color" => "blue",
        ];
    }
}
```

The simplest way to implement this is an iterative `array_replace_recursive` of the initial config (and any defaults) and then for each extension applied to an `Extensible` class.

## Versioning

This library follows [Semver](http://semver.org). According to Semver, you will be able to upgrade to any minor or patch version of this library without any breaking changes to the public API. Semver also requires that we clearly define the public API for this library.

All methods, with `public` visibility, are part of the public API. All other methods are not part of the public API. Where possible, we'll try to keep `protected` methods backwards-compatible in minor/patch versions, but if you're overriding methods then please test your work before upgrading.

## Thanks

I'd like to thank [SilverStripe](http://www.silverstripe.com) for letting me work on fun projects like this. Feel free to talk to me about using the [framework and CMS](http://www.silverstripe.org) or [working at SilverStripe](http://www.silverstripe.com/who-we-are/#careers).
