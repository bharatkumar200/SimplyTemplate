# SimplyTemplate

This is a very simple native PHP templating system for small projects.

**Notes**

- suitable for small projects only; for more complexity use League Plate, Twig, Latte, etc.
- currently in development = prone to errors
- created for learning purpose

## Usage

Create the template to render. Extend a layout using `@extend=layoutName` directive.

You can escape the variables using `$this->esc($var)`.

```php
// Template to render: "page.php"

@extend=_layout

<h1><?= $title ?></h1>
<p><?= $content ?></p>

<?= $this->esc("<p>hello</p>");?>

```

**_layout.php**:

```php

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
</head>

<body>
    <header>
        this is header
    </header>

    <main>
        <?= $content ?>
    </main>

    <aside>
        <?php include('_sidebar.php') ?>
    </aside>

    <footer>
        footer here
    </footer>
</body>

</html>
```
To include any partial just use the php function `include()`.

**using the template engine to render:**

```php

<?php

include_once 'vendor/autoload.php';

$templateDir = __DIR__ . '/views';
$templateExtension = 'php';

$template = new \SimplyDi\SimplyTemplate\Engine(
    $templateDir,
    $templateExtension
);

$data = [
    'title' => 'My Page Title',
    'content' => 'This is the main content of the page.',
];

// get the template html via renderer
$output = $template->render('page', $data);

echo $output; // outputs the html


```
