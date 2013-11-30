<?php
namespace SSystems\BackendBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Gregwar\Image\Image;

class ImageConvertCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('imagen:convert')
            ->setDescription('Convierte imagenes compradas')
//            ->addArgument('name', InputArgument::OPTIONAL, 'Who do you want to greet?')
//            ->addOption('yell', null, InputOption::VALUE_NONE, 'If set, the task will yell in uppercase letters')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $doctrine = $this->getContainer()->get('doctrine');
        $em = $doctrine->getManager();

        $output->writeln(date('Y-m-d G:i:s', time()) .' - Procesando imagenes faltantes');

        $qb = $em->createQueryBuilder()
            ->select('p','pd','pdi','imgsz')
            ->from('EstocBundle:Purchase','p')
            ->join('p.purchaseDetails','pd')
            ->join('pd.image','pdi')
            ->join('pd.imageSize','imgsz')
            ->where('p.charge = true')
            ->andWhere('p.processed = false')
        ;

        $purchases = $qb->getQuery()->getResult();
        $basePath = $this->getContainer()->get('kernel')->getRootDir() . '/../web/';
        $uploadPath = $this->getContainer()->getParameter('image.upload.path') . '/';
        $downloadPath = $this->getContainer()->getParameter('image.download.path') . '/';

        foreach ($purchases as $purchase) {
            foreach ($purchase->getPurchaseDetails() as $purchaseDetail) {
                $imageName = $purchaseDetail->getImage()->getImageName();

                $image = $this->getContainer()
                    ->get('image.handling')
                    ->open($basePath . $uploadPath . $imageName);

                switch ($purchaseDetail->getImageSize()->getId()) {
                    case 1:
                        $image->cropResize(1024, 682);//$width, $height
                        break;
                    case 2:
                        $image->cropResize(17000, 1133);//$width, $height
                        break;
                    case 3:
                        $image->cropResize(3840, 2560);//$width, $height
                        break;
                    case 4:
                        $image->cropResize(5136, 3424);//$width, $height
                        break;
                    case 5:
                        break;
                }
                $image->save($basePath . $downloadPath . $purchase->getUser()->getId() .'/'. $imageName);
                $output->writeln('<info>'.$imageName.'</info>');
            }
            $purchase->setProcessed(true);
            $em->flush();
        }

    }
}