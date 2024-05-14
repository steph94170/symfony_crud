<?php

namespace App\Controller;

use DateTimeImmutable;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/', name: 'app_contact_index', methods: ['GET'])]
    public function index(ContactRepository $contactRepository): Response
    {
        $contacts = $contactRepository->findAll();

        return $this->render('pages/index.html.twig', [
            "contacts" => $contacts
        ]);
    }


    #[Route('/create', name: 'app_contact_create', methods: ['GET', 'POST'])]
    public function create( Request $resquest, EntityManagerInterface $entityManager) : Response
    {

        // dd($resquest);

        // 1-Créons l'instance du contact qui doit être ajouté en base de données
        $contact = new Contact();

        // 2- Créons le formulaire en se basant sur son type
        $form = $this->createForm(ContactType::class, $contact);


        // 4- Associer les données de la requete aux données du formulaire
        $form->handleRequest($resquest);

         // 5- Si le formulaire est soumis et que le forlmulaire est valide
         if ($form->isSubmitted() && $form->isValid())
         {

            $contact->setCreatedAt(new DateTimeImmutable());
            $contact->setUpdatedAt(new DateTimeImmutable());

            // Demander au manager des entité de préparer la requête d'insertion du nouveau contact en base de données
            $entityManager->persist($contact);
            
            // Exécuter la requête
            $entityManager->flush();
            // De générer un message flash de succès
            // Effectuer une redirection vers la page d'accueil
           return $this->redirectToRoute("app_contact_index");
            // Afin de consulter le nouveau contact ajouté dans la liste
            // puis arreter l'éxecution du script
        }

        // 3- Passons la partie visible du formulaire à la page(vue) pour affichage
        return $this->render("pages/create.html.twig", [
            "form" => $form->createView()
        ]);
    }

    #[Route('/{id<\d+>}/edit', name: 'app_contact_edit', methods: ['GET', 'POST'])]
    public function edit(string $id, 
    ContactRepository $contactRepository,
    Request $request,
    EntityManagerInterface $em, 
     ): Response
    {
        // 1- Vérifions si le contact à modifier existe vraiment dans la base de données ou non
        $contact = $contactRepository->find($id);

        // 2- Si le contact n'est pas trouvé,
        if ( null === $contact ) 
        {
            // Effectuons une redirection vers la page d'accueil
                // Puis arrêtons l'exécution du script.
            return $this->redirectToRoute('app_contact_index');
        }


        // Dans le cas contraire,
        // 3- Générons le formulaire de modification du contact
        $form = $this->createForm(ContactType::class, $contact);

        
        // 5- Associer les données de la requête aux données du formulaire
        $form->handleRequest($request);


        // 6- Si le formulaire est soumis et que le formulaire est valide,
        if ( $form->isSubmitted() && $form->isValid() ) 
        {
            // Demander au manager des entités de préparer la requête de modification du contact en base de données
            // Exécuter la requête
            
            // Flash ------------------------------------------------------------------------------

            // Effectuer une redirection vers la page d'accueil
                // Puis errêter l'exécution du script.
        }

          

        // 4- Passons la partie visible du formulaire à la page (vue)
        return $this->render("pages/edit.html.twig", [
            "form" => $form->createView()
        ]);
    }

}