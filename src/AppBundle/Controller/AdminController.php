<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use AppBundle\Form\Type\EditarUsuarioType;
use AppBundle\Form\Type\ImagenType;
use AppBundle\Form\Type\PassType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 * @Route("/administracion")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="administracion")
     */
    public function indexAction(){
        if(!$this->getUser()->isAdmin()){
            return $this->redirectToRoute('perfil');
        }

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $usuarios = $em->createQueryBuilder()
            ->select('u')
            ->from('AppBundle:Usuario', 'u')
            ->where('u.admin = false')
            ->orderBy('u.nombre')
            ->addOrderBy('u.apellidos')
            ->getQuery()
            ->getResult();
        return $this->render('administracion/admin.html.twig', [
            'usuarios' => $usuarios
        ]);
    }

    /**
     * @Route("/usuario/editar/{id}", name="editar_usuario", methods={"GET", "POST"})
     * @param Request $request
     * @param Usuario $usuario
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editarUsuarioAction(Request $request, Usuario $usuario){
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(EditarUsuarioType::class, $usuario);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->flush();
                $this->addFlash('estado', 'Cambios guardados con éxito');
                return $this->redirectToRoute('administracion');
            }
            catch(Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
        }
        return $this->render(':usuario:editar_usuario.html.twig', [
            'usuario' => $usuario,
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/eliminar/usuario/{id}", name="borrar_usuario", methods={"GET"})
     * @param Usuario $usuario
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function borrarUsuarioAction(Usuario $usuario)
    {
        return $this->render(':administracion:borrarUsuario.html.twig', [
            'usuario' => $usuario
        ]);
    }

    /**
     * @Route("/eliminar/usuario/{id}", name="confirmar_borrar_usuario", methods={"POST"})
     * @param Usuario $usuario
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function borrarDeVerdadAction(Usuario $usuario)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        try {
            foreach($usuario->getFormacion() as $formacion) {
                $em->remove($formacion);
            }
            foreach($usuario->getFormacionComplem() as $complementaria) {
                $em->remove($complementaria);
            }
            foreach($usuario->getLaboral() as $laboral) {
                $em->remove($laboral);
            }
            foreach($usuario->getInformatica() as $informatica) {
                $em->remove($informatica);
            }
            foreach($usuario->getIdioma() as $idioma) {
                $em->remove($idioma);
            }
            $em->remove($usuario);
            $em->flush();
            $this->addFlash('estado', 'El usuario se ha eliminado con éxito');
        }
        catch(Exception $e) {
            $this->addFlash('error', 'Hubo algún error. No se han podido eliminar el usuario');
        }
        return $this->redirectToRoute('administracion');
    }

    /**
     * @Route("/cambiar-contraseña/{id}", name="cambiar_pass_usuario")
     * @param Request $request
     * @param Usuario $usuario
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cambiarPassAction(Request $request, Usuario $usuario){
        $form = $this->createForm(PassType::class, $usuario);
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            try {
                $claveFormulario = $form->get('nueva')->get('first')->getData();
                if ($claveFormulario) {
                    $clave = $this->get('security.password_encoder')
                        ->encodePassword($usuario, $claveFormulario);
                    $usuario->setPassword($clave);
                }
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('estado', 'Contraseña cambiada con éxito!');
                return $this->redirectToRoute('perfil');
            } catch (Exception $exception) {
                $this->addFlash('error', 'Hubo algún problema al actualizar la contraseña');
            }
        }

        return $this->render(':administracion:cambiar_contraseña.html.twig', [
            'formulario' => $form->createView(),
            'usuario' => $usuario
        ]);
    }


    /**
     * @Route("/perfil/{id}", name="perfil_usuario")
     * @param Request $request
     * @param Usuario $usuario
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param Request $request
     */
    public function PerfilAction(Request $request, Usuario $usuario) {

        if(is_object($this->getUser()) && !$this->getUser()->isAdmin()){
            return $this->redirectToRoute('perfil');
        }

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $foto_antigua = $usuario->getFoto();

        $form = $this->createForm(ImagenType::class, $usuario);
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            $foto_seleccionada = $form->get('foto')->getData();
            $ext = $foto_seleccionada->guessExtension();

            if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif'){
                $nombre_imagen = $usuario->getId().time().'.'.$ext;
                $foto_seleccionada->move("uploads/users", $nombre_imagen);
                $usuario->setFoto($nombre_imagen);
            }else{
                $this->addFlash('error', 'Debes seleccionar una foto con formato: jpg, jpeg, png o gif');
            }

            $flush = $em->flush();

            if($flush == null){ //No devuelve ningun error
                $this->addFlash('estado', 'Foto de perfil cambiada correctamente');
                if($foto_antigua != null) {
                    unlink("uploads/users/" . $foto_antigua);
                }
            }else{
                $this->addFlash('error', 'No se ha podido cambiar la foto de perfil');
            }

            return $this->redirectToRoute('perfil');
        }


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


        return $this->render(':administracion:perfil_usuario.html.twig', [
            'usuario' => $usuario,
            'formacion' => $formacion_usuario,
            'complementaria' => $complementaria_usuario,
            'laboral' => $laboral_usuario,
            'idiomas' => $idiomas_usuario,
            'informatica' => $informatica_usuario,
            'formulario' => $form->createView()
        ]);
    }
}
