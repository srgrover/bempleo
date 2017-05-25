<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="raiz")
     */
    public function indexAction()
    {
        return $this->redirectToRoute('entrar');
    }

    /**
     * @Route("/recuperacion/buscar-usuario", name="buscar_usuario")
     */
    public function recuperarAction()
    {
        if(is_object($this->getUser())){        //El usuario está logueado
            return $this->redirectToRoute('perfil');
        }

        $helper = $this->get('security.authentication_utils');

        return $this->render(':complementarios:recuperar_contrasena.html.twig', [
            'ultimo_usuario' => $helper->getLastUsername(),
            'error' => $helper->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route("/recuperacion/comprobar", name="comprobar_usuario")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function comprobarUsuarioAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        if(is_object($this->getUser())){        //El usuario está logueado
            return $this->redirectToRoute('perfil');
        }

        $search = trim($request->request->get("identif", null)); //Se recoge el valor de la variable search de la URL

        if($search == null){    //Si la variable search del GET es nula, se redirige a la pagina home
            $this->addFlash('error', 'No puedes dejar el campo de identificación vacío');
            return $this->redirectToRoute('buscar_usuario');
        }

        $usuario_repository = $em->getRepository('AppBundle:Usuario');
        $usuario = $usuario_repository->findOneBy([$search]);

//        $profesorado = $em->createQueryBuilder()
//            ->select('p')
//            ->from('AppBundle:Profesor', 'p')
//            ->orderBy('p.apellidos', 'ASC')
//            ->addOrderBy('p.nombre', 'ASC')
//            ->getQuery()
//            ->getResult();

        $helper = $this->get('security.authentication_utils');

        return $this->render('complementarios/comprobar_usuario.html.twig', [
            'ultimo_usuario' => $helper->getLastUsername(),
            'error' => $helper->getLastAuthenticationError(),
            'usu' => $usuario,
        ]);
    }
}
