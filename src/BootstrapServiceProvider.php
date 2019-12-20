<?php

namespace EvolutionCMS\Bootstrap;

use EvolutionCMS\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class BootstrapServiceProvider extends ServiceProvider
{
    protected $namespace = 'bootstrap';

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->loadSnippetsFrom(dirname(__DIR__) . '/snippets/', $this->namespace);
        $this->loadPluginsFrom(dirname(__DIR__) . '/plugins/');
    }

    public function boot()
    {
        $this->publishes([
            dirname(__DIR__) . '/publish' => MODX_BASE_PATH,
        ]);

        Blade::directive('run', function($args) {
            return "<?php echo \$modx->runSnippet($args); ?>";
        });

        Blade::directive('runescaped', function($args) {
            return "<?php echo e(\$modx->runSnippet($args)); ?>";
        });

        Blade::directive('config', function($args) {
            $args = array_map('trim', explode(',', $args));

            if (empty($args[0])) {
                return '';
            }

            $setting = $args[0];
            $escape  = isset($args[1]) && $args[1] == 'true';

            return '<?php echo ' . ($escape ? 'e(' : '') . "\$modx->getConfig($setting)" . ($escape ? ')' : '') . '; ?>';
        });
    }
}