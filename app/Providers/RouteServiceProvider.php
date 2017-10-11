<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Premise\Utilities\PremiseUtilities;
use Symfony\Component\Finder\SplFileInfo;

class RouteServiceProvider extends ServiceProvider
{
    protected $APIRoutePath;
    protected $WEBRoutePath;

    /** @var  PremiseUtilities */
    protected $psUtilities;

    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot()
    {
        $this->APIRoutePath = base_path('routes/API');
        $this->WEBRoutePath = base_path('routes/WEB');

        $this->setPsUtilities(new PremiseUtilities());

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     */
    public function map(Router $router)
    {
        $this->mapWebRoutes($router);

        $this->mapApiRoutes($router);
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @param \Illuminate\Routing\Router $router
     */
    protected function mapWebRoutes(Router $router)
    {
        $router->group([
            'namespace' => $this->namespace, 'middleware' => ['web', 'hasTeam'],
        ], function ($router) {
            $webRouteFiles = $this
                ->getPsUtilities()::getSplFileInfoForFilesInDirectory($this->WEBRoutePath);

            /** @var SplFileInfo $routeFile */
            foreach ($webRouteFiles as $routeFile) {
                $file = $this->WEBRoutePath.'/'.$routeFile->getFilename();
                require $file;
            }
        });
    }

    /**
     * Define the "api" routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     */
    protected function mapApiRoutes(Router $router)
    {
        $router->group([
            'namespace' => $this->namespace,
            'middleware' => 'api',
            'prefix' => 'api',
        ], function ($router) {
            $apiRouteFiles = $this
                ->getPsUtilities()::getSplFileInfoForFilesInDirectory($this->APIRoutePath);

            /** @var SplFileInfo $routeFile */
            foreach ($apiRouteFiles as $routeFile) {
                $file = $this->APIRoutePath.'/'.$routeFile->getFilename();
                require $file;
            }
        });
    }

    /**
     * @return mixed
     */
    protected function getPsUtilities(): PremiseUtilities
    {
        return $this->psUtilities;
    }

    /**
     * @param mixed $psUtilities
     *
     * @return RouteServiceProvider
     */
    protected function setPsUtilities(PremiseUtilities $psUtilities)
    {
        $this->psUtilities = $psUtilities;

        return $this;
    }
}
