<?php

namespace Gvf\Bundle\FlowAutomationBundle\Github\Deciders;

use Gvf\Bundle\FlowAutomationBundle\Github\GithubRequestDto;

/**
 * @author Gonzalo Vilaseca <gonzalo.vilaseca@reiss.com>
 */
interface DeciderInterface
{
    /**
     * @param GithubRequestDto $dto
     *
     * @param array            $options
     *
     * @return bool
     */
    public function applies(GithubRequestDto $dto, array $options): bool;
}