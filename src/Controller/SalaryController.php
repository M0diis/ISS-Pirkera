<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProductRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Pardavejai;

class SalaryController extends AbstractController
{
    /**
     * @Route ("/salary_calculate", name="salary_calculate")
     */

    public function index(): Response
    {
        return $this->render('accountant/salary.html.twig');
    }

    /**
     * @Route("/salary_calculate", name="salary_calculate")
     */

    public function salaryCalculate(ManagerRegistry $doctrine, Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('vardas', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('pavarde', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add(
                'save',
                SubmitType::class,
                array('label' => 'Apskaičiuoti', 'attr' => array('class' => 'btn btn-primary'))
            )
            ->getForm();

        $form->handleRequest($request);

        $repository = $doctrine->getRepository(Pardavejai::class);

        if ($form->isSubmitted() && $form->isValid()) {
            $name = $form['vardas']->getData();
            $surname = $form['pavarde']->getData();

            $pardavejai = $repository->findOneBy(
                [
                    'vardas' => $name,
                    'pavarde' => $surname,
                ]
            );

            if (is_null($pardavejai)) {
                $this->addFlash("error", "Tokio darbuotojo nėra!");

                return $this->render(
                    'accountant/salary.html.twig',
                    array('formSalary' => $form->createView())
                );
            } else {
                return $this->render(
                    'accountant/salary.html.twig',
                    array('formSalary' => $form->createView(), 'pardavejas' => $pardavejai)
                );
            }

        }

        return $this->render(
            'accountant/salary.html.twig',
            array('formSalary' => $form->createView())
        );
    }

}
