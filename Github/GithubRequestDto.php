<?php

namespace Gvf\Bundle\FlowAutomationBundle\Github;

/**
 * @author Gonzalo Vilaseca <gonzalo.vilaseca@reiss.com>
 */
class GithubRequestDto
{
    /**
     * @var string[]
     */
    private $payload;

    /**
     * @var string
     */
    private $event;

    /**
     * @var string
     */
    private $delivery;

    /**
     * @param array  $payload
     * @param string $event
     * @param string $delivery
     */
    public function __construct(array $payload, string $event, string $delivery)
    {
        $this->payload  = $payload;
        $this->event    = $event;
        $this->delivery = $delivery;
    }

    /**
     * @return array
     */
    public function getPayload(): array
    {
        return $this->payload;
    }

    /**
     * @return string
     */
    public function getEvent(): string
    {
        return $this->event;
    }

    /**
     * @return string
     */
    public function getDelivery(): string
    {
        return $this->delivery;
    }

}