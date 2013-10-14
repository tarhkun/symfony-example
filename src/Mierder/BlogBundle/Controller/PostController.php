<?php

namespace Mierder\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Mierder\BlogBundle\Entity\Post;
use \DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller {

    /**
     * @Route("/post/new", name="new_post")
     * @Template()
     */
    public function postCreateAction(Request $request) {
        

        $post = new Post();
        
        $form = $this->createFormBuilder($post)
            ->add('content', 'text')
            ->add('title', 'text')
            ->add('date', 'date')
            ->add('save', 'submit')
            ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirect($this->generateUrl('view_post',array('id' => $post->getId())));
        }
        

        

        return array('form' => $form->createView());
    }

    /**
     * @Route("/post/{id}", name="view_post")
     * @Template()
     */
    public function postViewAction($id) {
        $entityManager = $this->getDoctrine()->getManager();

        $postRepository = $entityManager->getRepository('MierderBlogBundle:Post');

        $post = new Post();
        $post = $postRepository->find($id);

        if ($post) {
            $twigArray = array('title' => $post->getTitle(),
                'date' => $post->getDate()->format('d-m-Y'),
                'content' => $post->getContent(),
                'id' => $id);
            return $twigArray;
        }

        throw $this->createNotFoundException('The post does not exist');
    }

    /**
     * @Route("/", name="post_list")
     * @Template()
     */
    public function postListAction() {
        
        $entityManager = $this->getDoctrine()->getManager();

        $postRepository = $entityManager->getRepository('MierderBlogBundle:Post');
        
        $postList = $postRepository->findAll();
        
        return array("posts" => $postList);
    }

}