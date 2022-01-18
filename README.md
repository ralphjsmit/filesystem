![Stubs Banner](https://github.com/ralphjsmit/stubs/blob/main/docs/images/stubs.jpg)


# Simplify complex stub workflows.

This package helps you to speed up the process of moving and copying files. It also makes replacing namespaces much easier, thus making it an invaluable tool for heavy filesystem tasks. Enjoy!

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

You can use a `Stub` configuration like this (I'll talk more about file actions below):

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

$stubs->getFile('/tmp/TestFileA.php')->namespace('Support/Models');
// Moves __DIR__ . `/tmp/testFileA.php` to __DIR__ . `/src/Support/Models/testFileA.php`.
```

You can also have multiple stubs together:

```php
$stubA = Stub::dir(__DIR__ . '/src');
$stubB = Stub::dir(__DIR__ . '/app');
$stubC = Stub::dir(__DIR__ . '/tmp');
```

## Getting a File object

You can get a `File` object by directly calling `file()` on the `Stub` class:

```php
$file = Stub::file(__DIR__ . '/tmp/testFileA.php`);
```

You can also get a `File` object from a `$stub` instance:

```php
$stub = Stub::dir(__DIR__);

$file = $stub->getFile('/tmp/testFileA.php');
```

### Actions on a File object

If you have a `File` object, you can perform the following actions on it:

#### Copying a file

You can copy a file to a new **directory** using the `copy()` function:

```php
$file = Stub::dir(__DIR__)->getFile('/tmp/testFileA.php')->copy('/tmp/test');
// $file is now in __DIR__ . '/tmp/testFileA.php' AND in __DIR__ . '/tmp/test/testFileA.php'
```

#### Deleting a file

You can delete a file using the `delete()` function:

```php
Stub::dir(__DIR__)->getFile('/tmp/testFileA.php')->delete();
// returns true on success
```

#### Getting the basename of a file

You can get the basename of a file using the `getBasename()` function:

```php
Stub::dir(__DIR__)->getFile('/tmp/testFileA.php')->getBasename();
// 'testFileA.php'
```

#### Getting the directory location of a file

You can get the location of the directory of a file using the `getDirectory()` function:

```php
Stub::dir(__DIR__)->getFile('/tmp/testFileA.php')->getDirectory();
// __DIR__ . '/tmp'
```

#### Getting the full path of a file

You can get the full path of a file using the `getFilepath()` function:

```php
Stub::dir(__DIR__)->getFile('/tmp/testFileA.php')->getFilepath();
// __DIR__ . '/testFileA.php'
```

#### Getting the file contents

You can get the contents of a file using the `getContents()` function:

```php
$contents = Stub::dir(__DIR__)->getFile('/tmp/testFileA.php')->getContents();
```

#### Moving a file

You can move a file to a new **directory** using the `move()` function:

```php
$file = Stub::dir(__DIR__)->getFile('/tmp/testFileA.php')->move('/tmp/test');
// $file is now in __DIR__ . '/tmp/test/testFileA.php'
```

#### Updating the namespace of a file

You may update the namespace of a file and move it to the correct directory with the `namespace()` helper. This is ideal if you need to move a PHP-file to a new directory *and* update the namespace of it. I use this technique in the [ralphjsmit/tall-install](https://github.com/ralphjsmit/tall-install/) package. 

```php
$basePath = __DIR__;

$stubs = Stubs::dir($basePath)->namespaces([
    'Support' => '/src/Support/',
    'Domain' => '/src/Domain/',
    'App' => '/src/App/',
]);

$stubs->getFile('/app/Console/Kernel.php')->namespace('Support\App\Console');
// file is not in __DIR__ . '/src/Support/App/Console/Kernel.php'
```

[Checkout a real-life example from one of my packages](https://github.com/ralphjsmit/tall-install/blob/main/src/Actions/DDD/UpdateFileStructureAction.php).

#### Updating the contents of a file

You may update the contents of a file with the `putFile()` method:

```php
$newContents = 'Hello world!';

$file = Stub::dir(__DIR__)->getFile('/tmp/testFileA.php')->putFile($newContents);
```

You may also specify a new location for the file:
```php
$newContents = 'Hello world!';

$file = Stub::dir(__DIR__)->getFile('/tmp/testFileA.php')->putFile($newContents, '/tmp/test/myFile.php');
// Will create a file with the "Hello world!" in __DIR__ . '/tmp/test/myFile.php`
// Old file will still exist
```

If you just want to move or copy a file, you should use those methods.

#### Updating the namespace of a file

You may replace the namespace of a file with the `replaceNamespace($newNamespace)` method:

```php
$file = Stub::dir(__DIR)->getFile('/tmp/test/MyClass.php');

$file->replaceNamespace('App\Models');

// $file will now have the namespace App\Models
```

## General

🐞 If you spot a bug, please submit a detailed issue and I'll try to fix it as soon as possible.

🔐 If you discover a vulnerability, please review [our security policy](../../security/policy).

🙌 If you want to contribute, please submit a pull request. All PRs will be fully credited. If you're unsure whether I'd accept your idea, feel free to contact me!

🙋‍♂️ [Ralph J. Smit](https://ralphjsmit.com)

