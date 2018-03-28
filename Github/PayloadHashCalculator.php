<?php

namespace Gvf\Bundle\FlowAutomationBundle\Github;

/**
 * @author Gonzalo Vilaseca <gonzalo.vilaseca@reiss.com>
 */
class PayloadHashCalculator
{
    private $secret;

    /**
     * @param string $secret
     */
    public function __construct(string $secret)
    {
        $this->secret = $secret;
    }

    /**
     * @param string $algo
     * @param string $payload
     *
     * @return string
     * @throws \Exception
     */
    public function getPayloadHash(string $algo, string $payload)
    {
        if ($algo !== 'sha1') {
            // see https://developer.github.com/webhooks/securing/
            throw new \Exception('Unsuppoted algorithm');
        }

        return hash_hmac($algo, $payload, $this->secret);
    }
}