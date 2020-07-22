<?php
declare(strict_types = 1);

namespace App\Listener;

use Hyperf\Contract\ConfigInterface;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Framework\Event\BootApplication;
use Psr\Container\ContainerInterface;

class BootApplicationListener implements ListenerInterface
{
    private ContainerInterface $container;

    private StdoutLoggerInterface $logger;

    private ConfigInterface $config;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->logger    = $this->container->get(StdoutLoggerInterface::class);
        $this->config    = $this->container->get(ConfigInterface::class);
    }

    public function listen() : array
    {
        return [
            BootApplication::class,
        ];
    }

    public function process(object $event)
    {
        $isMiniProgram = $this->config->get('mini_program');
        if ($isMiniProgram) {
            $enable = $isMiniProgram['enable_all'];
            $key    = $isMiniProgram['key'];
            if (empty($key) && $enable) {
                $this->logger->error(sprintf('MiniProgram {Key} Not Empty Or Must String!❌'));
                exit(SIGTERM);
            }
            $config = $isMiniProgram['config'];
            foreach ($config as $name => $item) {
                $this->logger->info(sprintf('MiniProgram [%s] Config ✅.', $name));
            }
        }
    }
}


