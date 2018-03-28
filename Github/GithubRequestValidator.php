<?php

namespace Gvf\Bundle\FlowAutomationBundle\Github;

use Symfony\Component\HttpFoundation\Request;

/**
 * Based on https://github.com/dintel/php-github-webhook/blob/master/src/Handler.php
 *
 * @author Gonzalo Vilaseca <gonzalo.vilaseca@reiss.com>
 */
class GithubRequestValidator
{

    /**
     * @var PayloadHashCalculator
     */
    private $payloadHashCalculator;

    /**
     * @param PayloadHashCalculator $payloadHashCalculator
     */
    public function __construct(PayloadHashCalculator $payloadHashCalculator)
    {
        $this->payloadHashCalculator = $payloadHashCalculator;
    }

    /**
     * @param Request $request
     *
     * @return GithubRequestDto
     * @throws \Exception
     */
    public function validate(Request $request)
    {
//        @todo move to constants
        $signature = $request->headers->get('X-Hub-Signature');
        $event     = $request->headers->get('X-GitHub-Event');
        $delivery  = $request->headers->get('X-GitHub-Delivery');

        if (!isset($signature, $event, $delivery)) {
            throw new \Exception('Missing arguments');
        }
        $payload = $request->getContent();

        if (!$this->validateSignature($signature, $payload)) {
            throw new \Exception('Invalid signature');
        }

        return new GithubRequestDto(json_decode($payload, true), $event, $delivery);
    }

    /**
     * @param $gitHubSignatureHeader
     * @param $payload
     *
     * @return bool
     * @throws \Exception
     */
    protected function validateSignature($gitHubSignatureHeader, $payload)
    {
        list ($algo, $gitHubSignature) = explode("=", $gitHubSignatureHeader, 2);

        $payloadHash = $this->payloadHashCalculator->getPayloadHash($algo, $payload);

        return $payloadHash === $gitHubSignature;
    }
}