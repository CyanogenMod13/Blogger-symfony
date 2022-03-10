<?php

namespace App\Domain\Model\Security;

use App\Application\Commands\Handler\UserRegisterHandler;
use App\Application\Commands\UserRegisterCommand;
use App\Domain\Repository\Exception\ModelRecordNotFoundException;
use App\Domain\Repository\UserRepositoryInterface;
use DateInterval;
use Google\Service\Oauth2\Userinfo;
use Google_Client;
use Google_Service_Oauth2;
use League\OAuth2\Server\Grant\AbstractGrant;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\ResponseTypes\ResponseTypeInterface;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;
use Trikoder\Bundle\OAuth2Bundle\League\AuthorizationServer\GrantTypeInterface;

class GoogleGrant extends AbstractGrant implements GrantTypeInterface
{
    public function __construct(
        private Google_Client $googleClient,
        private UserRepositoryInterface $users,
        private UserRegisterHandler $userRegisterHandler,
        RefreshTokenRepositoryInterface $refreshTokenRepository
    ) {
        $this->setRefreshTokenRepository($refreshTokenRepository);
        $this->refreshTokenTTL = new DateInterval('P1M');
    }

    public function getIdentifier(): string
    {
        return 'google_code_grant';
    }

    public function respondToAccessTokenRequest(ServerRequestInterface $request, ResponseTypeInterface $responseType, DateInterval $accessTokenTTL): ResponseTypeInterface
    {
        $client = $this->validateClient($request);

        $code = $request->getParsedBody()['code'];

        $this->googleClient->fetchAccessTokenWithAuthCode($code);

        $gsc = new Google_Service_Oauth2($this->googleClient);
        $userinfo = $gsc->userinfo->get();

        $user = $this->fetchUser($userinfo);

        $accessToken = $this->issueAccessToken($this->getAccessTokenTTL(), $client, $user->getUsername());
        $refreshToken = $this->issueRefreshToken($accessToken);

        $responseType->setAccessToken($accessToken);
        $responseType->setRefreshToken($refreshToken);

        return $responseType;
    }

    public function getAccessTokenTTL(): ?DateInterval
    {
        return new DateInterval('PT1H');
    }

    private function fetchUser(Userinfo $info): ?User
    {
        try {
            return $this->users->findByEmail($info->email);
        } catch (ModelRecordNotFoundException $e) {
            $command = new UserRegisterCommand();
            $command->username = $info->email;
            $command->password = Uuid::uuid4()->toString();
            $command->firstName = $info->givenName;
            $command->lastName = $info->familyName;
            $command->penName = 'google';
            return $this->userRegisterHandler->handle($command);
        }
    }
}