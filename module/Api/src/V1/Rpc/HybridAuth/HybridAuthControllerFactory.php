<?php
namespace Api\V1\Rpc\HybridAuth;

use Doctrine\ORM\EntityManager;

class HybridAuthControllerFactory
{
    public function __invoke($container)
    {
        $config = $container->get('config');

        return new HybridAuthController(
            $container->get(EntityManager::class),
            $config['hybridauth'],
            $config['cryptoKey']
        );
    }
}