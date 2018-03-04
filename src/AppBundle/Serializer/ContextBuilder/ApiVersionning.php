<?php
// api/src/Serializer/BookContextBuilder.php

namespace AppBundle\Serializer\ContextBuilder;

use ApiPlatform\Core\Serializer\SerializerContextBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class ApiVersionning implements SerializerContextBuilderInterface
{
    private $decorated;
    private $authorizationChecker;

    public function __construct(SerializerContextBuilderInterface $decorated, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->decorated = $decorated;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function createFromRequest(Request $request, bool $normalization, ?array $extractedAttributes = null): array
    {
        $context = $this->decorated->createFromRequest($request, $normalization, $extractedAttributes);
        $version = $request->headers->get('Version');

        if ($version === "2") {
            $groups = [];
            foreach($context['groups'] as $group){
                $group .= "_v2";
                $groups[] = $group;
            }
            $context['groups'] = $groups;
        }

        return $context;
    }
}