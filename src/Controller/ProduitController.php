<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProduitController extends AbstractController
{
    /**
     * @Route("/admin/produit/", name="produit_index", methods={"GET"})
     */
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }
    /**
     * @Route("/rest/produit/", name="rest_produit_index", methods={"GET"})
     */
    public function rest_index(ProduitRepository $produitRepository): Response
    {
        return $this->json($produitRepository->findAll());
    }
    /**
     * @Route("/admin/produit/new", name="produit_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/rest/produit/new", name="produit_new", methods={"GET", "POST"})
     */
    public function rest_new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = new Produit();
        //remplir
        $produit->setNameProduit($request->query->get('nom'));
        $produit->setMarqueProduit($request->query->get('marque'));
        $produit->setQuantityProduit($request->query->get('quantity'));
        $entityManager->persist($produit);
        $entityManager->flush();

        return $this->json(['status' => 200, 'message' => "Produit ajouté avec succés"]);
    }

    /**
     * @Route("/admin/produit/view/{id}", name="produit_show", methods={"GET"})
     */
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    /**
     * @Route("/rest/produit/view/{id}", name="rest_produit_show", methods={"GET"})
     */
    public function rest_show(Produit $produit): Response
    {
        return $this->json($produit);
    }

    /**
     * @Route("/admin/produit/edit/{id}", name="produit_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

        /**
     * @Route("/rest/produit/edit/{id}", name="produit_edit", methods={"GET", "POST"})
     */
    public function rest_edit(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        //remplir
        $produit->setNameProduit($request->query->get('nom'));
        $produit->setMarqueProduit($request->query->get('marque'));
        $produit->setQuantityProduit($request->query->get('quantity'));
        $entityManager->persist($produit);
        $entityManager->flush();

        return $this->json(['status' => 200, 'message' => "Produit modifié avec succés", 'data'=>$produit]);
    }

    /**
     * @Route("/admin/produit/delete/{id}", name="produit_delete", methods={"POST"})
     */
    public function delete(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $produit->getId(), $request->request->get('_token'))) {
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('produit_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/rest/produit/delete/{id}", name="rest_produit_delete", methods={"GET","POST"})
     */
    public function rest_delete(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        // $entityManager->$this->getdoctrine()->getManager();

        $entityManager->remove($produit);
        $entityManager->flush();

        return $this->json(['status' => 200, 'message' => "Produit supprimé avec succés"]);
    }
}
