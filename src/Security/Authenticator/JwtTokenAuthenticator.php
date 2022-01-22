<?php


namespace App\Security\Authenticator;

use App\Entity\User\User;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\AuthorizationHeaderTokenExtractor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class JwtTokenAuthenticator extends AbstractAuthenticator
{
    /**
     * @var JWTEncoderInterface
     */
    private $decoder;

    /**
     * JwtTokenAuthenticator constructor.
     * @param JWTEncoderInterface $decoder
     */
    public function __construct(JWTEncoderInterface $decoder)
    {
        $this->decoder = $decoder;
    }

    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning `false` will cause this authenticator
     * to be skipped.
     * @param Request $request
     * @return bool|null
     */
    public function supports(Request $request): ?bool
    {
        //return $request->headers->has('X-AUTH-TOKEN');
        if ($request->headers->has('authorization') === false)
            throw new CustomUserMessageAuthenticationException('tOKEN NOT FOUND');
        return true;
    }

    public function authenticate(Request $request): Passport
    {
        //$apiToken = $request->headers->get('X-AUTH-TOKEN');
        $apiToken = $request->headers->get('authorization');
        $extractor = new AuthorizationHeaderTokenExtractor('Bearer','Authorization');
        $apiToken = $extractor->extract($request);
        return new SelfValidatingPassport(new UserBadge($apiToken,function ($userIdentifier){
            $apiToken = $this->decoder->decode($userIdentifier);
            return new User(
              $apiToken['username'],
              $apiToken['roles'],
              (int)$apiToken['user_id']
            );
        }));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // on success, let the request continue
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $data = [
            // you may want to customize or obfuscate the message first
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())

            // or to translate this message
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }
}