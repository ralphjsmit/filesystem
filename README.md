# Simplify complex stub workflows.

This helps to speed up the process of moving and copying files. It also makes replacing namespaces much easier, thus making it an invaluable tool for heavy filesystem tasks.

[![Run Tests](https://github.com/ralphjsmit/stubs/actions/workflows/run-tests.yml/badge.svg?event=push)](https://github.com/ralphjsmit/stubs/actions/workflows/run-tests.yml)

## Installation

You can install the package via composer:

```bash
composer require ralphjsmit/stubs
```

## Usage

This package works by providing you with a base `Stub` class and a `File` class. As the name implies, the `Stub` class is an object that contains specific configuration, like the namespaces and the base directory. The `File` class is used to represent an individual file.

### Creating a Stub configuration

You can create a new `Stub` configuration with `Stub::new()`:

```php
use RalphJSmit\Stubs\Stubs;

$stub = Stub::new();
```

Next, use it like this:
```php
$stub->getFile(__DIR__ . '/tmp/testFileA.php')->move(__DIR__ . '/tmp/otherFolder');
```

You can also set a base directory for your `Stub`:
```php
$stub = Stub::dir(__DIR__);

$stub->getFile('/tmp/testFileA.php')->move('/tmp/otherFolder');
```

If you already have a `$stub` instance, you can configure namespaces on them. Those namespaces are used on the `File` object for the `->namespace()` action. It basically means that you define the directories for each namespace in your project.

```php
$stubs = Stubs::dir(__DIR__)->namespaces([
    'Support' => '/src/Support/',
    'Domain' => '/src/Domain/',
    'App' => '/src/App/',
]);

$stubs->getFile('tmp/TestFileA.php')->namespace('Support/Models');
// Moves __DIR__ . `tmp/testFileA.php` to __DIR__ . `/src/Support/Models/testFileA.php`.
```

You can also have multiple stubs together:

```php
$stubTemp = Stub::dir(__DIR__ . '/tmp');
$stubApp = Stub::dir(__DIR__ . '/tmp');
```

## Getting a File object

You can get a `File` object by directly calling `file()` on the `Stub` class:

```php
$file = Stub::file(__DIR__ . '/tmp/testFileA.php`);
```

You can also get a `File` object from a `$stub` instance:

```php
$stub = Stub::dir(__DIR__);

$file = $stub->getFile('/tmp/testFileA.php`);
```

### Actions on a File object

If you have a `File` object, you can perform the following actions on it:
