<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use AppBundle\Form\Type\RegisterType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class UsuarioController extends Controller
{
    /**
     * @Route("/entrar", name="entrar")
     */
    public function LoginAction(){
        $helper = $this->get('security.authentication_utils');

        return $this->render(':usuario:login.html.twig', [
            'ultimo_usuario' => $helper->getLastUsername(),
            'error' => $helper->getLastAuthenticationError()
        ]);
    }


    /**
     * @Route("/comprobar", name="comprobar")
     * @Route("/salir", name="salir")
     */
    public function comprobarAction() {
    }


    /**
     * @Route("/registro", name="registro", methods={"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function RegistroAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $usuario = new Usuario();
        $em->persist($usuario);

        $form = $this->createForm(RegisterType::class, $usuario);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('estado', 'Cambios guardados con éxito');
                //return $this->redirectToRoute('listar_alumnado');
            }
            catch(Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
        }
        return $this->render(':usuario:registro.html.twig', [
            'usuario' => $usuario,
            'formulario' => $form->createView()
        ]);
    }


    /**
     * @Route("/perfil", name="perfil")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cambiarPerfilAction(Request $request) {
        $usuario = $this->getUser();
        $form = $this->createForm(RegisterType::class, $usuario, [
            'es_admin' => $this->isGranted('ROLE_ADMIN')
        ]);
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            $claveFormulario = $form->get('nueva')->get('first')->getData();
            if ($claveFormulario) {
                $clave = $this->get('security.password_encoder')
                    ->encodePassword($usuario, $claveFormulario);
                $usuario->setClave($clave);
            }
            $this->getDoctrine()->getManager()->flush();
        }
        return $this->render('usuario/perfil.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
