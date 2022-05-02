<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EasyAdminUserPassword implements EventSubscriberInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var UserPasswordHasherInterface
     */
    private $passwordEncoder;

    /**
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordHasherInterface $passwordEncoder
     */
    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @return \string[][]
     */
    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['addUser'],
            BeforeEntityUpdatedEvent::class => ['updateUser'],
        ];
    }

    /**
     * @param BeforeEntityUpdatedEvent $event
     * @return void
     */
    public function updateUser(BeforeEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof User)) {
            return;
        }
        $this->setPassword($entity);
    }

    /**
     * @param BeforeEntityPersistedEvent $event
     * @return void
     */
    public function addUser(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof User)) {
            return;
        }
        $this->setPassword($entity);
    }

    /**
     * @param User $entity
     */
    public function setPassword(User $entity): void
    {
        $entity->setPassword($this->passwordEncoder->hashPassword($entity, $entity->getPassword()));
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

}