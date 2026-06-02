<?php

/**
 * Guards against incompatible method/property declarations across the package
 * (e.g. a child redeclaring a typed parent property, or a trait method drifting
 * from its interface). These are fatal *linking* errors that PHP only raises
 * when the class is loaded — `php -l` does not catch them.
 *
 * Each class is loaded in its own subprocess so a single fatal reports cleanly
 * instead of aborting the whole test run.
 */

/**
 * Discover every class/interface/trait/enum declared under src/LaravelCM.
 * Namespaces are read from the file itself, so the App\Models stub model is
 * picked up under its real namespace too.
 *
 * @return array<string, array{0: string}>
 */
function packageSymbols(): array
{
    $root = dirname(__DIR__) . '/../src/LaravelCM';
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS)
    );

    $symbols = [];
    foreach ($files as $file) {
        if ($file->getExtension() !== 'php') {
            continue;
        }
        $code = file_get_contents($file->getPathname());
        if (!preg_match('/^namespace\s+([^;]+);/m', $code, $ns)) {
            continue;
        }
        if (!preg_match('/^\s*(?:abstract\s+|final\s+)?(?:class|interface|trait|enum)\s+(\w+)/m', $code, $sym)) {
            continue; // e.g. the cm_image helper file declares no class
        }
        $fqcn = trim($ns[1]) . '\\' . $sym[1];
        $symbols[$fqcn] = [$fqcn];
    }

    ksort($symbols);

    return $symbols;
}

it('links every package class without fatal signature or property errors', function (string $class) {
    $autoload = dirname(__DIR__) . '/../vendor/autoload.php';

    $snippet = sprintf(
        'require %s; $c = %s; (class_exists($c) || interface_exists($c) || trait_exists($c) || enum_exists($c)) or exit(1);',
        var_export($autoload, true),
        var_export($class, true)
    );

    $command = escapeshellarg(PHP_BINARY) . ' -r ' . escapeshellarg($snippet) . ' 2>&1';
    exec($command, $output, $exitCode);

    $this->assertSame(0, $exitCode, $class . " failed to link:\n" . implode("\n", $output));
})->with(packageSymbols());
