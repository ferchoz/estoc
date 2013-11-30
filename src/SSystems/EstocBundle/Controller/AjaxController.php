<?php

namespace SSystems\EstocBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AjaxController extends Controller
{
    /**
     * @Route("/ajax/",name="ajax")
     * @Template()
     */
    public function saeazaAction()
    {
        return array();
    }

    /**
     * @Route("/ajax/add-to-kart/{id}",name="clientAddToKart")
     * @Template()
     */
    public function clientAddToKartAction($id)
    {
        if( $this->getSecurityContext()->isGranted('ROLE_CLIENT') ){
            $this->addToSessionKart($id);
            $this->get('session')->getFlashBag()->add('success-notification','Se añadio correctamente su item');
            $response = 'true';
        } else {
            $this->get('session')->getFlashBag()->add('error-notification','Debe estar logueado como cliente para poder añadir items');
            $response = 'false';
        }

        return new Response($response);
    }

    /**
     * @Route("/client/remove-from-kart/",name="clientRemoveFromKart")
     * @Template()
     */
    public function clientRemoveFromKartAction(Request $request)
    {
        $id = $request->request->get('id');
        $this->removeFroSessionKart($id);

        return new Response('true');
    }

    /**
     * @Route("/ajax/getSizePrice",name="getSizePrice")
     * @Template()
     */
    public function getSizePriceAction(Request $request)
    {
        $id = $request->request->get('id');
        $imageSize = $this->getDoctrine()->getRepository('EstocBundle:ImageSize')->find($id);

        $response['response'] = 'true';
        $response['price'] = $imageSize->getPrice();
        return new Response($imageSize->getPrice());
    }
}