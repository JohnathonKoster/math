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

		$this->app->bind('ExecutionEngineInterface', '\Flare\Math\Drivers\MathExecutionEngine');
		$this->app->singleton('SolutionEngineInterface', function($app) {
			return new \Flare\Math\Drivers\EvalMathDriver($app->make('ExecutionEngineInterface'));
		});

		$this->app['math'] = $this->app->share(function($app)
		{
			return new Math($this->app->make('SolutionEngineInterface'), $this->app->make('ExecutionEngineInterface'));
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