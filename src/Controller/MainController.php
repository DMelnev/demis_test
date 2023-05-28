<?php

namespace App\Controller;

use App\Entity\Feedback;
use App\Form\FeedbackFormType;
use App\Repository\FeedbackRepository;
use App\Repository\NewsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_main")
     */
    public function index(NewsRepository $newsRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'news' => $newsRepository->findLast(3),
        ]);
    }

    /**
     * @Route ("/form", name="app_form")
     */
    public function form(
        Request $request,
        FeedbackRepository $feedbackRepository,
        EntityManagerInterface $entityManager
    ): Response
    {
        $form = $this->createForm(FeedbackFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Feedback $feedback */
            $feedback = $form->getData();
            $entityManager->persist($feedback);
            $entityManager->flush();
//            $this->addFlash('flash_message', "Сообщение успешно отправлено!");
        }

        return $this->renderForm('main/form.html.twig', [
            'feedbackForm' => $form,
            'feedbacks' => $feedbackRepository->findAllSorted(),
        ]);
    }

    /**
     * @Route ("/news", name="app_news")
     */
    public function news(NewsRepository $newsRepository): Response
    {

        return $this->render('main/news.html.twig', [
            'news' => $newsRepository->findAllSorted(),
        ]);
    }
}
