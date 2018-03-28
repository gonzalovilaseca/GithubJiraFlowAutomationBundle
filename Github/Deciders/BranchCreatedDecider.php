<?php

namespace Gvf\Bundle\FlowAutomationBundle\Github\Deciders;

use Gvf\Bundle\FlowAutomationBundle\Github\GithubRequestDto;

/**
 * @author Gonzalo Vilaseca <gonzalo.vilaseca@reiss.com>
 */
class BranchCreatedDecider implements DeciderInterface
{
    /**
     * {@inheritdoc}
     */
    public function applies(GithubRequestDto $dto, array $options): bool
    {
        return 'create' === $dto->getEvent();
    }

}