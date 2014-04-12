<?php

namespace SSystems\EstocBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SSystems\EstocBundle\Entity\Document;
use SSystems\EstocBundle\Form\ContractsFromUserType;
use SSystems\EstocBundle\Form\ImagesContractType;
use Symfony\Component\Config\Definition\Exception\Exception;
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
    public function collaboratorUploadAction()
    {
        return array();
    }

    /**
     * @Route("/collaborator/upload-old",name="collaboratorUploadOld")
     * @Template()
     */
    public function collaboratorUploadOldAction(Request $request)
    {
        die('not found');
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
        return array();
    }

    /**
     * @Route("/collaborator/upload-contracts",name="collaboratorUploadContracts")
     * @Template()
     */
    public function collaboratorUploadContractsAction()
    {
        $images = $this->getDoctrine()
            ->getRepository('EstocBundle:Document')
            ->findByUser($this->getUser()->getId());

        return array(
            'images' => $images,
        );
    }

    /**
     * @Route("/collaborator/upload-contract/{id}",name="collaboratorUploadContractImage")
     * @Template()
     */
    public function collaboratorUploadContractImageAction($id, Request $request)
    {
        $image = $this->getDoctrine()
            ->getRepository('EstocBundle:Document')
            ->find($id);

        $form = $this->createForm(new ImagesContractType(),$image);
        $form->handleRequest($request);

        if ($form->isValid()) {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->merge($image);
                $em->flush();

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
     * @Route("/collaborator/ajax-images",name="collaboratorImages")
     */
    public function collaboratorImagesAction(Request $request)
    {
        $avalancheService = $this->get('imagine.cache.path.resolver');
        $fileSystem = $this->get('knp_gaufrette.filesystem_map')->get('product_image_fs');

        if ($request->isMethod('POST')) {
            $image = new Document();
            $tags = (string) $request->request->get('images_tag');
            $image->setTag($tags);
            $file = $request->files->get('files');
            $file = array_shift($file);
            $image->setFile($file);
            $image->setUser($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();

            $tagManager = $this->getTagManager();
            if($image->getTag() != NULL ){
                $tags = $tagManager->loadOrCreateTags($tagManager->splitTagNames($image->getTag()));
                $tagManager->addTags($tags, $image);
                $tagManager->saveTagging($image);
            }

            $imgTmp = $fileSystem->get($image->getImageName());
            $file                   = array();
            $file['id']             = $image->getId();
            $file['name']           = $imgTmp->getName();
            $file['size']           = $imgTmp->getSize();
            $file['tags']           = $image->getTag();
            $file['thumbnailUrl']   = $avalancheService->getBrowserPath('uploads/files/'.$imgTmp->getName(), 'collaborator_upload_thumb');
            $file['deleteUrl']      = $this->generateUrl('collaboratorDeleteImage', array('id' => $image->getId()));
            $file['updateUrl']      = $this->generateUrl('collaboratorImageUpdateTag', array('id' => $image->getId()));
            $file['deleteType']     = 'DELETE';
            $images['files'][]      = $file;

        } else {
            $imagesArray = $this->getDoctrine()
                ->getRepository('EstocBundle:Document')
                ->findByUser($this->getUser()->getId());

            foreach ($imagesArray as $image) {
                $imgTmp = $fileSystem->get($image->getImageName());
                $file                   = array();
                $file['id']             = $image->getId();
                $file['name']           = $imgTmp->getName();
                $file['size']           = $imgTmp->getSize();
                $file['tags']           = $image->getTag();
                $file['thumbnailUrl']   = $avalancheService->getBrowserPath('uploads/files/'.$imgTmp->getName(), 'collaborator_upload_thumb');
                $file['deleteUrl']      = $this->generateUrl('collaboratorDeleteImage', array('id' => $image->getId()));
                $file['updateUrl']      = $this->generateUrl('collaboratorImageUpdateTag', array('id' => $image->getId()));
                $file['deleteType']     = 'DELETE';
                $images['files'][]      = $file;
            }
        }

        echo json_encode($images);die;
    }

    /**
     * @Route("/collaborator/image/{id}/delete",name="collaboratorDeleteImage")
     */
    public function collaboratorDeleteImageAction($id)
    {
        $image = $this->getDoctrine()
            ->getRepository('EstocBundle:Document')
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($image);
        $em->flush();

        $file[$image->getImageName()]   = true;
        $images['files'][]              = $file;
        echo(json_encode($images));die;
    }

    /**
     * @Route("/collaborator/image/{id}/update-tag",name="collaboratorImageUpdateTag")
     */
    public function collaboratorImageUpdateTagAction($id, Request $request)
    {
        $image = $this->getDoctrine()
            ->getRepository('EstocBundle:Document')
            ->find($id);

        $tagManager = $this->getTagManager();
        $status = false;
        $tag = (string) $request->get('tag');
        $tag = ($tag != '') ? $tag : null;

        $image->setTag($tag);

        if($image->getTag() != NULL ){
            $tags = $tagManager->loadOrCreateTags($tagManager->splitTagNames($image->getTag()));
            $tagManager->addTags($tags, $image);
            $tagManager->saveTagging($image);
            $status = true;
        }
        echo json_encode($status);die;
    }
}