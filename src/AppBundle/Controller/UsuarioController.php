<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Fcomplementaria;
use AppBundle\Entity\Formacion;
use AppBundle\Entity\Idioma;
use AppBundle\Entity\Informatica;
use AppBundle\Entity\Laboral;
use AppBundle\Entity\Usuario;
use AppBundle\Form\Type\FcomplementariaType;
use AppBundle\Form\Type\FormacionType;
use AppBundle\Form\Type\IdiomaType;
use AppBundle\Form\Type\InformaticaType;
use AppBundle\Form\Type\LaboralType;
use AppBundle\Form\Type\RegisterType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\Validator\Constraints\DateTime;
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
     * @Route("/registro", name="registro_personal", methods={"GET", "POST"})
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
                $this->addFlash('estado', 'Cambios guardados con éxito. Inicia sesión ahora mismo para añadir información a tu currículo');

                return $this->redirectToRoute('entrar');
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
     * @Security("has_role('ROLE_USER')")
     * @Route("/editar/datos-personales", name="editar_personal", methods={"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function EditarPersonalAction(Request $request){

    }

    /**
     * @Route("/editar/formacion/{id}", name="editar_formacion", methods={"GET", "POST"})
     * @Route("/añadir/formacion", name="add_formacion", methods={"GET", "POST"})
     * @param Request $request
     * @param Formacion|null $formacion
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function RegistroFormacionAction(Request $request, Formacion $formacion = null){
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        if (null == $formacion) {
            $formacion = new Formacion();
            $em->persist($formacion);
        }

        $form = $this->createForm(FormacionType::class, $formacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('estado', 'Cambios guardados con éxito');
                return $this->redirectToRoute('perfil');
            }
            catch(Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
        }
        return $this->render(':usuario:formacion.html.twig', [
            'formacion' => $formacion,
            'formulario' => $form->createView(),
        ]);
    }


    /**
     * @Route("/registro/formacion/complementaria/{id}", name="registro_formacion_complementaria", methods={"GET", "POST"})
     * @Route("/añadir/formacion/complementaria/{id}", name="añadir_formacion_complementaria", methods={"GET", "POST"})
     * @Route("/editar/formacion/complementaria/{id}", name="editar_complementaria", methods={"GET", "POST"})
     * @param Request $request
     * @param $id
     * @param Fcomplementaria|null $fcomplementaria
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function RegistroComplementariaAction(Request $request, $id, Fcomplementaria $fcomplementaria = null){
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        if (null == $fcomplementaria) {
            $fcomplementaria = new Fcomplementaria();
            $fcomplementaria->setUsuario($id);
            $em->persist($fcomplementaria);
        }

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
     * @Route("/añadir/laboral/{id}", name="añadir_laboral", methods={"GET", "POST"})
     * @Route("/editar/laboral/{id}", name="editar_laboral", methods={"GET", "POST"})
     * @param Request $request
     * @param $id
     * @param Laboral|null $laboral
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function RegistroLaboralAction(Request $request, $id, Laboral $laboral = null){
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        if (null == $laboral) {
            $laboral = new Laboral();
            $laboral->setUsuario($id);
            $em->persist($laboral);
        }

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
     * @Route("/añadir/idiomas/{id}", name="registro_idiomas", methods={"GET", "POST"})
     * @Route("/editar/idiomas/{id}", name="editar_idiomas", methods={"GET", "POST"})
     * @param Request $request
     * @param $id
     * @param Idioma|null $idioma
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function RegistroIdiomasAction(Request $request, $id, Idioma $idioma = null){
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        if (null == $idioma) {
            $idioma = new Idioma();
            $idioma->setUsuario($id);
            $em->persist($idioma);
        }

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
     * @Route("/añadir/informatica/{id}", name="registro_informatica", methods={"GET", "POST"})
     * @Route("/editar/informatica/{id}", name="editar_informatica", methods={"GET", "POST"})
     * @param Request $request
     * @param $id
     * @param Informatica|null $informatica
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function RegistroInformaticaAction(Request $request, $id, Informatica $informatica = null){
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        if (null == $informatica) {
            $informatica = new Fcomplementaria();
            $informatica->setUsuario($id);
            $em->persist($informatica);
        }

        $form = $this->createForm(InformaticaType::class, $informatica);
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
     * @Security("is_granted('ROLE_USER')")
     * @Route("/perfil", name="perfil")
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param Request $request
     */
    public function cambiarPerfilAction() {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $usuario = $this->getUser();

        if(empty($usuario) || !is_object($usuario)){
            return $this->redirectToRoute('entrar');
        }

        $formacion_usuario = $em->createQueryBuilder()
            ->select('f')
            ->from('AppBundle:Formacion', 'f')
            ->where('f.usuario = :id')
            ->setParameter('id', $usuario->getId())
            ->getQuery()
            ->getResult();

        $complementaria_usuario = $em->createQueryBuilder()
            ->select('f')
            ->from('AppBundle:Fcomplementaria', 'f')
            ->where('f.usuario = :id')
            ->setParameter('id', $usuario->getId())
            ->getQuery()
            ->getResult();

        $laboral_usuario = $em->createQueryBuilder()
            ->select('l')
            ->from('AppBundle:Laboral', 'l')
            ->where('l.usuario = :id')
            ->setParameter('id', $usuario->getId())
            ->getQuery()
            ->getResult();

        $idiomas_usuario = $em->createQueryBuilder()
            ->select('i')
            ->from('AppBundle:Idioma', 'i')
            ->where('i.usuario = :id')
            ->setParameter('id', $usuario->getId())
            ->getQuery()
            ->getResult();

        $informatica_usuario = $em->createQueryBuilder()
            ->select('i')
            ->from('AppBundle:Informatica', 'i')
            ->where('i.usuario = :id')
            ->setParameter('id', $usuario->getId())
            ->getQuery()
            ->getResult();

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
            'usuario' => $usuario,
            'formacion' => $formacion_usuario,
            'complementaria' => $complementaria_usuario,
            'laboral' => $laboral_usuario,
            'idiomas' => $idiomas_usuario,
            'informatica' => $informatica_usuario
//            'form' => $form->createView()
        ]);
    }
}
