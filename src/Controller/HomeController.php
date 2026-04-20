<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Enum\Status;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $repository = $this->entityManager->getRepository(Blog::class);

        $blogs = $repository->findBy(['status' => Status::PUBLISHED]);

        return $this->render('home/index.html.twig', [
            'blogs' => $blogs,
        ]);
    }
}
