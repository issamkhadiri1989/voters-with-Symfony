<?php

namespace App\Security\Voter;

use App\Entity\Blog;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * This voter will control **view** and **edit** a blog page.
 */
class BlogVoter extends Voter
{
    protected function supports(string $attribute, mixed $subject): bool
    {
        // this Voter must vote only for blog object and
        // operation (subject) should only be 1 of the 2 operations.
        return $subject instanceof Blog && (
            'CAN_VIEW_BLOG' === $attribute || 'CAN_EDIT_BLOG' === $attribute
        );
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool
    {
        /** @var Blog $blog */
        $blog = $subject;

        /** @var User|null $user */
        $user = $token->getUser();

        return match ($attribute) {
            'CAN_VIEW_BLOG' => $this->canViewBlog($blog, $user),
            'CAN_EDIT_BLOG' => $this->canEditBlog($blog, $user),
            default => false,
        };
    }

    private function canEditBlog(Blog $blog, ?User $user): bool
    {
        // edition of the Blog requires the user to be logged in
        if (null === $user) {
            return false;
        }

        // edition should only be allowed for the author
        return true === $blog->isAuthoredBy($user);
    }

    private function canViewBlog(Blog $blog, ?User $token): bool
    {
        // the blog is visible for public access
        if (true === $blog->isPublished()) {
            return true;
        }

        // if the blog is not published, the author should be capable to edit
        return true === $this->canEditBlog($blog, $token);
    }
}
