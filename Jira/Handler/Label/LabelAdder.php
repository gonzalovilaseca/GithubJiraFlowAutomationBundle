<?php

namespace Gvf\Bundle\FlowAutomationBundle\Jira\Handler\Label;

use JiraRestApi\Issue\IssueField;
use JiraRestApi\Issue\IssueService;

/**
 * @author Gonzalo Vilaseca <gonzalo.vilaseca@reiss.com>
 */
class LabelAdder
{
//    @todo move one level up
    /**
     * {@inheritdoc}
     */
    public function addLabel(string $issueKey, string $label)
    {
        $issueField = new IssueField(true);

        $issueField->addLabel($label);

        $issueService = new IssueService();

        $issueService->update($issueKey, $issueField);
    }

    public function clear(string $issueKey)
    {
        $issueField = new IssueField(true);

        $issueField->labels = [];

        $issueService = new IssueService();

        $issueService->update($issueKey, $issueField);
    }
}