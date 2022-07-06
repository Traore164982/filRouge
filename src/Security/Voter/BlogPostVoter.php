<?php

namespace App\Security\Voter;

use App\Entity\Menu;
use App\Entity\User;
use App\Entity\Burger;
use App\Entity\Produit;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class BlogPostVoter extends Voter
{
    public const ACCESS = 'IS_ACCESS';
    public const DENIED = 'IS_DENIED';


    private $security = null;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::ACCESS, self::DENIED])
            && $subject instanceof \App\Entity\Burger or
            $subject instanceof \App\Entity\Menu ;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof \App\Entity\User) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::ACCESS:
                // logic to determine if the user can EDIT
                // return true or false
                return true;
                break;
            case self::DENIED:
                // logic to determine if the user can VIEW
                // return true or false
                return false;
                break;
        }
        return false;
    }
}
