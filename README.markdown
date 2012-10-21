# MtHaml Bundle

[HAML][haml] Symfony bundle using the [MtHaml PHP HAML parser][mthaml].

[![Build Status](https://secure.travis-ci.org/arnaud-lb/MtHamlBundle.png)](http://travis-ci.org/arnaud-lb/MtHamlBundle)

## Features

- **Acts as a Twig preprocessor**: Supports Twig functions, filters, macros, blocks, inheritance, expressions and every Twig features
- **Mix Twig and HAML templates**: You can include, extend, use and import Twig templates from HAML templates, and vice versa.
- **High performance**: Templates are compiled to PHP code and cached, no parsing or runtime overhead.
- **HAML syntax** supported by editors

## Installation

### Step 1: Download MtHaml and MtHamlBundle

Ultimately, the MtHaml files should be downloaded to the vendor/MtHaml directory, and the MtHamlBundle files to the vendor/bundles/MtHamlBundle directory.

This can be done in several ways, depending on your preference. The first method is the standard Symfony2 method.

#### Using Composer

```
$ composer require mthaml/mthaml-bundle:dev-master
```

(You can skip Step 2 if you are using this method as Composer will handle autoloading for you.)

#### Using the vendors script

Add the following lines in your deps file:

``` ini
[MtHaml]
    git=git://github.com/arnaud-lb/MtHaml.git
    target=MtHaml
[MtHamlBundle]
    git=git://github.com/arnaud-lb/MtHamlBundle.git
    target=bundles/MtHamlBundle
```

Now, run the vendors script to download the bundle:

``` sh
$ php bin/vendors install
```

#### Using submodules

If you prefer instead to use git submodules, the run the following:

``` sh
$ git submodule add git://github.com/arnaud-lb/MtHamlBundle.git vendor/bundles/MtHamlBundle
$ git submodule add git://github.com/arnaud-lb/MtHaml.git vendor/MtHaml
$ git submodule update --init
```

### Step 2: Configure the Autoloader

You can skip this step if you used composer to install the bundle.

Add the `MtHaml` and `MtHamlBundle` namespaces to your autoloader:

``` php
<?php
// app/autoload.php

$loader->registerNamespaces(array(
    // ...
    'MtHaml'       => __DIR__ . '/../vendor/MtHaml/lib',
    'MtHamlBundle' => __DIR__ . '/../vendor/bundles',
));
```

### Step 3: Enable the bundle

Finally, enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new MtHamlBundle\MtHamlBundle(),
    );
}
```

### Step 4: Configure the MtHamlBundle

``` yml
# app/config/config.yml

framework:
    # ...
    templating:
        engines: ['haml','twig']

# required, for Symfony to load the bundle configuration
mt_haml:
```

(This is required, for Symfony to load the bundle configuration.)

### Step 5: Use it

#### With the @Template() annotation:

``` php
/**
 * @Template(engine="haml")
 */
public function fooAction() {
```

#### With the @Haml() annotation:

The `@Haml` annotation is a sub class of `@Template` with `engine` set to `haml` by default.

``` php
/**
 * @Haml
 */
public function fooAction() {
```

#### With ->render()

``` php
public function bazAction() {
    $this->render('FooBundle:Bar:baz.html.haml');
}
```

#### With FOSRestBundle:

``` php
/**
 * @View(engine="haml")
 */
public function fooAction() {
```

## Syntax

See [MtHaml][mthaml] docs

[haml]: http://haml-lang.com/
[mthaml]: https://github.com/arnaud-lb/MtHaml

## Commands

### mthaml:debug:dump

The mthaml:debug:dump command compiles a HAML templates into Twig and displays the resulting Twig template.

For debug purposes.

Example:

    php ./app/console mthaml:debug:dump AcmeDemoBundle:Demo:index.html.haml

