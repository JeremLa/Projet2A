<?php
namespace AuthenticationBundle\Security\User;

use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\VarDumper\VarDumper;
use Unirest\Request as APIRequest;

class WebServiceUserProvider implements UserProviderInterface
{

    public function loadUserByUsername($username)
    {
        // make a call to your webservice here

        APIRequest::jsonOpts(true);
//        $userData = APIRequest::get('http://api.unamag.local/user/bymail', [], ['mail' => $username])->body;
        $userData = APIRequest::get('http://10.0.10.116/projet2a/api.unamag.local/web/user/bymail', [], ['mail' => $username])->body;
        // pretend it returns an array on success, false if there is no user

        if ($userData) {



            $id = $userData['id'];
            $password = $userData['password'];
            $salt = null;
            $roles = ['ROLE_USER'];

            return new WebServiceUser($id, $username, $password, $salt, $roles);
        }

        throw new UsernameNotFoundException(
            sprintf('Username "%s" does not exist.', $username)
        );
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof WebServiceUser) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return WebServiceUser::class === $class;
    }
}