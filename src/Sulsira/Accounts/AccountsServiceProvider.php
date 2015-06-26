<?php namespace Sulsira\Accounts;

use Illuminate\Support\ServiceProvider;

class AccountsServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
//        $this->mergeConfigFrom(
//            __DIR__.'\config\config.php', 'Accounts'
//        );
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [];
	}

    /*
     * boots up configuration files for the user at vendor:publish
     * @return void
     */
    public function boot(){
        // Publish a config file

        $this->publishes([
            __DIR__.'\config\config.php' => config_path('accounts/config.php'),
        ]);

    }
}
