<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class UsersVoter extends Voter
{
    public const EDIT = 'POST_EDIT';
    public const VIEW = 'POST_VIEW';
    public const NEW = 'POST_NEW';

    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW, self::NEW])
            && $subject instanceof \App\Entity\User;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
 
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:

                    if($subject->getId() === 1)
                    {
                        if($user->getRoles()[0] == "ROLE_SUPADMIN") {
                            return true;
                        }
                    } else if ($subject->getId() > 1) {
                        return true;
                    }

                break;
            case self::VIEW:
                // logic to determine if the user can VIEW
                // return true or false
                break;
            case self::NEW:

                    if($user->getRoles()[0] == "ROLE_SUPADMIN") {
                        return true;
                    }

                break;
        }

        return false;
    }
}
