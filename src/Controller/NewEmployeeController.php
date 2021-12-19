<?php


namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Pardavejai;


class NewEmployeeController extends AbstractController
{
    /**
     * @Route("/new_employee", name="new_employee")
     */

    public function index(Request $request): Response
    {
        $employee = new Pardavejai();

        $form = $this->createFormBuilder($employee)
            ->add('vardas', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('pavarde', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('bankoSaskaita', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add(
                'save',
                SubmitType::class,
                array('label' => 'Pateikti', 'attr' => array('class' => 'btn btn-primary'))
            )
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $name = $form['vardas']->getData();
            $surname = $form['pavarde']->getData();
            $bank = $form['bankoSaskaita']->getData();

            $employee->setMenesineApyvarta('0');
            $employee->setParduotuvesVieta('Kaunas');
            $employee->setKasa('1');
            $employee->setVardas($name);
            $employee->setPavarde($surname);
            $nickname = substr($name, 0, 3);
            $nickname = strtolower($nickname);
            $nicknameLast = substr($surname, 0, 3);
            $nicknameLast = strtolower($nicknameLast);
            $nickname .= $nicknameLast;
            $employee->setVartotojoVardas($nickname);
            $employee->setBankoSaskaita($bank);
            $employee->setDarboLaikas('8-17');
            $employee->setVirsvalandziuSkaicius('0');
            $employee->setAtlyginimas('1000');


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($employee);
            $entityManager->flush();

            $this->addFlash("success", "Darbuotojas sėkmingai sukurtas!");

            return $this->redirectToRoute('new_employee');
        }

        return $this->render('accountant/newEmployee.html.twig', array('formEmployee' => $form->createView()));
    }
}
