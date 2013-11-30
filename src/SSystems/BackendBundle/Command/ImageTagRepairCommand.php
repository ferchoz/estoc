<?php
namespace SSystems\BackendBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Gregwar\Image\Image;

class ImageTagRepairCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('imagen:tag:repair')
            ->setDescription('Repara tags de imagenes')
//            ->addArgument('name', InputArgument::OPTIONAL, 'Who do you want to greet?')
//            ->addOption('yell', null, InputOption::VALUE_NONE, 'If set, the task will yell in uppercase letters')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $doctrine = $this->getContainer()->get('doctrine');
        $em = $doctrine->getManager();

        $output->writeln('<info>Procesando imagenes faltantes</info>');

        $qb = $em->createQueryBuilder()
            ->select('i')
            ->from('EstocBundle:Document','i')
        ;

        $images = $qb->getQuery()->getResult();

        if (!$images){
            $output->writeln('no se encontraron imagenes');
            die;
        }


        foreach ($images as $image) {
            if (preg_match('/\s/',$image->getTag())){
                $output->writeln($image->getTag());
                $image->setTag( str_replace(" ", ",", $image->getTag()) );
                $tagManager = $this->getContainer()->get('fpn_tag.tag_manager');
                $tags = $tagManager->loadOrCreateTags($tagManager->splitTagNames($image->getTag()));
                $tagManager->addTags($tags, $image);
                $tagManager->saveTagging($image);
                $em->flush();
            }
        }

    }
}