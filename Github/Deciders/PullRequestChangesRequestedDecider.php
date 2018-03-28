<?php

namespace Gvf\Bundle\FlowAutomationBundle\Github\Deciders;

use Gvf\Bundle\FlowAutomationBundle\Github\GithubRequestDto;

/**
 * @author Gonzalo Vilaseca <gonzalo.vilaseca@reiss.com>
 */
class PullRequestChangesRequestedDecider implements DeciderInterface
{
    /**
     * {@inheritdoc}
     */
    public function applies(GithubRequestDto $dto, array $options): bool
    {
        if ('pull_request_review' !== $dto->getEvent()) {
            return false;
        }

        $payload = $dto->getPayload();
        if ('submitted' !== $action = $payload['action']) {
            return false;
        }

        return 'changes_requested' === strtolower($payload['review']['state']);
    }
}