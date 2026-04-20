<?php

namespace App\Handler\Blog;

use App\Entity\Blog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

final readonly class BlogHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private Security $security,
    ) {
    }

    public function handle(Blog $blog, bool $new = false): void
    {
        if (true === $new) {
            $blog->setCreatedAt(new \DateTimeImmutable())
                ->setAuthor($this->security->getUser());
            $this->entityManager->persist($blog);
        } else {
            $blog->setUpdatedAt(new \DateTimeImmutable());
        }
        $this->entityManager->flush();
    }
}
