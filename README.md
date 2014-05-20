Laravel 4 Test Generator
========================

[![Build Status](https://travis-ci.org/davispeixoto/Laravel-4-Test-Generator.svg?branch=master)](https://travis-ci.org/davispeixoto/Laravel-4-Test-Generator)

This Laravel 4 package provides a powerful test generator to speed up your development process.

It's based on the facility [PHPUnit Skeleton Generator](http://phpunit.de/manual/current/en/skeleton-generator.html) provides and [Jeffrey Way's](http://jeffrey-way.com/) [Laravel 4 generators](https://github.com/JeffreyWay/Laravel-4-Generators).

The first doesn't work 100% with all Laravel 4 application classes. Usually you need to add some dependency in the class to make it work, even if your project solves it all with the [Composer](https://getcomposer.org/) [PSR-0](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md) compliant autoloader.

The second, generates a really tiny test class. It doesn't maps all class public methods and let everything in place.

This generator loads the target with and use the PHP Reflection features for reverse engineer all public methods, and provide an enhanced skeleton, including calls for [data providers](http://phpunit.de/manual/current/en/writing-tests-for-phpunit.html#writing-tests-for-phpunit.data-providers).

Installation
------------

Begin by installing this package through Composer. Edit your project's `composer.json` file to require `davispeixoto/testingtool`.

	"require": {
		"laravel/framework": "4.1.*",
		"davispeixoto/laravel-test-generator": "1.0.*"
	},
	"minimum-stability" : "stable"

Next, update Composer from the Terminal:

    composer update

Once this operation completes, the final step is to add the service provider. Open `app/config/app.php`, and add a new item to the providers array.

    'Davispeixoto\Testingtool\TestingtoolServiceProvider'

That's it! You're all set to go. Run the `artisan` command from the Terminal to see the new `tests:generate` commands.

    php artisan

Usage
-----

Use `tests:generate` when you need to create a new PHPUnit test class.
Here's an example:

```bash

php artisan controller:make UserController
php artisan tests:generate UserController
```

This will generate a resource controller and a test class `app/tests/UserControllerTest.php` as follows:

```php
<?php
class UserControllerTest extends TestCase {
	
	/**
	 * Tests UserController::index
	 */
	public function testindex()
	{
		//@TODO implement testindex body
	}
	
	/**
	 * Tests UserController::create
	 */
	public function testcreate()
	{
		//@TODO implement testcreate body
	}
	
	/**
	 * Tests UserController::store
	 */
	public function teststore()
	{
		//@TODO implement teststore body
	}
	
	/**
	 * Tests UserController::show
	 *
	 * @dataProvider providershow
	 */
	public function testshow($id)
	{
		//@TODO implement testshow body
	}
	
	/**
	 * Tests UserController::edit
	 *
	 * @dataProvider provideredit
	 */
	public function testedit($id)
	{
		//@TODO implement testedit body
	}
	
	/**
	 * Tests UserController::update
	 *
	 * @dataProvider providerupdate
	 */
	public function testupdate($id)
	{
		//@TODO implement testupdate body
	}
	
	/**
	 * Tests UserController::destroy
	 *
	 * @dataProvider providerdestroy
	 */
	public function testdestroy($id)
	{
		//@TODO implement testdestroy body
	}
	
	
	/**
	 * Data provider function for UserController::show
	 */
	public function providershow()
	{
		return $this->dataProvider('UserController.show.csv');
	}
	
	/**
	 * Data provider function for UserController::edit
	 */
	public function provideredit()
	{
		return $this->dataProvider('UserController.edit.csv');
	}
	
	/**
	 * Data provider function for UserController::update
	 */
	public function providerupdate()
	{
		return $this->dataProvider('UserController.update.csv');
	}
	
	/**
	 * Data provider function for UserController::destroy
	 */
	public function providerdestroy()
	{
		return $this->dataProvider('UserController.destroy.csv');
	}
	
}
?>
```

For full usage, I recommend first reading the article [Testing Like a Boss in Laravel](http://code.tutsplus.com/tutorials/testing-like-a-boss-in-laravel-models--net-30087). There are some performance tuning to be made in the Laravel 4 core TestCase class.

Along with them, to add the data providers functionality. Add to your Laravel composer.json:

	"require": {
		"laravel/framework": "4.1.*",
		"davispeixoto/testingtool": "dev-master",
		"keboola/csv" : "dev-master"
	},
	"minimum-stability" : "dev"
	
Next, update Composer from the Terminal:

    composer update
	
And finally, let the TestCase class like this:

```php
<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase {
	
	/**
	 * Default preparation for each test
	 */
	public function setUp()
	{
		parent::setUp();
		$this->prepareForTests();
	}

	/**
	 * Creates the application.
	 *
	 * @return \Symfony\Component\HttpKernel\HttpKernelInterface
	 */
	public function createApplication()
	{
		$unitTesting = true;
		$testEnvironment = 'testing';
		return require __DIR__.'/../../bootstrap/start.php';
	}
	
	/**
	 * Migrates the database.
	 * This will cause the tests to run quickly.
	 */
	private function prepareForTests()
	{
		Artisan::call('migrate');
	}
	
	/**
	 * dataProviders Factory
	 * dataProvider Short Description
	 *
	 * @param string $fileName
	 * @return \Keboola\Csv\CsvFile
	 */
	public function dataProvider($fileName) {
		return new Keboola\Csv\CsvFile(__DIR__.'/data/'.$fileName);
	}
}
?>
```

With these little changes, you can really speed up your testing process for your Laravel application.

### License

This Test Generator is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

### Versioning

This projetct follows the [Semantic Versioning](http://semver.org/)
