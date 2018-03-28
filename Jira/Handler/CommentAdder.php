<?php

namespace Gvf\Bundle\FlowAutomationBundle\Jira\Handler;

use JiraRestApi\Issue\Comment;
use JiraRestApi\Issue\IssueService;

/**
 * @author Gonzalo Vilaseca <gonzalo.vilaseca@reiss.com>
 */
class CommentAdder
{
    /**
     * {@inheritdoc}
     */
    public function addComment(string $issueKey, string $body)
    {
        $comment = new Comment();

        $comment->setBody($body);

        $issueService = new IssueService();
        $issueService->addComment($issueKey, $comment);
    }
}