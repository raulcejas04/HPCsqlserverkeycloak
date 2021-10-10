<?php
namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\RedirectResponse;

class KeycloakController extends AbstractController
{
    /**
     * Link to this controller to start the "connect" process
     * @param ClientRegistry $clientRegistry
     *
     * @Route("/connect/keycloak", name="connect_keycloak_start")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function connectKeycloakAction(ClientRegistry $clientRegistry)
    {
        //dd($clientRegistry->getClient('keycloak_main'));
        return $clientRegistry
            // ID used in config/packages/knpu_oauth2_client.yaml
            ->getClient('keycloak_main')
            // Request access to scopes
            // https://github.com/thephpleague/oauth2-github
            ->redirect(
               //['user:email']
            )
        ;
    }

    /**
     * After going to Github, you're redirected back here
     * because this is the "redirect_route" you configured
     * in config/packages/knpu_oauth2_client.yaml
     *
     * @param Request $request
     * @param ClientRegistry $clientRegistry
     *
     * @Route("/connect/keycloak/check", name="connect_keycloak_check")
     */
    /* return \Symfony\Component\HttpFoundation\RedirectResponse*/
    public function connectKeycloakCheckAction(Request $request, ClientRegistry $clientRegistry)
    {
        //dd($clientRegistry->getClient('keycloak_main'));   
        //dd( "connectkeycloakCheck");
	
	$client=$clientRegistry->getClient('keycloak_main');
   
	//try {
            // the exact class depends on which provider you're using
        //    /** @var \League\OAuth2\Client\Provider\FacebookUser $user */
        //    $user = $client->fetchUser();

            // do something with all this new power!
	    // e.g. $name = $user->getFirstName();

        //    var_dump($user); die;

            // ...
        //} catch (IdentityProviderException $e) {
            // something went wrong!
            // probably you should return the reason to the user
            
	//    var_dump($e->getMessage()); die;
        //}

	$response = new RedirectResponse($this->generateUrl('usuario_list'));
	$response->send();

        //return $this->redirectToRoute('usuario_list');
    }
}
?>
