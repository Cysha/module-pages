<?php namespace Cms\Modules\Pages\Providers;

use Cms\Modules\Core\Providers\BaseModuleProvider;

class PagesModuleServiceProvider extends BaseModuleProvider
{

    /**
     * Register the defined middleware.
     *
     * @var array
     */
    protected $middleware = [
        'Pages' => [
        ],
    ];

    /**
     * The commands to register.
     *
     * @var array
     */
    protected $commands = [
        'Pages' => [
        ],
    ];

    /**
     * Register view composers
     *
     * @var array
     */
    protected $composers = [
        'Pages' => [
        ],
    ];

    /**
     * Register repository bindings to the IoC
     *
     * @var array
     */
    protected $bindings = [

    ];

    /**
     * Register Auth related stuffs
     */
    public function register()
    {
        parent::register();

    }

}
