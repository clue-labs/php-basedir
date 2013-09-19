# clue/basedir [![Build Status](https://travis-ci.org/clue/basedir.png?branch=master)](https://travis-ci.org/clue/basedir)

Common user base directory specification (home, data, cache directories) for desktop / CLI applications, compatible with
the [XDG Base Directory Specification](http://standards.freedesktop.org/basedir-spec/basedir-spec-latest.html).

## Quickstart examples

Once [installed](#install), let's initialize some directory paths:

````php
$basedir = new Clue\Basedir\Basedir();

$myapp->setCacheDirectory($basedir->getCacheHome());
$myapp->loadConfig($basedir->getConfigHome() . 'my/app/config.json');

````

## Usage

### Basedir

### Project

## Install

The recommended way to install this library is [through composer](http://getcomposer.org). [New to composer?](http://getcomposer.org/doc/00-intro.md)

```JSON
{
    "require": {
        "clue/basedir": "dev-master"
    }
}
```

## License

[MIT license](http://opensource.org/licenses/MIT).
