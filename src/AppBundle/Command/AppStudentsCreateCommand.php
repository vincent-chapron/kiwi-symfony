<?php

namespace AppBundle\Command;

use AppBundle\Entity\Student;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class AppStudentsCreateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:students:create')
            ->setDescription('...')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $questions = $this->askQuestions([
            'email'         => 'email: ',
            'forenames'     => 'forenames: ',
            'lastname'      => 'lastname: ',
            'mobilePhone'   => 'mobile phone: ',
        ]);
        $answers = $this->getAnswers($input, $output, $questions);

        $student = new Student();
        $student->setForenames($answers["forenames"]);
        $student->setLastname($answers["lastname"]);
        $student->setEmail($answers["email"]);
        $student->setPhoneMobile($answers["mobilePhone"]);

        $studentManager = $this->getContainer()->get('student_manager');
        $studentManager->createStudent($student);
    }

    private function askQuestions($array) {
        $questions = [];
        foreach ($array as $name => $question) {
            $question = new Question($question);
            $question->setValidator(function($value) use ($name) {
                if (empty($value)) throw new \Exception($name . ' can not be empty');
                return $value;
            });
            $questions[$name] = $question;
        }
        return $questions;
    }

    private function getAnswers(&$input, &$output, $questions) {
        $answers = [];
        foreach ($questions as $name => $question) {
            $answer = $this->getHelper('question')->ask($input, $output, $question);
            $answers[$name] = $answer;
        }
        return $answers;
    }
}
