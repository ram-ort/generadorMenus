<?php

namespace App\Controller;

use App\Entity\Plato;
use App\Form\PlatoType;
use App\Form\NuevomenuType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @Route("/plato")
 */
class PlatoController extends AbstractController
{

    /**
     * @Route("/", name="plato_listado", methods={"GET"})
     */
    public function index(): Response
    {
        $platos = $this->getDoctrine()
            ->getRepository(Plato::class)
            ->findAll();

        return $this->render('plato/listado.html.twig', [
            'platos' => $platos,
        ]);
    }

    /**
     * @Route("/new", name="plato_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $plato = new Plato();
        $form = $this->createForm(PlatoType::class, $plato);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plato = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($plato);
            $entityManager->flush();

            return $this->redirectToRoute('plato_listado');
        }

        return $this->render('plato/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="plato_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Plato $plato): Response
    {
        $form = $this->createForm(PlatoType::class, $plato);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('plato_listado');
        }

        return $this->render('plato/edit.html.twig', [
            'plato' => $plato,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="plato_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Plato $plato): Response
    {
        if ($this->isCsrfTokenValid('delete'.$plato->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($plato);
            $entityManager->flush();
        }

        return $this->redirectToRoute('plato_listado');
    }

    /**
     * @Route("/nuevoMenu", name="plato_nuevoMenu", methods={"GET","POST"})
     */
    public function nuevoMenu(Request $request): Response
    {
        $desayunos = $this->getDoctrine()
            ->getRepository(Plato::class)
            ->findBy(
                ['tipo' => '1'],
            );
        $comidas = $this->getDoctrine()
            ->getRepository(Plato::class)
            ->findBy(
                ['tipo' => ['2', '4']],
            );
        $cenas = $this->getDoctrine()
            ->getRepository(Plato::class)
            ->findBy(
                ['tipo' => ['3', '4']],
            );

        

        return $this->render('plato/nuevoMenu.html.twig', [
            'desayunos' => $desayunos,
            'comidas' => $comidas,
            'cenas' => $cenas,
        ]);
    }

    /**
     * @Route("/nuevoMenu2", name="plato_nuevoMenu2", methods={"GET","POST"})
     */
    public function nuevoMenu2(Request $request): Response
    {
        $desayunos = $this->getDoctrine()
            ->getRepository(Plato::class)
            ->findBy(
                ['tipo' => '1'],
            );
        $comidas = $this->getDoctrine()
            ->getRepository(Plato::class)
            ->findBy(
                ['tipo' => ['2', '4']],
            );
        $cenas = $this->getDoctrine()
            ->getRepository(Plato::class)
            ->findBy(
                ['tipo' => ['3', '4']],
            );
        
        $plato = new Plato();
        $form = $this->createForm(NuevomenuType::class, $plato);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plato = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($plato);
            $entityManager->flush();

            return $this->redirectToRoute('plato_nuevoMenu2');
        }

        return $this->render('plato/nuevoMenu2.html.twig', [
            'form' => $form->createView(),
            'desayunos' => $desayunos,
            'comidas' => $comidas,
            'cenas' => $cenas,
        ]);
    }

    /**
     * @Route("/menuGenerado", name="plato_menuGenerado", methods={"GET"})
     */
    public function downloadPdf()
    {
        $desayunoMenu = $this->getDoctrine()
            ->getRepository(Plato::class)
            ->findBy(
                ['tipo' => '1'],
            );
        $comidaMenu = $this->getDoctrine()
            ->getRepository(Plato::class)
            ->findBy(
                ['tipo' => ['2', '4']],
            );
        $cenaMenu = $this->getDoctrine()
            ->getRepository(Plato::class)
            ->findBy(
                ['tipo' => ['3', '4']],
            );

        //Configure Dompdf.
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);
        $html = $this->renderView('plato/menuGenerado.html.twig', [
            'title' => "Descargar menú del día",
            'desayunoMenu' => $desayunoMenu,
            'comidaMenu' => $comidaMenu,
            'cenaMenu' => $cenaMenu,

        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        //Output the generated PDF to Browser (force download)
        $dompdf->stream("MenuDelDia.pdf", [
            "Attachment" => 1,
        ]);
        return new Response("El PDF ha sido generado con éxito");
    }
    

}
