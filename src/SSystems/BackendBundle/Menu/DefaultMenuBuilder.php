<?php

namespace SSystems\BackendBundle\Menu;

use Admingenerator\GeneratorBundle\Menu\AdmingeneratorMenuBuilder;
use Knp\Menu\FactoryInterface;

class DefaultMenuBuilder extends AdmingeneratorMenuBuilder
{
    protected $translation_domain = 'Admin';

    public function adminMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttributes(array('id' => 'main_navigation', 'class' => 'nav'));

        $securityContext = $this->container->get('security.context');

        if ($securityContext->isGranted('ROLE_ADMIN')) {
            $this->addLinkRoute($menu,'Ventas','SSystems_BackendBundle_AdminPurchase_list');
            $this->addLinkRoute($menu,'Colaboradores','SSystems_BackendBundle_AdminCollaboratorProfile_list');
            $this->addLinkRoute($menu,'Compradores','SSystems_BackendBundle_AdminClientProfile_list');
            $this->addLinkRoute($menu,'Imagenes','SSystems_BackendBundle_AdminImages_list');
        }

        /*
                $overwrite = $this->addDropdown($menu, 'Replace this menu');
                $this->addLinkURI(
                    $overwrite,
                    'Create new menu builder',
                    'https://github.com/symfony2admingenerator/AdmingeneratorGeneratorBundle'
                    .'/blob/master/Resources/doc/cookbook/menu.md'
                )->setExtra('icon', 'icon-wrench');
        */
        return $menu;
    }
}