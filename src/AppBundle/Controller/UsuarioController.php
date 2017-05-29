<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Fcomplementaria;
use AppBundle\Entity\Formacion;
use AppBundle\Entity\Idioma;
use AppBundle\Entity\Informatica;
use AppBundle\Entity\Laboral;
use AppBundle\Entity\Usuario;
use AppBundle\Form\Type\EditarUsuarioType;
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
        if(is_object($this->getUser()) && !$this->getUser()->isAdmin()){
            return $this->redirect('perfil');
        }

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
        $usuario = $this->getUser();   //getUser() para recoger los datos de un usuario que ya esta logueado
        $usuario_image = $usuario->getFoto();
        $form = $this->createForm(EditarUsuarioType::class, $usuario);  //Crea el formulario

        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            /** @var EntityManager $em*/
            $em = $this->getDoctrine()->getManager();
            $user_isset = $em->createQueryBuilder()
                ->select('u')
                ->from('AppBundle:Usuario', 'u')
                ->where('u.num_identi = :identi')
                ->setParameter('identi', $form->get("numIdenti")->getData())
                ->getQuery()
                ->getResult();
            if(count($user_isset) == 0 || ($usuario->getNumIdenti() == $user_isset[0]->getNumIdenti())){
                //Fichero subido
                $imagenPerfil = $form["foto"]->getData();
                if(!empty($imagenPerfil) && $imagenPerfil != null){
                    $ext = $imagenPerfil->guessExtension();
                    if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif'){
                        $nombre_imagen = $usuario->getId().time().'.'.$ext;
                        $imagenPerfil->move("uploads/users", $nombre_imagen);
                        $usuario->setFoto($nombre_imagen);
                    }
                }else{
                    $usuario->setFoto($usuario_image);
                }
                $em->persist($usuario);

                $flush = $em->flush();
                if($flush == null){ //No devuelve ningun error
                    $this->addFlash('estado', 'Los datos se han modificado correctamente');
                    return $this->redirectToRoute('perfil');
                }else{
                    $this->addFlash('error', 'Hubo algún problema al intentar modificar los datos');
                }
            }else{
                $this->addFlash('error', 'El número de identificación ya está siendo usado por otra persona');
            }
        }

        return $this->render(':usuario:editar_usuario.html.twig', array(
            "formulario" => $form->createView()
        ));
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
            $usuario = $this->getUser();
            $formacion->setUsuario($usuario);
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
     * @Route("/añadir/formacion/complementaria", name="add_complementaria", methods={"GET", "POST"})
     * @Route("/editar/formacion/complementaria/{id}", name="editar_complementaria", methods={"GET", "POST"})
     * @param Request $request
     * @param Fcomplementaria|null $fcomplementaria
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function RegistroComplementariaAction(Request $request, Fcomplementaria $fcomplementaria = null){
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        if (null == $fcomplementaria) {
            $fcomplementaria = new Fcomplementaria();
            $usuario = $this->getUser();
            $fcomplementaria->setUsuario($usuario);
            $em->persist($fcomplementaria);
        }

        $form = $this->createForm(FcomplementariaType::class, $fcomplementaria);
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
        return $this->render(':usuario:formacion_complementaria.html.twig', [
            'fcomplementaria' => $fcomplementaria,
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/añadir/laboral", name="add_laboral", methods={"GET", "POST"})
     * @Route("/editar/laboral/{id}", name="editar_laboral", methods={"GET", "POST"})
     * @param Request $request
     * @param Laboral|null $laboral
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function RegistroLaboralAction(Request $request, Laboral $laboral = null){
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        if (null == $laboral) {
            $laboral = new Laboral();
            $usuario = $this->getUser();
            $laboral->setUsuario($usuario);
            $em->persist($laboral);
        }

        $form = $this->createForm(LaboralType::class, $laboral);
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
        return $this->render(':usuario:laboral.html.twig', [
            'laboral' => $laboral,
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/añadir/idioma", name="add_idioma", methods={"GET", "POST"})
     * @Route("/editar/idioma/{id}", name="editar_idioma", methods={"GET", "POST"})
     * @param Request $request
     * @param Idioma|null $idioma
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function RegistroIdiomasAction(Request $request, Idioma $idioma = null){
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        if (null == $idioma) {
            $idioma = new Idioma();
            $usuario = $this->getUser();
            $idioma->setUsuario($usuario);
            $em->persist($idioma);
        }

        $form = $this->createForm(IdiomaType::class, $idioma);
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
        return $this->render(':usuario:idiomas.html.twig', [
            'idioma' => $idioma,
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/añadir/informatica", name="add_informatica", methods={"GET", "POST"})
     * @Route("/editar/informatica/{id}", name="editar_informatica", methods={"GET", "POST"})
     * @param Request $request
     * @param Informatica|null $informatica
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function RegistroInformaticaAction(Request $request, Informatica $informatica = null){
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        if (null == $informatica) {
            $informatica = new Informatica();
            $usuario = $this->getUser();
            $informatica->setUsuario($usuario);
            $em->persist($informatica);
        }

        $form = $this->createForm(InformaticaType::class, $informatica);
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
        return $this->render(':usuario:informatica.html.twig', [
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
    public function PerfilAction() {

        if(is_object($this->getUser()) && $this->getUser()->isAdmin()){
            return $this->redirect('administracion');
        }

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
            ->orderBy('f.obtencion', 'DESC')
            ->getQuery()
            ->getResult();

        $complementaria_usuario = $em->createQueryBuilder()
            ->select('f')
            ->from('AppBundle:Fcomplementaria', 'f')
            ->where('f.usuario = :id')
            ->setParameter('id', $usuario->getId())
            ->orderBy('f.anio', 'DESC')
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

    /**
     * @Security("is_granted('ROLE_USER')")
     * @Route("/usuario/cambiar-contraseña/{id}", name="cambiar_pass")
     * @param Usuario $usuario
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cambiarPassAction(Usuario $usuario) {

        if($this->getUser()->isAdmin() || (is_object($this->getUser()) && $this->getUser()->getId() == $usuario->getId())){
            return $this->render(':administracion:cambiar_contraseña.html.twig', [
                'usuario' => $usuario
            ]);
        }else{
            return $this->redirectToRoute('perfil');
        }
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     * @Route("/usuario/confirmar-contraseña/{id}", name="confirmar_pass")
     * @param Request $request
     * @param Usuario $usuario
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param Request $request
     */
    public function confirmarPassAction(Request $request, Usuario $usuario) {
        $actual = $request->get("passAntigua");
        $nueva = $request->get("passNueva");
        $nuevaRep = $request->get("rePassNueva");

        if($this->getUser()->isAdmin() || (is_object($this->getUser()) && $this->getUser()->getId() == $usuario->getId())) {
            if($actual != $usuario->getPassword()){
                $this->addFlash('error', 'La contraseña actual no coincide');
                return $this->redirectToRoute('cambiar_pass', ['id' => $usuario]);
            }elseif($nueva == $nuevaRep){
                try{
                    if ($nuevaRep) {
                        $clave = $this->get('security.password_encoder')
                            ->encodePassword($usuario, $nuevaRep);
                        $usuario->setPassword($clave);
                    }
                    $this->getDoctrine()->getManager()->flush();
                    $this->addFlash('estado', 'La contraseña se ha modificado correctamente');
                }catch (Exception $exception){
                    $this->addFlash('error', 'Hubo algún problema al cambiar la contraseña');
                }
            }
        }else{
            $this->addFlash('error', 'No tienes permisos para modificar la contraseña');
        }

        return $this->redirectToRoute('perfil');
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     * @Route("/usuario/cambiar-foto", name="cambiar_foto")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param Request $request
     */
    public function cambiarFotoAction(Request $request) {
        /**@var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $usuario = $this->getUser();

        $foto_antigua = $usuario->getFoto();
        $foto_seleccionada = $request->get("foto");

        if(!empty($foto_seleccionada) && $foto_seleccionada != null){
            $ext = $foto_seleccionada->guessExtension();
            if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif'){
                $nombre_imagen = $usuario->getId().time().'.'.$ext;
                var_dump($nombre_imagen);
                $foto_seleccionada->move("uploads/users", $nombre_imagen);
                $usuario->setFoto($nombre_imagen);
            }else{
                $this->addFlash('error', 'Debes seleccionar una foto con formato: jpg, jpeg, png o gif');
            }
        }

        $em->persist($usuario);
        $flush = $em->flush();

        if($flush == null){ //No devuelve ningun error
            $this->addFlash('estado', 'Foto de perfil cambiada correctamente');
            unlink($foto_antigua);
        }else{
            $this->addFlash('error', 'No se ha podido cambiar la foto de perfil');
        }

        return $this->redirectToRoute('perfil');
    }

}
