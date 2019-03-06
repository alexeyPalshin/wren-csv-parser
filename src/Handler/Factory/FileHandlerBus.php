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

    /**
     *
     * @param $commandMode string
     * @param $filePath string
     * @return mixed
     */
    public function handle(string $commandMode, $filePath)
    {
        $serviceId = $commandMode . '_handler';
        
        if ($this->locator->has($serviceId)) {
            /** @var FileHandler $handler */
            $handler = $this->locator->get($serviceId);

            return $handler->process($filePath);
        }

    }
}