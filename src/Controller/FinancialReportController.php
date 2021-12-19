<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Pardavejai;

class FinancialReportController extends AbstractController
{
    /**
     * @Route("/financial_report", name="financial_report")
     */

    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createFormBuilder()
            ->add('parduotuvesVieta', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add(
                'save',
                SubmitType::class,
                array('label' => 'Skaičiuoti', 'attr' => array('class' => 'btn btn-primary'))
            )
            ->getForm();

        $form->handleRequest($request);

        $repository = $doctrine->getRepository(Pardavejai::class);

        if ($form->isSubmitted() && $form->isValid()) {
            $shop = $form['parduotuvesVieta']->getData();

            $parduotuves = $repository->findBy(['parduotuvesVieta' => $shop]);

            $financialSum = 0;

            foreach ($parduotuves as $parduotuve)
            {
                $financialSum += $parduotuve->getMenesineApyvarta();
            }

            if (is_null($parduotuves)) {
                $this->addFlash("error", "Tokios parduotuvės nėra!");

                return $this->render(
                    'accountant/financialReport.html.twig',
                    array('formReport' => $form->createView())
                );
            } else {
                return $this->render(
                    'accountant/financialReport.html.twig',
                    array('formReport' => $form->createView(), 'parduotuves' => $parduotuves, 'apyvarta' => $financialSum)
                );
            }

        }

        return $this->render(
            'accountant/financialReport.html.twig',
            array('formReport' => $form->createView())
        );
    }
}
