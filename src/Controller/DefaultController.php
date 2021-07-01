<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Stevenmaguire\OAuth2\Client\Provider\Keycloak;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Controller\KeyCloakApiController;

class DefaultController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function loginAction(Request $request,  KeyCloakApiController $keycloak_api)
    {

        //$provider = new Stevenmaguire\OAuth2\Client\Provider\Keycloak([
        /*$provider = new Keycloak([
            'authServerUrl'         => 'http://localhost:8080/auth',
            'realm'                 => 'Extranet',
            'clientId'              => 'my_appllicaction',
            'clientSecret'          => '0a34e383-1121-44e7-ad9a-fb07d8c93e32',
            'redirectUri'           => 'http://localhost:8000'
        ]);*/

        $provider = new Keycloak([
            'authServerUrl'         => $this->getParameter('keycloak-server-url'),
            'realm'                 => $this->getParameter('keycloak-realm'),
            'clientId'              => $this->getParameter('keycloak-client-id'),
            'clientSecret'          => $this->getParameter('keycloak-client-secret'),
            'redirectUri'           => $this->getParameter('keycloak-callback')
        ]);



        if (!isset($_GET['code'])) {
        
            // If we don't have an authorization code then get one
            $authUrl = $provider->getAuthorizationUrl();
            //echo "auth code url ".$authUrl."<br>";
            //die();
            $this->session->set('oauth2state', $provider->getState());
            header('Location: '.$authUrl);
            exit;
        
        // Check given state against previously stored one to mitigate CSRF attack
        }elseif (empty($_GET['state']) || ($_GET['state'] !== $this->session->get('oauth2state'))) {
       
            $this->session->remove( 'oauth2state' );
            exit('Invalid state, make sure HTTP sessions are enabled.');
        
        } else {
        
            // Try to get an access token (using the authorization coe grant)
            try {
                $token = $provider->getAccessToken('authorization_code', [
                    'code' => $_GET['code']
                ]);
            } catch (Exception $e) {
                exit('Failed to get access token: '.$e->getMessage());
            }
        
            // Optional: Now you have a token you can look up a users profile data
            try {
        
                // We got an access token, let's now get the user's details
                $user = $provider->getResourceOwner($token);

		//$roles = $provider->getRealmRoles(
                $this->session->set('user', $user);
                $roles=$keycloak_api->getRolesComposite($user->getId());
                $groups=$keycloak_api->getUserGroups($user->getId());
                // Use these details to create a new profile
                //printf('Hello %s!', $user->getName());
        
            } catch (Exception $e) {
                exit('Failed to get resource owner: '.$e->getMessage());
            }
     
            //dd($user);
            //dd($groups);
            //$roles=$this->getRolesAsArray($user->getId(), $keycloak_api);

            // Use this to interact with an API on the users behalf
            //echo $token->getToken();
            //Roles '.implode('|',$roles).'
            return new Response(
                '<html><body>Usuario: '.$user->getName().'<br>
                    Token: '.$token->getToken().'
                    </body></html>');

        }

    } 

     /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction(Request $request, KeyCloakApiController $keycloak_api )
    {
        $user = $this->session->get('user');
        // logout de la sesion de KC
        $keycloak_api->logout($user->getId());

        // logout de la sesion de PHP
        //$this->get('security.token_storage')->setToken(null);
        //$request->getSession()->invalidate();

        return $this->redirect($this->generateUrl("homepage"));

    }

    protected function getRolesAsArray($userId,  KeyCloakApiController $keycloak_api){
        //$roles = $this->get('keycloak_api')->getRolesComposite($userId);
        $roles = $keycloak_api->getRolesComposite($userId);
    	
    	$datos = array();
    	foreach ($roles as $rol){
	    	$datos[] = "ROLE_" . $rol->name;
    	}
    	
    	return $datos; 
    }
}
