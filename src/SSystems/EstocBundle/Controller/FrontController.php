<?php

namespace SSystems\EstocBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
//form
use SSystems\EstocBundle\Form\ContactUsType;
use SSystems\EstocBundle\Form\MainSearchBoxType;
//entity
use SSystems\EstocBundle\Entity\ContactUs;

class FrontController extends Controller
{
    /**
     * @Route("/",name="home")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/main",name="main")
     * @Template()
     */
    public function mainAction(Request $request)
    {
        $form = $this->createForm(new MainSearchBoxType());
        $form->handleRequest($request);
        if($form->isValid()){
            $data = $form->getData();

            if(isset($data['search'])){
                $data_search[] = $data['search'];
                $images = $this->getRelatedImages($data_search);
            }else{
                $images = $this->getDoctrine()->getRepository('EstocBundle:Document')->findAll();
            }

        }else{
            $images = $this->getDoctrine()->getRepository('EstocBundle:Document')->findAll();
        }

        return array(
            'form' => $form->createView(),
            'images' => $images,
        );
    }

    /**
     * @Route("/photo-detail/{id}",name="photoDetail")
     * @Template()
     */
    public function photoDetailAction($id)
    {
        $image = $this->getDoctrine()->getRepository('EstocBundle:Document')->find($id);

        $this->getTagManager()->loadTagging($image);

        $related_tags = $this->getRelatedImagesWithMaxResult($image,6);

        $ids = array();
        foreach ($related_tags as $imagen) {
            $ids[] = $imagen['resourceId'];
        }

        $related_images = $this->getDoctrine()->getRepository('EstocBundle:Document')->findImagesByIds($ids);

        return array(
            'image' => $image,
            'related_images' => $related_images,
        );
    }

    /**
     * @Route("/terms",name="terms")
     * @Template()
     */
    public function termsAction()
    {
        return array();
    }

    public function searchBoxAction(){
        $form = $this->createForm(new MainSearchBoxType());

        return $this->render(
            'EstocBundle:Front/include:search-bar.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/about-us",name="aboutUs")
     * @Template()
     */
    public function aboutUsAction()
    {
        return array();
    }

    /**
     * @Route("/contact-us",name="contactUs")
     * @Template()
     */
    public function contactUsAction(Request $request)
    {
        $contactUs = new ContactUs;
        $form = $this->createForm(new ContactUsType(), $contactUs);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contactUs);
            try{
                $em->flush();
                $this->get('session')->getFlashBag()->add('success-notification','Su Mensaje se envio correctamente');
            }catch (\Exception $e){
                $this->get('session')->getFlashBag()->add('error-notification','hubo un problema, intentelo de nuevo');
            }
        }

        return array(
            'form'  => $form->createView(),
        );
    }

    /**
     * @Route("/testing",name="testing")
     * @Template()
     */
    public function testingAction()
    {
        $doctrine = $this->getDoctrine();

        $em = $doctrine->getManager();

        $qb = $em->createQueryBuilder()
            ->select('p','pd','pdi','imgsz')
            ->from('EstocBundle:Purchase','p')
            ->join('p.purchaseDetails','pd')
            ->join('pd.image','pdi')
            ->join('pd.imageSize','imgsz')
            ->where('p.charge = true')
            ->andWhere('p.processed =false')
        ;

        $purchases = $qb->getQuery()->getResult();

        $basePath = $this->get('kernel')->getRootDir()
            . '/../web'
            . $this->getRequest()->getBasePath();

        $uploadPath = $this->container->getParameter('image.upload.path') . '/';

        $downloadPath = $this->container->getParameter('image.download.path') . '/';

        foreach ($purchases as $purchase) {
            foreach ($purchase->getPurchaseDetails() as $purchaseDetail) {

                $imageName = $purchaseDetail->getImage()->getImageName();
                $this->get('image.handling')->open($basePath . $uploadPath . $imageName)
                    ->resize(100, 100)
                    ->save($basePath . $downloadPath . $purchase->getUser()->getId() .'/'. $imageName);
            }
        }
        die('anda');
        return array();
    }
}
