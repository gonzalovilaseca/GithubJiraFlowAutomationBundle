<?php

namespace Gvf\Bundle\FlowAutomationBundle\Github\Handlers;

use Gvf\Bundle\FlowAutomationBundle\Github\GithubRequestDto;

/**
 * @author Gonzalo Vilaseca <gonzalo.vilaseca@reiss.com>
 */
interface GithubHandlerInterface
{
    /**
     * @param GithubRequestDto $dto
     */
    public function handle(GithubRequestDto $dto);
}