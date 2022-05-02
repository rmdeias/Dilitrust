<?php

namespace App\EventSubscriber;

use App\Entity\Document;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;

class EasyAdminDocumentUserIdDate implements EventSubscriberInterface
{


    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var Security
     */
    private $security;

    /**
     * @param EntityManagerInterface $entityManager
     * @param Security $security
     */
    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;

    }

    /**
     * @return \string[][]
     */
    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['addIdUser'],
        ];
    }

    /**
     * @param BeforeEntityPersistedEvent $event
     * @return void
     */
    public function addIdUser(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof Document)) {
            return;
        }
        $this->setDocumentUserId($entity);
    }


    /**
     * @param Document $entity
     */
    public function setDocumentUserId(Document $entity): void
    {

        $time = new \DateTime();
        $user = $this->security ->getUser();
        $entity->setUser($user);
        $entity->setLastModification($time);
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}