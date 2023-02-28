<?php

namespace App\Controller;

use App\Entity\Item;
use App\Form\ItemType;
use App\Entity\Client;
use App\Repository\ClientRepository;
use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/item')]
#[IsGranted('ROLE_USER')]
class ItemController extends AbstractController
{
    #[Route('/', name: 'app_item_index', methods: ['GET'])]
    public function index(ItemRepository $itemRepository): Response
    {
        // if ($this->getUser()) {
        //     $user = $this->getUser()->getId();
        //     return $this->render('item/index.html.twig', [
        //         'items' => $itemRepository->findByUser($this->getUser()->getId()),
        //     ]);
        // } else {
        //     return $this->redirectToRoute('app_home');
        // }
        $user = $this->getUser()->getId();
        return $this->render('item/index.html.twig', [
                'items' => $itemRepository->findByUser($user)]);
    }

    #[Route('/new', name: 'app_item_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ItemRepository $itemRepository, ClientRepository $clientRepository): Response
    {
        $item = new Item();
        $form = $this->createForm(ItemType::class, $item 
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $client = $clientRepository->find($this->getUser()->getId());
            $item->setClient($client);
            $clientRepository->save($client, true);
            $itemRepository->save($item, true);

            return $this->redirectToRoute('app_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('item/new.html.twig', [
            'item' => $item,
            'form' => $form,
        ]);
    }

    // #[Route('/{id}', name: 'app_item_show', methods: ['GET'])]
    // public function show(Item $item): Response
    // {
    //     return $this->render('item/show.html.twig', [
    //         'item' => $item,
    //     ]);
    // }

    #[Route('/{id}/edit', name: 'app_item_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Item $item, ItemRepository $itemRepository): Response
    {
        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $itemRepository->save($item, true);

            return $this->redirectToRoute('app_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('item/edit.html.twig', [
            'item' => $item,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_item_delete', methods: ['POST'])]
    public function delete(Request $request, Item $item, ItemRepository $itemRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$item->getId(), $request->request->get('_token'))) {
            $itemRepository->remove($item, true);
        }

        return $this->redirectToRoute('app_item_index', [], Response::HTTP_SEE_OTHER);
    }
}
