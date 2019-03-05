<?php


namespace Wren\Handler\Factory;


use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ServiceSubscriberInterface;
use Wren\Handler\{
    FileHandler, NormalFileHandler, TestFileHandler
};


class FileHandlerBus
{
    private $locator;

    public function __construct(ContainerInterface $locator)
    {
        $this->locator = $locator;
    }

    public function handle($commandMode)
    {
        $serviceId = $commandMode . '_handler';
        
        if ($this->locator->has($serviceId)) {
            /** @var FileHandler $handler */
            $handler = $this->locator->get($serviceId);

            return $handler->process();
        }

    }
}