<?php

namespace SSystems\EstocBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use SSystems\EstocBundle\Form\UserType;
use SSystems\EstocBundle\Form\Collaborator\CollaboratorFullProfileType;

class CollaboratorController extends Controller
{
    /**
     * @Route("/collaborator/",name="collaboratorHome")
     * @Template()
     */
    public function collaboratorHomeAction()
    {
        return array();
    }

    /**
     * @Route("/collaborator/upload",name="collaboratorUpload")
     * @Template()
     */
    public function collaboratorUploadAction(Request $request)
    {
        $user = $this->getDoctrine()
            ->getRepository('EstocBundle:User')
            ->findUserWithImage($this->getUser()->getId());
        $form = $this->createForm(new UserType(),$user);

        $form->handleRequest($request);

        if($form->isValid()){
            $tagManager = $this->getTagManager();

            foreach ($user->getImages() as $image) {
                if($image->getTag() != NULL ){
                    $tags = $tagManager->loadOrCreateTags($tagManager->splitTagNames($image->getTag()));
                    $tagManager->addTags($tags, $image);
                    $tagManager->saveTagging($image);
                }
            }

            try{
                $this->getUserManager()->updateUser($user);
                $this->get('session')->getFlashBag()->add('success-notification','Se guardaron correctamente sus datos');
            }catch (\Exception $e){
                $this->get('session')->getFlashBag()->add('error-notification','hubo un problema, intentelo de nuevo');
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/collaborator/account",name="collaboratorAccount")
     * @Template()
     */
    public function collaboratorAccountAction()
    {
        $purchaseDetails = $this->getDoctrine()
            ->getRepository('EstocBundle:PurchaseDetail')
            ->findAllOrderedByName($this->getUser());

        $images = $this->getDoctrine()
            ->getRepository('EstocBundle:Document')
            ->findBy(array('user' => $this->getUser()));

        $cant_images = count($images);
        $cant_purchases = count($purchaseDetails);
        $amount = 0;
        foreach ($purchaseDetails as $purchaseDetail) {
            $amount += $purchaseDetail->getImageSize()->getPrice();
            if ($purchaseDetail->getExclusive()) {
                $amount += $this->container->getParameter('price.exclusive');
            }
        }
        $amount = $this->pluIVA($amount);

        return array(
            'images'          => $images,
            'cant_images'     => $cant_images,
            'cant_purchases'  => $cant_purchases,
            'amount'          => $this->setDiscount($amount),
        );
    }

    /**
     * @Route("/collaborator/personal-data",name="collaboratorPersonalDetail")
     * @Template()
     */
    public function personalDetailAction(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(new CollaboratorFullProfileType(),$user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            try{
                $this->getUserManager()->updateUser($user);
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
     * @Route("/collaborator/download",name="collaboratorDownload")
     * @Template()
     */
    public function downloadAction(Request $request)
    {

        return array(
        );
    }

}