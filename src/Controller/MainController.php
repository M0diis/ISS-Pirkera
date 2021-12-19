<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Pardavejai;
use App\Entity\Buhalteriai;
use App\Entity\Sandelininkai;
use App\Entity\Vadovai;

class MainController extends AbstractController
{

    /**
     * @Route("/", name="login")
     */

    public function index(Request $request, ManagerRegistry $doctrine)
    {

        $form = $this->createFormBuilder()
            ->add('username', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('password', PasswordType::class, array('attr' => array('class' => 'form-control')))
            ->add(
                'save',
                SubmitType::class,
                array('label' => 'Prisijungti', 'attr' => array('class' => 'btn btn-primary'))
            )
            ->getForm();

        $form->handleRequest($request);

        $cashierRepo = $doctrine->getRepository(Pardavejai::class);
        $warehouseRepo = $doctrine->getRepository(Sandelininkai::class);
        $accountantRepo = $doctrine->getRepository(Buhalteriai::class);
        $bossRepo = $doctrine->getRepository(Vadovai::class);

        if ($form->isSubmitted() && $form->isValid()) {
            $username = $form['username']->getData();
            $password = $form['password']->getData();

            $pardavejas = $cashierRepo->findOneBy(['vartotojoVardas' => $username]);
            $sandelininkas = $warehouseRepo->findOneBy(['vartotojoVardas' => $username]);
            $buhalteris = $accountantRepo->findOneBy(['vartotojoVardas' => $username]);
            $vadovas = $bossRepo->findOneBy(['vartotojoVardas' => $username]);

            if (!is_null($pardavejas)) {
                return $this->render('');
            } else {
                if (!is_null($sandelininkas)) {
                    return $this->render('');
                } else {
                    if (!is_null($buhalteris)) {
                        return $this->render('accountant/baseAccountant.html.twig');
                    } else {
                        if (!is_null($vadovas)) {
                            return $this->render('');
                        } else {
                            $this->addFlash("notFound", "Toks vartotojas nerastas");

                            return $this->redirectToRoute('login');
                        }
                    }
                }
            }
        }

        return $this->render('main/main.html.twig', array('formLogin' => $form->createView()));
    }

}

?>
