<?php namespace Flare\Math;

use Illuminate\Support\ServiceProvider;

class MathServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;


	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->booting(function()
		{
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();
			$loader->alias('Math', 'Flare\Math\Facades\Math');
		});

		$this->app->bind('SolutionEngineInterface', '\Flare\Math\Drivers\EvalMathDriver');

		$this->app['math'] = $this->app->share(function($app)
		{
			return new Math($this->app->make('SolutionEngineInterface'));
		});

		
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('math');
	}

}