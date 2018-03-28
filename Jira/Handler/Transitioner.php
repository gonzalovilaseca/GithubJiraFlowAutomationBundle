<?php

namespace Gvf\Bundle\FlowAutomationBundle\Jira\Handler;

use JiraRestApi\Issue\IssueService;
use JiraRestApi\Issue\Transition;
use JiraRestApi\JiraException;
use Psr\Log\LoggerInterface;

/**
 * @author Gonzalo Vilaseca <gonzalo.vilaseca@reiss.com>
 */
class Transitioner
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function transition(string $issueKey, int $transitionId)
    {
        try {
            $transition = new Transition();
            $transition->setTransitionId($transitionId);
            $transition->setCommentBody('Performing the transition via REST API.');

            $issueService = new IssueService();

            $issueService->transition($issueKey, $transition);
        } catch (JiraException $e) {
            $this->logger->error($e->getTraceAsString());
        }
    }
}