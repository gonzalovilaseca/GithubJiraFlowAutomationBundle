<?php

namespace Gvf\Bundle\FlowAutomationBundle\Github\Actions;

use Github\Client;

/**
 * @author Gonzalo Vilaseca <gonzalo.vilaseca@reiss.com>
 */
class PrLabel
{
    /**
     * @var Client
     */
    private $githubClient;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $repository;

    /**
     * @param Client $githubClient
     */
    public function __construct(Client $githubClient, string $username, string $repository)
    {
        $this->githubClient = $githubClient;
        $this->username     = $username;
        $this->repository   = $repository;
    }

    /**
     * @param string $pullRequestNumber
     * @param string $label
     */
    public function addLabel(string $pullRequestNumber, string $label)
    {
        $this->githubClient->authenticate('de2b5296e0482756ed790607ba29b1a0b21a6d37', null, Client::AUTH_HTTP_TOKEN);
        $this->githubClient->api('issue')
                           ->labels()
                           ->add(
                               $this->username,
                               $this->repository,
                               $pullRequestNumber,
                               $label
                           );
    }

    /**
     * @param string $pullRequestNumber
     * @param string $label
     */
    public function replaceLabels(string $pullRequestNumber, string $label)
    {
        $this->githubClient->authenticate('de2b5296e0482756ed790607ba29b1a0b21a6d37', null, Client::AUTH_HTTP_TOKEN);
        $this->githubClient->api('issue')
                           ->labels()
                           ->replace(
                               $this->username,
                               $this->repository,
                               $pullRequestNumber,
                               [$label]
                           );
    }
}