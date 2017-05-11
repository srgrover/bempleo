<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Fcomplementaria;
use AppBundle\Entity\Formacion;
use AppBundle\Entity\Idioma;
use AppBundle\Entity\Laboral;
use AppBundle\Entity\Usuario;
use AppBundle\Form\Type\FcomplementariaType;
use AppBundle\Form\Type\FormacionType;
use AppBundle\Form\Type\IdiomaType;
use AppBundle\Form\Type\LaboralType;
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
        if(is_object($this->getUser())){        //El usuario está logueado
            return $this->redirect('perfil');
        }

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
                $factory = $this->get("security.encoder_factory");
                $encoder = $factory->getEncoder($usuario);
                $password = $encoder->encodePassword($form->get("password")->getData(), $usuario->getSalt());
                $usuario->setPassword($password);

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
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function RegistroFormacionAction(Request $request, $id){
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $formacion = new Formacion();
        $formacion->setUsuario($id);
        $em->persist($formacion);

        $form = $this->createForm(FormacionType::class, $formacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('estado', 'Cambios guardados con éxito');
                return $this->redirectToRoute('registro_formacion_complementaria', ['id' => (int)$id]);
            }
            catch(Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
        }
        return $this->render(':usuario:registro_formacion.html.twig', [
            'formacion' => $formacion,
            'formulario' => $form->createView(),
        ]);
    }


    /**
     * @Route("/registro/formacion/complementaria/{id}", name="registro_formacion_complementaria", methods={"GET", "POST"})
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function RegistroComplementariaAction(Request $request, $id){
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $fcomplementaria = new Fcomplementaria();
        $fcomplementaria->setUsuario($id);
        $em->persist($fcomplementaria);

        $form = $this->createForm(FcomplementariaType::class, $fcomplementaria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('estado', 'Cambios guardados con éxito');
                return $this->redirectToRoute('registro_laboral', ['id' => $id]);
            }
            catch(Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
        }
        return $this->render(':usuario:registro_formacion_complementaria.html.twig', [
            'fcomplementaria' => $fcomplementaria,
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/registro/laboral/{id}", name="registro_laboral", methods={"GET", "POST"})
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function RegistroLaboralAction(Request $request, $id){
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $laboral = new Laboral();
        $laboral->setUsuario($id);
        $em->persist($laboral);

        $form = $this->createForm(LaboralType::class, $laboral);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('estado', 'Cambios guardados con éxito');
                return $this->redirectToRoute('registro_idiomas', ['id' => $id]);
            }
            catch(Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
        }
        return $this->render(':usuario:registro_laboral.html.twig', [
            'laboral' => $laboral,
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/registro/idiomas/{id}", name="registro_idiomas", methods={"GET", "POST"})
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function RegistroIdiomasAction(Request $request, $id){
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $idioma = new Idioma();
        $idioma->setUsuario($id);
        $em->persist($idioma);

        $form = $this->createForm(IdiomaType::class, $idioma);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('estado', 'Cambios guardados con éxito');
                return $this->redirectToRoute('registro_informatica', ['id' => $id]);
            }
            catch(Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
        }
        return $this->render(':usuario:registro_idiomas.html.twig', [
            'idioma' => $idioma,
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/registro/informatica/{id}", name="registro_informatica", methods={"GET", "POST"})
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function RegistroInformaticaAction(Request $request, $id){
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $informatica = new Fcomplementaria();
        $informatica->setUsuario($id);
        $em->persist($informatica);

        $form = $this->createForm(FcomplementariaType::class, $informatica);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('estado', 'Cambios guardados con éxito');
                return $this->redirectToRoute('entrar');
            }
            catch(Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
        }
        return $this->render(':usuario:registro_informatica.html.twig', [
            'informatica' => $informatica,
            'formulario' => $form->createView()
        ]);
    }


    /**
     * @Route("/perfil", name="perfil")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cambiarPerfilAction(Request $request) {
//        $usuario = $this->getUser();
//        $form = $this->createForm(RegisterType::class, $usuario, [
//            'admin' => $this->isGranted('ROLE_ADMIN')
//        ]);
//        $form->handleRequest($request);
//        if ($form->isValid() && $form->isSubmitted()) {
//            $claveFormulario = $form->get('nueva')->get('first')->getData();
//            if ($claveFormulario) {
//                $clave = $this->get('security.password_encoder')
//                    ->encodePassword($usuario, $claveFormulario);
//                $usuario->setClave($clave);
//            }
//            $this->getDoctrine()->getManager()->flush();
//        }
        return $this->render('usuario/perfil.html.twig', [
//            'form' => $form->createView()
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
