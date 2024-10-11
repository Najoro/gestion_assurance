<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContractController extends AbstractController
{
    #[Route('/contract', name: 'contract_index')]
    public function index(): Response
    {
        return $this->render('contract/index.html.twig', [
            'controller_name' => 'ContractController',
        ]);
    }
}
