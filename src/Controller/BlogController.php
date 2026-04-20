<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Form\Type\BlogType;
use App\Handler\Blog\BlogHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/blogs', name: 'app_blog')]
final class BlogController extends AbstractController
{
    #[Route('/{id}', name: '__show')]
    #[IsGranted('PUBLIC_ACCESS')]
    #[IsGranted(attribute: 'CAN_VIEW_BLOG', subject: 'blog')]
    public function index(Blog $blog): Response
    {
        return $this->render('blog/index.html.twig', [
            'blog' => $blog,
        ]);
    }

    #[Route('/new', name: '__new', priority: 1)]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function newBlog(Request $request, BlogHandler $blogHandler): Response
    {
        $blog = new Blog();
        $form = $this->createForm(BlogType::class, $blog);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $blogHandler->handle($blog, true);

            return $this->redirectToRoute('app_blog__show', ['id' => $blog->getId()]);
        }

        return $this->render('blog/new.html.twig', [
            'blog_form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: '__edit')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function editBlog(Request $request, BlogHandler $blogHandler, Blog $blog): Response
    {
        $form = $this->createForm(BlogType::class, $blog);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $blogHandler->handle($blog);

            return $this->redirectToRoute('app_blog__edit', ['id' => $blog->getId()]);
        }

        return $this->render('blog/new.html.twig', [
            'blog_form' => $form,
        ]);
    }
}
