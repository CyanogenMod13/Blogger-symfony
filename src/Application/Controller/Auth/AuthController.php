<?php

declare(strict_types=1);

namespace App\Application\Controller\Auth;

use App\Application\Commands\Handler\UserRegisterHandler;
use App\Application\Commands\UserRegisterCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route(['/api'])]
class AuthController extends AbstractController
{
	public function __construct(
		private SerializerInterface $serializer,
		private ValidatorInterface $validator
	) {}

	#[Route('/registration', name: 'api_reg', methods: ['POST'])]
	public function registration(Request $request, UserRegisterHandler $handler): Response
	{
		$userRegisterCommand = $this->serializer->deserialize(
			$request->getContent(),
			UserRegisterCommand::class,
			'json'
		);

		$violations = $this->validator->validate($userRegisterCommand);
		if ($violations->count() > 0) {
			throw new BadRequestException();
		}

		$payload = $handler->handle($userRegisterCommand);
		return $this->json($payload);
	}

    #[Route('/url', methods: ['GET'])]
    public function getGoogleAuthUrl(\Google_Client $gClient): Response
    {
        return $this->json([
            'url' => $gClient->createAuthUrl()
        ]);
    }
}