<?php

namespace App\Controller;

use App\Entity\Tuto;
use App\Repository\TutoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TutoController extends AbstractController
{
    #[Route('/tuto/{id}', name: 'app_tuto')]
    public function index(TutoRepository $tutoRepository, int $id): Response
    {
        $tuto = $tutoRepository->findOneById($id);
        
        if (!$tuto) {
            throw $this->createNotFoundException(
                'No tuto found for id '.$id
            );
        }

        return $this->render('tuto/index.html.twig', [
            'controller_name' => 'TutoController',
            'name' => $tuto->getName()
        ]);
    }

    #[Route('/add-tuto', name: 'create_tuto')]
    public function createTuto(EntityManagerInterface $entityManager): Response
    {
        $tuto = new Tuto();
        $tuto->setName('Unity');
        $tuto->setVideo('B6eqb-1IoQw');
        $tuto->setSubtitle('sous titre de dingue');
        $tuto->setSlug('tuto-unity');
        $tuto->setLink('https://www.formation-facile.fr/formations/formation-unity-et-c-developpeur-de-jeux-video');
        $tuto->setImage('unity.png');
        $tuto->setDescription('Super description !');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($tuto);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$tuto->getId());
    }
}
