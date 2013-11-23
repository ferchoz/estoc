<?php

namespace SSystems\EstocBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

class EstocExtension extends \Twig_Extension
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('price', array($this, 'priceFilter')),
            new \Twig_SimpleFilter('priceCollaborator', array($this, 'priceCollaborator')),
        );
    }

    public function priceFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = '$'.$price;

        return $price;
    }

    public function priceCollaborator($price)
    {
        $number = $price*$this->container->getParameter('adjust.priceCollaborator');
        return $this->priceFilter($number);
    }

    public function getName()
    {
        return 'Estoc';
    }
}

?>
