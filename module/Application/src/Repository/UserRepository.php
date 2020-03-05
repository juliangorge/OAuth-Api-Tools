<?php
namespace Application\Repository;

use Application\Entity\Identity;
use Doctrine\ORM\EntityRepository;
use Hybridauth\User\Profile;

class UserRepository extends EntityRepository
{
    /**
     * Create or update a user according to its social identity (coming from Facebook, Google, etc.)
     * @param string $provider
     * @param Profile $profile
     * @return User
     */
    public function createOrUpdate($provider, Profile $profile)
    {
        $entityManager = $this->getEntityManager();

        // First, look for pre-existing identity
        $identityRepository = $entityManager->getRepository(Identity::class);
        $identity = $identityRepository->findOneBy([
            'provider' => $provider,
            'providerId' => $profile->identifier,
        ]);

        $user = null;
        if ($identity) {
            // If we received an identity, pull its user
            $user = $identity->getUser();
        } elseif ($profile->email) {
            // If not, but we have an email associated with the profile, look
            // for pre-existing user (with another identity)
            $user = $this->findOneByEmail($profile->email);
        }

        // If we still couldn't find a user, create a new one
        if (! $user) {
            $user = new User();
            $entityManager->persist($user);
        }

        // Also, create an identity if we couldn't find one at the beginning
        if (! $identity) {
            $identity = new Identity();
            $identity->setUser($user);
            $identity->setProvider($provider);
            $identity->setProviderId($profile->identifier);
            $entityManager->persist($identity);
        }

        // Finally update all user properties, but never destroy existing data
        if ($profile->displayName) {
            $user->setName($profile->displayName);
        }

        if ($profile->email) {
            $user->setEmail($profile->email);
        }

        if ($profile->photoURL) {
            $user->setPhoto($profile->photoURL);
        }

        // and other properties ...

        return $user;
    }
}