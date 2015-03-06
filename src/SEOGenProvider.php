<?php namespace Astroanu\SEOGen;

use Illuminate\Support\ServiceProvider;

class SEOGenProvider extends ServiceProvider {

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Astroanu\SEOGen'
		);
	}

	/**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {

		$this->publishes([
		    __DIR__ . '/../config/seogen.php' => config_path('astroanu/seogen.php')
		], 'config');
    }
}
