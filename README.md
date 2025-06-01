Integrate Quill into open-admin
======

This is a `open-admin` extension that integrates `Quill` into the `open-admin` form.

## Screenshot

![field-quill](https://github.com/user-attachments/assets/bb1e884d-b3ac-4e3a-83e6-79fb2dbfa776)

## Installation

```bash
composer require open-admin-ext/quill
```

Then
```bash
php artisan vendor:publish --tag=open-admin-quill
```

## Configuration

In the `extensions` section of the `config/admin.php` file, add some configuration that belongs to this extension.
```php

    'extensions' => [

        'quill' => [

            //Set to false if you want to disable this extension
            'enable' => true,

            // Editor configuration
            'config' => [

            ]
        ]
    ]

```
The configuration of the editor can be found in [Quill Documentation](https://quilljs.com/docs/configuration/), such as configuration language and height.
```php
    'config' => [
        'placeholder'      => 'Compose an epic...',
    ]
```

## Usage

Use it in the form:
```php
$form->quill('content','field label');

// Set config
$form->quill('content')->options(['placeholder' => 'Write some text...', ...]);

// Set heights
$form->quill('content')->minHeight('200px')->maxHeight('600px');

// Set toolbar
$form->quill('content')->toolbar([['bold', 'italic', 'underline', 'strike']['clean']]);
```

Problems?
------------
Please not that Quill does not work nicely with the Ckeditor installed and enabled.

If Quill is not showing up and tells you that it's not found run the lines below to clear the compiled services and packages.

```bash
php artisan optimize:clear
```

License
------------
Licensed under [The MIT License (MIT)](LICENSE).
