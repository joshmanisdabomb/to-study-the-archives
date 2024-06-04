<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('trim', fn() => '<?php ob_start() ?>');
        Blade::directive('endtrim', fn() => "<?php echo trim(ob_get_clean()); ?>");

        $minifyStack = 0;
        Blade::directive('minify', function () use (&$minifyStack) {
            $index = bin2hex(config('app.key')) . '_' . $minifyStack++;
            return "<?php ob_start(); echo <<<'MINIFY$index'\n";
        });
        Blade::directive('endminify', function () use (&$minifyStack) {
            $index = bin2hex(config('app.key')) . '_' . --$minifyStack;
            return "\nMINIFY$index; eval('?>' . preg_replace('#\?>\s+<\?php#', '?><?php', trim(ob_get_clean()))); ?>";
        });

        Blade::directive('return', function (string $expression) {
            if (!$expression) return '<?php return; ?>';
            return "<?php echo $expression; return; ?>";
        });
    }
}
