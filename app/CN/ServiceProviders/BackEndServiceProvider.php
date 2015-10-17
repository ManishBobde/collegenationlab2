<?php
/**
 * Created by PhpStorm.
 * User: MVB
 * Date: 28-03-2015
 * Time: 00:54
 */

namespace App\CN\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use App\CN\CNUsers\CNUsersRepository;


class BackEndServiceProvider extends ServiceProvider{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerUserComponent();
        $this->registerLocationComponent();

    }

    /**
     *
     */
    public function registerUserComponent(){

        $this->app
            ->bind(
                'CN\Users\UserInterface',
                'CN\CNUsers\CNUsersRepository'
            );
    }

    public function registerLocationComponent(){

        $this->app
            ->bind(
                'App\Salonkart\Locations\LocationInterface',
                'App\Salonkart\SalonLocations\SalonLocationsRepository'
            );
    }
}