This Laravel 4 package provides a powerful test generator to speed up your development process.

## Installation

Begin by installing this package through Composer. Edit your project's `composer.json` file to require `davispeixoto/testingtool`.

	"require": {
		"laravel/framework": "4.1.*",
		"davispeixoto/testingtool": "dev-master"
	},
	"minimum-stability" : "dev"

Next, update Composer from the Terminal:

    composer update

Once this operation completes, the final step is to add the service provider. Open `app/config/app.php`, and add a new item to the providers array.

    'Davispeixoto\Testingtool\TestingtoolServiceProvider'

That's it! You're all set to go. Run the `artisan` command from the Terminal to see the new `generate:tests` commands.

    php artisan

## Usage

Use `generate:tests` when you need to create a new PHPUnit test class. Here's an example:

```bash
php artisan generate:tests FooTest
```

This will produce `app/tests/FooTest.php`.

```php
<?php

class FooTest extends TestCase {

    public function test()
    {

    }

}
```