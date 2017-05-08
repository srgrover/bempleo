<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Formacion;
use AppBundle\Entity\Usuario;
use AppBundle\Form\Type\FormacionType;
use AppBundle\Form\Type\RegisterType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

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
     * @Route("/registro", name="registro")
     */
    public function registroAction() {
        return $this->redirectToRoute('registro_personal');
    }


    /**
     * @Route("/registro/datos-personales", name="registro_personal", methods={"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function RegistroPersonalAction(Request $request){
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

                return $this->redirectToRoute('registro_formacion', ['id' => $usuario->getId()]);
            }
            catch(Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
        }
        return $this->render(':usuario:registro_personal.html.twig', [
            'usuario' => $usuario,
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/registro/formacion/{id}", name="registro_formacion", methods={"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function RegistroFormacionAction(Request $request, Usuario $id){
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $formacion = new Formacion();
        $em->persist($formacion);

        $form = $this->createForm(FormacionType::class, $formacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('estado', 'Cambios guardados con éxito');
                //return $this->redirectToRoute('registro_complementaria');
            }
            catch(Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
        }
        return $this->render(':usuario:registro_formacion.html.twig', [
            'formacion' => $formacion,
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

    //Asignar nombre a formulario
//    public function acmeAction(){
//        $acme = new Acme();
//        $form = $this->get('form.factory')
//            ->createNamedBuilder(new AcmeType(), 'acme_form', $acme)
//            ->getForm();
//        $request = $this->getRequest();
//
//        if ($request->getMethod() == 'POST' && $request->request->has('acme_form')) {
//            $form->bindRequest($request);
//            if($form->isValid())
//            {
//                //do something
//            }
//        }
//        //return something
//    }
}
