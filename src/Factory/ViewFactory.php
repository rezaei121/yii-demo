<?php

namespace App\Factory;

use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;
use Yiisoft\Aliases\Aliases;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\View\Theme;
use Yiisoft\View\WebView;

class ViewFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $aliases = $container->get(Aliases::class);
        $theme = $container->get(Theme::class);
        $logger = $container->get(LoggerInterface::class);
        $eventDispatcher = $container->get(EventDispatcherInterface::class);

        $webView = new WebView($aliases->get('@views'), $theme, $eventDispatcher, $logger);

        /**
         * Passes {{@see UrlGeneratorInterface}} to view files. It will be available as $urlGenerator in view or layout.
         */
        $webView->setDefaultParameters([
            'urlGenerator' => $container->get(UrlGeneratorInterface::class),
        ]);

        return $webView;
    }
}
