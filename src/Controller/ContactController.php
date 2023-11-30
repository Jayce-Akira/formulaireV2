<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Event\FormSubmittedEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/', name: 'app_contact')]
    public function index(Request $request, EventDispatcherInterface $eventDispatcher): Response
    {
        $contactForm = $this->createForm(ContactType::class);
        $contactForm->handleRequest($request);

                
                

                if ($contactForm->isSubmitted() && $contactForm->isValid()) {
                    $formData = $contactForm->getData();
                    $event = new FormSubmittedEvent($formData);
        
                    // Déclenchez l'événement
                    $eventDispatcher->dispatch($event, 'form.submitted');
                   
        
                    $this->addFlash('success', 'Votre message a été envoyé avec succès.');
                    return $this->redirectToRoute('app_contact');
                } else {
                    $this->addFlash('warning', 'Votre message n\'a pas été envoyé !');
                    return $this->redirectToRoute('app_contact');
                }


        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'contactForm' => $contactForm->createView(),
        ]);
    }
}
