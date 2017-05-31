<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class EliminarController extends Controller
{

    /**
     * @Security("is_granted('ROLE_USER')")
     * @Route("/formacion/eliminar/{id}", name="eliminar_formacion")
     * @param null $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function eliminarFormacionAction($id = null){
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $formacion_repo = $em->getRepository('AppBundle:Formacion');
        $formacion = $formacion_repo->find($id);
        $usuario = $this->getUser();

        if($usuario->getId() == $formacion->getUsuario()->getId() || $this->getUser()->isAdmin()){
            $em->remove($formacion);
            $flush = $em->flush();
            if($flush == null){
                $this->addFlash('estado', 'Formación borrada correctamente');
            }else{
                $this->addFlash('error', 'Hubo algún problema al borrar la formación');
            }
        }else{
            $this->addFlash('error', 'No tiene permisos para borrar este elemento');
        }

        return $this->redirectToRoute('perfil');
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     * @Route("/complementaria/eliminar/{id}", name="eliminar_complementaria")
     * @param null $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function eliminarComplementariaAction($id = null){
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $complementaria_repo = $em->getRepository('AppBundle:Fcomplementaria');
        $complementaria = $complementaria_repo->find($id);
        $usuario = $this->getUser();

        if($usuario->getId() == $complementaria->getUsuario()->getId() || $this->getUser()->isAdmin()){
            $em->remove($complementaria);
            $flush = $em->flush();
            if($flush == null){
                $this->addFlash('estado', 'Formación complementaria borrada correctamente');
            }else{
                $this->addFlash('error', 'Hubo algún problema al borrar la formación complementaria');
            }
        }else{
            $this->addFlash('error', 'No tiene permisos para borrar este elemento');
        }

        return $this->redirectToRoute('perfil');
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     * @Route("/laboral/eliminar/{id}", name="eliminar_laboral")
     * @param null $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function eliminarLaboralAction($id = null){
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $laboral_repo = $em->getRepository('AppBundle:Laboral');
        $laboral = $laboral_repo->find($id);
        $usuario = $this->getUser();

        if($usuario->getId() == $laboral->getUsuario()->getId() || $this->getUser()->isAdmin()){
            $em->remove($laboral);
            $flush = $em->flush();
            if($flush == null){
                $this->addFlash('estado', 'Experiencia laboral borrada correctamente');
            }else{
                $this->addFlash('error', 'Hubo algún problema al borrar la Experiencia laboral');
            }
        }else{
            $this->addFlash('error', 'No tiene permisos para borrar este elemento');
        }

        return $this->redirectToRoute('perfil');
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     * @Route("/informatica/eliminar/{id}", name="eliminar_informatica")
     * @param null $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function eliminarInformaticaAction($id = null){
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $informatica_repo = $em->getRepository('AppBundle:Informatica');
        $informatica = $informatica_repo->find($id);
        $usuario = $this->getUser();

        if($usuario->getId() == $informatica->getUsuario()->getId() || $this->getUser()->isAdmin()){
            $em->remove($informatica);
            $flush = $em->flush();
            if($flush == null){
                $this->addFlash('estado', 'Conocimiento de informática borrado correctamente');
            }else{
                $this->addFlash('error', 'Hubo algún problema al borrar el conocimiento de informática');
            }
        }else{
            $this->addFlash('error', 'No tiene permisos para borrar este elemento');
        }

        return $this->redirectToRoute('perfil');
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     * @Route("/idioma/eliminar/{id}", name="eliminar_idioma")
     * @param null $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function eliminarIdiomaAction($id = null){
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $idioma_repo = $em->getRepository('AppBundle:Idioma');
        $idioma = $idioma_repo->find($id);
        $usuario = $this->getUser();

        if($usuario->getId() == $idioma->getUsuario()->getId() || $this->getUser()->isAdmin()){
            $em->remove($idioma);
            $flush = $em->flush();
            if($flush == null){
                $this->addFlash('estado', 'Idioma borrado correctamente');
            }else{
                $this->addFlash('error', 'Hubo algún problema al borrar el idioma');
            }
        }else{
            $this->addFlash('error', 'No tiene permisos para borrar este elemento');
        }

        return $this->redirectToRoute('perfil');
    }
}
