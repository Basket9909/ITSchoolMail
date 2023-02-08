<?php

namespace App\Controller;

use App\Entity\Mail;
use App\Form\MailType;
use Symfony\Component\Mime\Email;
use App\Repository\MailRepository;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $request, EntityManagerInterface $manager, MailerInterface $mailer): Response
    {

        $mail = new Mail();
        $form = $this->createForm(MailType::class, $mail);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $mail = $form->getData();

            $manager->persist($mail);
            $manager->flush();

            //Email
                $email = (new Email())
                ->from($mail->getSender())
                ->to($mail->getRecipient())
                ->subject($mail->getObject())
                ->html($mail->getContent());

                $mailer->send($email);

            $this->addFlash(
                'success',
                'Le mail à été envoyé avec succès !'
            );
            return $this->redirectToRoute('home');
        };

        return $this->render('home.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route("/mails", name : "all_mails")]
    #[IsGranted('ROLE_USER')]
    // #[IsGranted('ROLE_ADMIN')]
    public function mails(MailRepository $repo): Response
    {
       $mails = $repo->findAll();

        return $this->render('mails/showall.html.twig', [
            'mails' => $mails
        ]);
    }


    #[Route("/mail/{id}", name : "show_mail")]
    #[IsGranted('ROLE_USER')]
    // #[IsGranted('ROLE_ADMIN')]
    public function showMails(MailRepository $repo, $id, Mail $mail): Response
    {

        return $this->render('mails/show.html.twig', [
            'mail' => $mail
        ]);
    }
}
