<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\CustomEntityRepositoryInterface;
use App\Entity\ContentEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class CmsFrontendController extends AbstractController
{
    private CustomEntityRepositoryInterface $customEntityRepository;

    private Environment $twig;

    public function __construct(CustomEntityRepositoryInterface $customEntityRepository, Environment $twig)
    {
        $this->customEntityRepository = $customEntityRepository;
        $this->twig = $twig;
    }

    #[Route('/{isoCode}/{title}', 'cms.frontend', defaults: ['auth_required' => false], methods: ['GET'])]
    public function cmsFrontend(string $isoCode, string $title): Response
    {
        $entities = $this->customEntityRepository->read(['isoCode' => $isoCode, 'title' => $title], null);
        if (!is_countable($entities) || count($entities) === 0) {
            return new Response($this->twig->render('Frontend/404_not_found.html.twig'), Response::HTTP_NOT_FOUND);
        }

        /** @var ContentEntity $entity */
        $entity = $entities[0];

        $content = $this->twig->render('Frontend/cms.html.twig', [
            'cms' => [
                'title' => $entity->getTitle(),
                'text' => $entity->getText()
            ]
        ]);

        return new Response($content);
    }
}
