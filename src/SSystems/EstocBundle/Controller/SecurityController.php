<?php

namespace SSystems\EstocBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Security\Core\SecurityContext;
//use SSystems\EstocBundle\Form\LoginFormType;
use SSystems\EstocBundle\Form\RegisterCollaboratorFormType;
use SSystems\EstocBundle\Form\RegisterClientFormType;
use SSystems\EstocBundle\Entity\User;

class SecurityController extends Controller
{
    /**
     * @Route("/collaborator/login",name="collaboratorLogin")
     * @Template()
     */
    public function collaboratorLoginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        // get the login error if there is one
        $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
        $session->remove(SecurityContext::AUTHENTICATION_ERROR);

        return array(
            // last username entered by the user
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        );

    }

    /**
     * @Route("/collaborator/register",name="collaboratorRegister")
     * @Template()
     */
    public function collaboratorRegisterAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(new RegisterCollaboratorFormType(),$user,array(
            'action' => $this->generateUrl('collaboratorRegister'),
        ));

        $form->handleRequest($request);
        if ($form->isValid()) {
            $user->setEnabled(true);
            $user->addRole('ROLE_COLLABORATOR');
            $userManager = $this->get('fos_user.user_manager');

            try{
                $userManager->updateUser($user);
                $this->get('session')->getFlashBag()->add('success-notification','Se Registro correctamente');
            }catch (\Exception $e){
                $this->get('session')->getFlashBag()->add('error-notification','hubo un problema, intentelo de nuevo');
            }

            return $this->redirect($this->generateUrl('collaboratorHome'));
        }
        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/client/login",name="clientLogin")
     * @Template()
     */
    public function clientLoginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        // get the login error if there is one
        $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
        $session->remove(SecurityContext::AUTHENTICATION_ERROR);

        return array(
            // last username entered by the user
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        );

    }

    /**
     * @Route("/client/register",name="clientRegister")
     * @Template()
     */
    public function clientRegisterAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(new RegisterClientFormType(),$user,array(
            'action' => $this->generateUrl('clientRegister'),
        ));

        $form->handleRequest($request);
        if ($form->isValid()) {
            $user->setEnabled(true);
            $user->addRole('ROLE_CLIENT');
            $userManager = $this->get('fos_user.user_manager');

            try{
                $userManager->updateUser($user);
                $this->get('session')->getFlashBag()->add('success-notification','Se Registro correctamente');
            }catch (\Exception $e){
                $this->get('session')->getFlashBag()->add('error-notification','hubo un problema, intentelo de nuevo');
            }

            return $this->redirect($this->generateUrl('clientHome'));
        }
        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/collaborator/login_check", name="collaborator_login_check")
     * @Route("/client/login_check", name="client_login_check")
     */
    public function loginCheckAction()
    {
    }

    /**
     * @Route("/collaborator/logout", name="collaborator_logout")
     * @Route("/client/logout", name="client_logout")
     */
    public function logoutAction()
    {
    }

    /**
     * @Route("/admin/download/images/{id}",name="downloadImageFileAdmin")
     */
    public function downloadImageFileAction($id)
    {
        $basePath = $this->container->get('kernel')->getRootDir() . '/../web/uploads/files/';

        $image = $this->getDoctrine()->getRepository('EstocBundle:Document')->find($id);

        $filename = $basePath . $image->getImageName();

        $response = new Response(file_get_contents($filename));
        $d = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $image->getImageName());

        $response->headers->set('Content-Disposition', $d);
        return $response;
    }
}