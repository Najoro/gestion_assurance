<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('/user')]
class UserController extends AbstractController
{   

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/login', name: 'user_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUserName = $authenticationUtils->getLastUsername();
        return $this->render('user/login.html.twig', [
            'error' => $error,
            'last_user_name' => $lastUserName,
        ]);
    }

    #[Route('/user-registre', name: "user_registre")]
    public function registreUser() : Response
    {
        $user = new User();
        $form = $this->createForm(UserFormType::class , $user, [
            'action' => $this->generateUrl("user_registre_confirm")
        ]);
        return $this->render('user/registre.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user-registre-confirm', name: "user_registre_confirm")]
    public function confirmRegistrUser(Request $request, UserPasswordHasherInterface $userPasswordHasherInterface) : Response
    {
        $user = new User();
        $form = $this->createForm(UserFormType::class , $user, [
            'action' => $this->generateUrl("user_registre_confirm")
        ]);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {    
            $passwordHashed = $userPasswordHasherInterface->hashPassword(
                $user,
                $form->get('password')->getData()
            );
            $user->setPassword($passwordHashed);
            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash(
               'success',
               'Votre compte est bien enregistrer',
            );
            return $this->redirectToRoute('user_login');
        }

        return $this->render('user/registre.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    #[Route('/profile', name: "user_profile")]
    public function UserProfile() : Response
    {
        return $this->render('user/profile.html.twig');
    }

    #[Route('/logout', name: 'user_logout')]
    public function logout(): Response
    {
        return $this->redirectToRoute('user_login');
    }
    
}
