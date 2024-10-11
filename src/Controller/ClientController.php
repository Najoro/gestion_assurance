<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Form\ClientFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

// #[IsGranted('ROLE_USER' , "Veillez d'abord vous connectez")]
class ClientController extends AbstractController
{

    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/', name: 'client_index')]
    public function index(): Response
    {   
        $clientReps = $this->em->getRepository(Clients::class);
        $clients = $clientReps->findAll();

        return $this->render('client/index.html.twig', [
            'clients' => $clients,
        ]);
    }

    #[Route('/client/new', name: 'client_new')]
    public function newClient(): Response
    {
        $client = new Clients();
        $form = $this->createForm(ClientFormType::class, $client, [
            'action' => $this->generateUrl("client_valide"),
        ]);
        return $this->render('client/client-new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/client/new/valide', name: 'client_valide')]
    public function ValideNewClient(Request $request): Response
    {
        $client = new Clients();
        $form = $this->createForm(ClientFormType::class, $client, [
            'action' => $this->generateUrl("client_valide"),
        ]);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $this->em->persist($client);
            $this->em->flush();

            $this->addFlash(
               'success',
               'Une Nouvelle Client est initier'
            );
            return $this->redirectToRoute('client_index');
        }
        return $this->render('client/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/client/edit/{id}', name: 'client_edit')]
    public function ClientEdit(Clients $client): Response
    {
        $form = $this->createForm(ClientFormType::class, $client, [
            'action' => $this->generateUrl("client_update", ['id' => $client->getId()]),
        ]);
        
        return $this->render('client/client-edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/client/edit/{id}/update', name: 'client_update')]
    public function ClientUpdate(Clients $client, Request $request): Response
    {
        $form = $this->createForm(ClientFormType::class, $client, [
            'action' => $this->generateUrl("client_update", ['id' => $client->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { 
            $this->em->persist($client);
            $this->em->flush();

            $this->addFlash(
               'success',
               'Une Nouvelle Client est initier'
            );
            return $this->redirectToRoute('client_index');
        }

        return $this->render('client/client-edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/client/delete/{id}', name: 'client_delete')]
    public function ClientDelete(Clients $client,Request $request): Response
    {
        $status = false;
        $fullName = $request->get('fullName');
        try{
            $status = true;
            $this->em->remove($client);
            $this->em->flush();
            $this->addFlash(
                'success',
                "$fullName est Bien supprimer"
             );
        }catch(\Exception $e){
            $status = false;
        }
        
        return new JsonResponse([
         'status' => $status,
        ]);
    }

}
