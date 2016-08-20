<?php

namespace AppBundle\Command;

use AppBundle\Entity\Student;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AppPresencesInitCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:presences:init')
            ->setDescription('initialise current status of student.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $studentManager = $this->getContainer()->get('student_manager');
        $students = $studentManager->getStudents();

        $progress = new ProgressBar($output, count($students));
        $progress->setBarWidth(50);
        $progress->setEmptyBarCharacter(' ');
        $progress->setBarCharacter('<fg=green>=</>');
        $progress->start();

        foreach ($students as $student) {
            /** @var Student $student */
            $studentManager->addPresence($student);
            $progress->advance();
        }

        $progress->finish();
        $output->write("\n");
    }
}
