<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Konekt\PdfInvoice\InvoicePrinter;
use App\Entity\SaskaitosFakturos;
use App\Entity\Klientai;
use App\Entity\Buhalteriai;

class InvoiceController extends AbstractController
{
    /**
     * @Route("/invoice", name="invoice")
     */
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $invoice = new InvoicePrinter();
        $saskaitaFaktura = new SaskaitosFakturos();

        $form = $this->createFormBuilder()
            ->add('vardas', TextType::class, array('attr' => array('class' => 'form-control'), 'required' => true))
            ->add('pavarde', TextType::class, array('attr' => array('class' => 'form-control'), 'required' => true))
            ->add(
                'imonesPavadinimas',
                TextType::class,
                array('attr' => array('class' => 'form-control'), 'required' => true)
            )
            ->add('adresas', TextType::class, array('attr' => array('class' => 'form-control'), 'required' => true))
            ->add(
                'miestasIrKodas',
                TextType::class,
                array('attr' => array('class' => 'form-control'), 'required' => true)
            )
            ->add(
                'uzsakymoNumeris',
                TextType::class,
                array('attr' => array('class' => 'form-control'), 'required' => true)
            )
            ->add('suma', TextType::class, array('attr' => array('class' => 'form-control'), 'required' => true))
            ->add(
                'save',
                SubmitType::class,
                array('label' => 'Pateikti', 'attr' => array('class' => 'btn btn-primary'))
            )
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $firstName = $form['vardas']->getData();
            $lastName = $form['pavarde']->getData();
            $company = $form['imonesPavadinimas']->getData();
            $address = $form['adresas']->getData();
            $city = $form['miestasIrKodas']->getData();
            $orderNumber = $form['uzsakymoNumeris']->getData();
            $total = $form['suma']->getData();

            $fullName = $firstName . " " . $lastName;
            $vat = $total * 0.21;
            $totalWithVat = $total + $vat;
            $invoiceNumber = "INV-";
            $invoiceNumber .= $orderNumber;
            $invoiceToPdf = $invoiceNumber.".pdf";

            $invoice->setColor("#007fff");      // pdf color scheme
            $invoice->setType("Sąskaita faktūra");    // Invoice Type
            $invoice->setReference($invoiceNumber);   // Reference
            $invoice->setDate(date('Y/m/d', time()));   //Billing Date
            $invoice->setDue(date('Y/m/d', strtotime('+3 months')));    // Due Date
            $invoice->setFrom(array("Ponas Direktorius", "UAB Pirketa", "Partizanų g. 67", "Kaunas , LT 123456"));
            $invoice->setTo(array($fullName, $company, $address, $city));

            $invoice->addItem("Įsigytos prekės", "", 1, $vat, $total, 0, $totalWithVat);

            $invoice->addTotal("Suma", $total);
            $invoice->addTotal("PVM 21%", $vat);
            $invoice->addTotal("Suma su PVM", $totalWithVat, true);

            $invoice->setFooternote("UAB Pirketa, 2021");
            $invoice->render($invoiceToPdf, 'D');

                return $this->render('accountant/invoiceGenerated.html.twig', array('invoice' => $invoice));
                /* I => Display on browser, D => Force Download, F => local path save, S => return document as string */

        }

        return $this->render('accountant/invoice.html.twig', array('formInvoice' => $form->createView()));
    }

}
