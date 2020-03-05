<?php
namespace Api\V1\Rpc\HybridAuth;

use Application\Model\User;
use Doctrine\ORM\EntityManager;
use Hybridauth\Hybridauth;
use OAuth2\Encryption\Jwt;
use Laminas\Mvc\Controller\AbstractActionController;

class HybridAuthController extends AbstractActionController
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var array Hybridauth configuration
     */
    private $hybridauthConfiguration;

    /**
     * @var string
     */
    private $cryptoKey;

    /**
     * Constructor
     * @param EntityManager $entityManager
     * @param array $hybridauthConfiguration
     * @param string $cryptoKey
     */
    public function __construct(
        EntityManager $entityManager,
        array $hybridauthConfiguration,
        $cryptoKey
    ) {
        $this->entityManager = $entityManager;
        $this->hybridauthConfiguration = $hybridauthConfiguration;
        $this->cryptoKey = $cryptoKey;
    }

    /**
     * Returns the select authentification provider
     * @return \Hybridauth\Adapter\AdapterInterface
     */
    private function getProvider()
    {
        $uri = $this->getRequest()->getUri();
        $base = sprintf('%s://%s', $uri->getScheme(), $uri->getHost());

        $provider = $this->getRequest()->getQuery('provider');
        $config = $this->hybridauthConfiguration;

        // CAUTION: Be sure to change the route name based on your own routing definitions !
        $routeName = 'e-doctor.rpc.hybrid-auth';
        $config['callback'] = $base
            . $this->url()->fromRoute($routeName, ['action' => 'callback'])
            . '?provider=' . $provider;

        $hybridauth = new Hybridauth($config);
        $adapter = $hybridauth->getAdapter($provider);

        return $adapter;
    }

    public function hybridAuthAction()
    {
        $provider = $this->getProvider();
        $provider->disconnect();
        $provider->authenticate();

        // If we reach this point, that means we were already authenticated by
        // the provider. So we finish as a normal subscribe/login
        return $this->callbackAction();
    }

    public function callbackAction()
    {
        $provider = $this->getProvider();
        $provider->authenticate();
        $profile = $provider->getUserProfile();
        $providerName = strtolower($this->getRequest()->getQuery('provider'));

        $user = $this->entityManager
            ->getRepository(User::class)
            ->createOrUpdate($providerName, $profile);
        $this->entityManager->flush();

        $message = [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'photo' => $user->getPhoto(),
        ];

        $jwt = new Jwt();
        $token = $jwt->encode($message, $this->cryptoKey);

        // CAUTION: Be sure to change the URL according to your need !
        $url = 'https://edoctor.test/receive.html?token=' . $token;

        return $this->redirect()->toUrl($url);
    }
}