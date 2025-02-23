<?php

namespace App\Shared\Infrastructure\Voter;

use App\Owner\Domain\Model\Owner;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class OwnerVoter extends Voter
{
    public function __construct(
        private readonly Security $security,
    )
    {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute === 'IS_OWNER';
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $this->security->getUser();

        return $user instanceof Owner;
    }
}
