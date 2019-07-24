<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace App\Controller;

use App\Entity\Note;
use App\Form\NoteType;
use App\Service\HelloService;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MainController
 * @package App\Controller
 */
class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_index")
     *
     * @param Request $request
     * @param HelloService $helloService
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, HelloService $helloService)
    {
        /** @var Note $note */
        $note = new Note;

        /** @var FormInterface $form */
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        /** @var ObjectManager $em */
        $em = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($note);
            $em->flush();
            return $this->redirectToRoute('main_index');
        }

        /** @var Note[] $notes */
        $notes = $em->getRepository(Note::class)->findAll();

        return $this->render('main/index.html.twig', [
            'controller_name' => self::class,
            'helloService' => $helloService,
            'form' => $form->createView(),
            'notes' => $notes
        ]);
    }

    /**
     * @Route("/remove/{note}", name="main_remove")
     *
     * @param Note $note
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeNote(Note $note)
    {
        /** @var ObjectManager $em */
        $em = $this->getDoctrine()->getManager();

        $em->remove($note);
        $em->flush();

        return $this->redirectToRoute('main_index');
    }
}
