<?php

namespace Gvf\Bundle\FlowAutomationBundle\Github;

use Gvf\Bundle\FlowAutomationBundle\Github\Handlers\GithubHandlerInterface;

/**
 * @author Gonzalo Vilaseca <gonzalo.vilaseca@reiss.com>
 */
class GithubHandler
{
    /**
     * @var GithubHandlerInterface[]
     */
    private $handlers = [];

    /**
     * @param GithubRequestDto $dto
     */
    public function handle(GithubRequestDto $dto)
    {
        foreach ($this->handlers as $handler) {
            $handler->handle($dto);
        }
    }

    /**
     * @param GithubHandlerInterface $githubHandler
     */
    public function addHandler(GithubHandlerInterface $githubHandler)
    {
        $this->handlers[] = $githubHandler;
    }
}