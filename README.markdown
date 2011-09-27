# MtHaml Bundle

[HAML][haml] Symfony bundle using the [MtHaml PHP HAML parser][mthaml].



## Features

- **Acts as a Twig preprocessor**
  Supports Twig functions, filters, macros, blocks, inheritance, expressions and every Twig features
- **High performance**  
  Templates are cached, no parsing or runtime overhead.
- **HAML syntax** supported by editors

## Installation

### Step 1: Download MtHaml and MtHamlBundle

Ultimately, the MtHaml files should be downloaded to the vendor/MtHaml directory, and the MtHamlBundle files to the vendor/bundles/MtHamlBundle directory.

This can be done in several ways, depending on your preference. The first method is the standard Symfony2 method.

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

#### With ->render()

``` php
public function bazAction() {
    $this->render('FooBundle:Bar:baz.html.haml');
}
```

#### Syntax

See [MtHaml][mthaml] docs

[haml]: http://haml-lang.com/
[mthaml]: https://github.com/arnaud-lb/MtHaml

