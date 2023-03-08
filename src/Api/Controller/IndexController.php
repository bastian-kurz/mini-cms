<?php

declare(strict_types=1);

namespace App\Api\Controller;

use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[OA\Info(version: '0.0.1', title: 'Mini-CMS API')]
class IndexController extends AbstractController
{
}
