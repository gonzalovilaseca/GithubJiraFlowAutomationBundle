<?php

namespace Gvf\Bundle\FlowAutomationBundle\Github\Deciders;

use Gvf\Bundle\FlowAutomationBundle\Github\GithubRequestDto;

/**
 * @author Gonzalo Vilaseca <gonzalo.vilaseca@reiss.com>
 */
class LabelAddedDecider implements DeciderInterface
{
    /**
     * {@inheritdoc}
     */
    public function applies(GithubRequestDto $dto, array $options): bool
    {
        if ('pull_request' !== $dto->getEvent()) {
            return false;
        }
        $payload = $dto->getPayload();
        if ('labeled' !== $payload['action']) {
            return false;
        }
        if ($options['label'] !== $payload['label']['name']) {
            return false;
        }

        return true;
    }
}