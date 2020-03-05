<?php
namespace Application;

use Application\Model\User;
use Application\Authentication\AuthenticatedIdentity;
use Doctrine\ORM\EntityManager;
use OAuth2\Encryption\Jwt;
use Laminas\Mvc\MvcEvent;
use Laminas\ApiTools\MvcAuth\Identity\GuestIdentity;
use Laminas\ApiTools\MvcAuth\MvcAuthEvent;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    private $serviceManager;

    public function onBootstrap(MvcEvent $e)
    {
        $this->serviceManager = $e->getApplication()->getServiceManager();
        $app = $e->getTarget();
        $events = $app->getEventManager();
        $events->attach('authentication', [$this, 'onAuthentication'], 100);
        $events->attach('authorization', [$this, 'onAuthorization'], 100);
    }

    /**
     * If the AUTHORIZATION HTTP header is found, validate and return the user,
     * otherwise default to 'guest'
     *
     * @param MvcAuthEvent $e
     * @return AuthenticatedIdentity|GuestIdentity
     */
    public function onAuthentication(MvcAuthEvent $e)
    {
        $guest = new GuestIdentity();
        $header = $e->getMvcEvent()->getRequest()->getHeader('Authorization');

        if(!$header) return $guest;

        $token = $header->getFieldValue();
        $jwt = new Jwt();
        $key = $this->serviceManager->get('config')['cryptoKey'];
        $tokenData = $jwt->decode($token, $key);
        if(!$tokenData) return $guest;

        $entityManager = $this->serviceManager->get(EntityManager::class);
        $user = $entityManager->getRepository(User::class)->findOneById($tokenData['id']);
        return new AuthenticatedIdentity($user);
    }

    public function onAuthorization(MvcAuthEvent $e)
    {
        /* @var $authorization \Laminas\ApiTools\MvcAuth\Authorization\AclAuthorization */
        $authorization = $e->getAuthorizationService();
        $identity = $e->getIdentity();
        $resource = $e->getResource();

        // now set up additional ACLs...
    }
}