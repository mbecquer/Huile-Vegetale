<?php

namespace App\Listener;

use App\Entity\Huiles;
use App\Entity\Picture;
use Doctrine\Common\EventSubscriber;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Doctrine\Persistence\Event\LifecycleEventArgs as EventLifecycleEventArgs;

class ImageCacheListener implements EventSubscriber
{
    private $cacheManager;
    private $uploaderHelper;
    public function __construct(CacheManager $cacheManager, UploaderHelper $uploaderHelper)
    {
        $this->cacheManager = $cacheManager;
        $this->uploaderHelper = $uploaderHelper;
    }
    public function getSubscribedEvents()
    {
        return [
            "preRemove",
            'preUpdate'
        ];
    }

    public function preRemove(EventLifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Picture) {
            return;
        }

        $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
    }
    public function preUpdate(EventLifecycleEventArgs $args)
    {

        $entity = $args->getObject();

        if (!$entity instanceof Picture) {
            return;
        }
        if ($entity->getImageFile() instanceof UploadedFile) {
            $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
        }
    }
}
