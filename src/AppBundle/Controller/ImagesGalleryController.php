<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ImagesGallery;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Imagesgallery controller.
 *
 * @Route("gallery/images")
 */
class ImagesGalleryController extends Controller
{
    /**
     * Lists all imagesGallery entities.
     *
     * @Route("/", name="gallery_images_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $imagesGalleries = $em->getRepository('AppBundle:ImagesGallery')->findAll();

        return $this->render('imagesgallery/index.html.twig', array(
            'imagesGalleries' => $imagesGalleries,
        ));
    }

    /**
     * Creates a new imagesGallery entity.
     *
     * @Route("/new", name="gallery_images_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $imagesGallery = new Imagesgallery();
        $form = $this->createForm('AppBundle\Form\ImagesGalleryType', $imagesGallery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($imagesGallery);
            $em->flush($imagesGallery);

            return $this->redirectToRoute('gallery_images_show', array('id' => $imagesGallery->getId()));
        }

        return $this->render('imagesgallery/new.html.twig', array(
            'imagesGallery' => $imagesGallery,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a imagesGallery entity.
     *
     * @Route("/{id}", name="gallery_images_show")
     * @Method("GET")
     */
    public function showAction(ImagesGallery $imagesGallery)
    {
        $deleteForm = $this->createDeleteForm($imagesGallery);

        return $this->render('imagesgallery/show.html.twig', array(
            'imagesGallery' => $imagesGallery,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing imagesGallery entity.
     *
     * @Route("/{id}/edit", name="gallery_images_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ImagesGallery $imagesGallery)
    {
        $deleteForm = $this->createDeleteForm($imagesGallery);
        $editForm = $this->createForm('AppBundle\Form\ImagesGalleryType', $imagesGallery);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('gallery_images_edit', array('id' => $imagesGallery->getId()));
        }

        return $this->render('imagesgallery/edit.html.twig', array(
            'imagesGallery' => $imagesGallery,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a imagesGallery entity.
     *
     * @Route("/{id}", name="gallery_images_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ImagesGallery $imagesGallery)
    {
        $form = $this->createDeleteForm($imagesGallery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($imagesGallery);
            $em->flush($imagesGallery);
        }

        return $this->redirectToRoute('gallery_images_index');
    }

    /**
     * Creates a form to delete a imagesGallery entity.
     *
     * @param ImagesGallery $imagesGallery The imagesGallery entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ImagesGallery $imagesGallery)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('gallery_images_delete', array('id' => $imagesGallery->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
