<?php namespace Davispeixoto\Testingtool;

use Davispeixoto\Testingtool\Commands;
use Illuminate\Support\ServiceProvider;

class TestingtoolServiceProvider extends ServiceProvider {

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
		$this->app['generate.tests'] = $this->app->share(function($app) {
			return new Commands\TestsGeneratorCommand($app['files']);
		});
		
		$this->commands('generate.tests');
	}
}