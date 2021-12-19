<?php

namespace App\Controller;

use App\Entity\Pardavejai;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Prekes;
use App\Entity\Sandeliai;
use App\Entity\Buhalteriai;

class NewItemController extends AbstractController
{
    /**
     * @Route("/new_item", name="new_item")
     */

    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $item = new Prekes();

        $form = $this->createFormBuilder($item)
            ->add('kaina', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('pavadinimas', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add(
                'save',
                SubmitType::class,
                array('label' => 'Pateikti', 'attr' => array('class' => 'btn btn-primary'))
            )
            ->getForm();

        $form->handleRequest($request);

        $repository = $doctrine->getRepository(Sandeliai::class);

        $repositoryAccountant = $doctrine->getRepository(Buhalteriai::class);

        if($form->isSubmitted() && $form->isValid())
        {
            $price = $form['kaina']->getData();
            $name = $form['pavadinimas']->getData();

            $priceFloat = floatval($price);

            $sandelioId = $repository->findOneBy(['idSandelis' => '1']);

            $buhalterioId = $repositoryAccountant->findOneBy(['idNaudotojas' => '1']);

            $item->setKiekis('0');
            $item->setKaina($priceFloat);
            $item->setPavadinimas($name);
            $item->setFkSandelisidSandelis($sandelioId);
            $item->setFkBuhalterisidNaudotojas($buhalterioId);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($item);
            $entityManager->flush();

            $this->addFlash("successItem", "Nauja prekė sėkmingai sukurta!");

            return $this->redirectToRoute('new_item');
        }

        return $this->render('accountant/newItem.html.twig', array('formItem' => $form->createView()));
    }
}
