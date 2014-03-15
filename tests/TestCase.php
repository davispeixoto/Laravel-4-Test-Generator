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
