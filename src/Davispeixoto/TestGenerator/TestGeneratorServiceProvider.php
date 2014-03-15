<?php namespace Davispeixoto\TestGenerator;

use Davispeixoto\TestGenerator\Commands;
use Illuminate\Support\ServiceProvider;

class TestGeneratorServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = TRUE;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['tests.generate'] = $this->app->share(function($app) {
			return new Commands\TestsGeneratorCommand($app['files']);
		});
		
		$this->commands('tests.generate');
	}
}