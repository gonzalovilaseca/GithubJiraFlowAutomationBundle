<?php

namespace Gvf\Bundle\FlowAutomationBundle\Github\Deciders;

use Gvf\Bundle\FlowAutomationBundle\Github\GithubRequestDto;

/**
 * @author Gonzalo Vilaseca <gonzalo.vilaseca@reiss.com>
 */
class PullRequestApprovedDecider implements DeciderInterface
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
        if ('submitted' !== $payload['action']) {
            return false;
        }

        return 'approved' === strtolower($payload['review']['state']);
    }
}