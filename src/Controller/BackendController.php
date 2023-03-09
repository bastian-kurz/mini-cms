<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class BackendController extends AbstractController
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    #[Route('/backend', name: 'backend', defaults: ['auth_required' => true], methods: ['GET'])]
    public function backendRender(): Response
    {
        $content = $this->twig->render(
            'Backend/backend.html.twig',
            [
                'btnCreate' => 'Erstellen',
                'menuContentOverview' => 'Übersicht'
            ]
        );
        return new Response($content);
    }

    #[Route('/backend/overview', name: 'backend.overview', defaults: ['auth_required' => true], methods: ['POST'])]
    public function overviewRender(Request $request): Response
    {
        $content = $this->twig->render(
            'Backend/overview.html.twig',
            [
                'data' => $request->request->all(),
                'btnEdit' => 'bearbeiten',
                'btnDelete' => 'löschen'
            ]
        );

        return new Response($content);
    }

    #[Route('/backend/create-update/{update}', name: 'backend.create.update', defaults: ['auth_required' => true], methods: ['GET'])]
    public function createRender(int $update): Response
    {
        $content = $this->twig->render(
            'Backend/create_update.html.twig',
            [
                'isUpdate' => $update,
                'labelIsoCode' => 'ISO-Code',
                'labelTitle' => 'Titel',
                'labelText' => 'Inhalt',
                'btnSave' => 'Speichern',
                'btnCancel' => 'Abbrechen'
            ]
        );

        return new Response($content);
    }
}
