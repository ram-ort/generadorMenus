<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\UsuarioType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


/**
 * @Route("/usuario")
 */
class UsuarioController extends AbstractController
{
    /**
     * @Route("/", name="usuario_usuarios", methods={"GET"})
     */
    public function index(): Response
    {
        $usuarios = $this->getDoctrine()
            ->getRepository(Usuario::class)
            ->findAll();

        return $this->render('usuario/usuarios.html.twig', [
            'usuarios' => $usuarios,
        ]);
    }

    /**
     * @Route("/new", name="usuario_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $usuario = new Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $e = $encoder->encodePassword($usuario, $usuario->getPassword());
            $usuario->setContrasenia($e);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($usuario);
            $entityManager->flush();

            return $this->redirectToRoute('usuario_usuarios');
        }

        return $this->render('usuario/new.html.twig', [
            'usuario' => $usuario,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="usuario_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Usuario $usuario, UserPasswordEncoderInterface $encoder): Response
    {
        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $e = $encoder->encodePassword($usuario, $usuario->getPassword());
            $usuario->setContrasenia($e);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($usuario);
            $entityManager->flush();

            return $this->redirectToRoute('usuario_usuarios');
        }
        return $this->render('usuario/edit.html.twig', [
            'usuario' => $usuario,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="usuario_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Usuario $usuario): Response
    {
        if ($this->isCsrfTokenValid('delete'.$usuario->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($usuario);
            $entityManager->flush();
        }

        return $this->redirectToRoute('usuario_usuarios');
    }
}
