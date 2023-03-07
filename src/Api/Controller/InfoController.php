<?php declare(strict_types=1);

namespace App\Api\Controller;

use App\Api\OpenApi\Generator\OpenApiLoader;
use ReflectionException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class InfoController extends AbstractController
{
    private OpenApiLoader $openApiLoader;

    private Environment $twig;

    public function __construct(OpenApiLoader $openApiLoader, Environment $twig)
    {
        $this->openApiLoader = $openApiLoader;
        $this->twig = $twig;
    }

    /**
     * @throws ReflectionException
     */
    #[Route('/api/_info/openapi3.json', name: 'api.info.openapi3', defaults: ['auth_required' => false], methods: ['GET'])]
    public function info(Request $request): JsonResponse
    {
        return $this->json($this->openApiLoader->load());
    }

    #[Route('/api/_info/swagger.html', name: 'api.info.swagger', defaults: ['auth_required' => false], methods: ['GET'])]
    public function infoHtml(): Response
    {
        $response = new Response();
        $content = $this->twig->render(
            'swagger.html.twig',
            [
                'schemaUrl' => 'api.info.openapi3',
                'apiType' => 'json'
            ]
        );

        $response->setContent($content);

        return $response;
    }
}