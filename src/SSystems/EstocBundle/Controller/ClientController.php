<?php

namespace SSystems\EstocBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SSystems\EstocBundle\Entity\SpecialOrder;
use SSystems\EstocBundle\Form\Client\ClientFullProfileType;
use SSystems\EstocBundle\Form\Purchase\PurchaseType;
use SSystems\EstocBundle\Form\SpecialOrderType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ClientController extends Controller
{
    /**
     * @Route("/client/",name="clientHome")
     * @Template()
     */
    public function clientHomeAction()
    {
        return array();
    }

    /**
     * @Route("/client/kart",name="clientKart")
     * @Template()
     */
    public function clientKartAction(Request $request)
    {
        $purchase = $this->getKartPurchase();
        $form = $this->createForm(new PurchaseType(),$purchase);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $purchase->setUser($this->getUser());
            $this->calculatePrices($purchase);

            $em = $this->getDoctrine()->getManager();
            $em->persist($purchase);
            $em->flush();

            $this->emptyClientKart();

            $this->get('session')->getFlashBag()->add('success-notification','Se realizó la compra correctamente');
            return $this->redirect($this->generateUrl('clientHome'));
        }

        return array(
            'form'  => $form->createView(),
        );
    }

    /**
     * @Route("/client/personal-data",name="clientPersonalDetail")
     * @Template()
     */
    public function personalDetailAction(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(new ClientFullProfileType(),$user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $userManager = $this->get('fos_user.user_manager');
            try{
                $userManager->updateUser($user);
                $this->get('session')->getFlashBag()->add('success-notification','Se guardaron correctamente sus datos');
            }catch (\Exception $e){
                $this->get('session')->getFlashBag()->add('error-notification','hubo un problema, intentelo de nuevo');
            }
        }

        return array(
            'form'  => $form->createView(),
        );
    }

    /**
     * @Route("/client/special-order",name="specialOrder")
     * @Template()
     */
    public function specialOrderAction(Request $request)
    {
        $specialOrder = new SpecialOrder();
        $form = $this->createForm(new SpecialOrderType(),$specialOrder);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $specialOrder->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($specialOrder);
            try{
                $em->flush();
                $this->get('session')->getFlashBag()->add('success-notification','Su pedido se envio correctamente');
                return $this->redirect($this->generateUrl('clientHome'));
            }catch (\Exception $e){
                $this->get('session')->getFlashBag()->add('error-notification','hubo un problema, intentelo de nuevo');
            }
        }

        return array(
            'form'  => $form->createView(),
        );
    }

    /**
     * @Route("/client/download-images",name="downloadImages")
     * @Template()
     */
    public function downloadImagesAction()
    {
        $purchases = $this->getDoctrine()
            ->getRepository('EstocBundle:Purchase')
            ->findAllByClient($this->getUser());

        return array(
            'purchases' => $purchases,
        );
    }

    /**
     * @Route("/client/download-image-file/{imageName}",name="downloadImageFile")
     */
    public function downloadImageFileAction($imageName)
    {
        $basePath = $this->container->get('kernel')->getRootDir() . '/../web/';
        $downloadPath = $this->container->getParameter('image.download.path') . '/';

        $filename = $basePath . $downloadPath . $this->getUser()->getId() .'/'. $imageName;

        $response = new Response(file_get_contents($filename));
        $d = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $imageName);

        $response->headers->set('Content-Disposition', $d);
        return $response;
    }
}
