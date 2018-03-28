@github
Feature:
    In order to make dev life easier
    As a dev
    I want to automate some github and jira lables and transitions

    Scenario: It transitions Jira Issue to "In progress" when a branch created on Github
        When I send a Github request of type "create" and body "BranchCreated.payload" to "/"
        Then the response code should be "200"
        And transition with id "311" should have been done in Jira

    Scenario: It creates a "Needs Code Review" label and transitions JIRA when a PR is created
        Given The Github api is ready for "NewPr.payload"
        When I send a Github request of type "pull_request" and body "NewPr.payload" to "/"
        Then the response code should be "200"
        And a "Needs Code Review" label should have been added in Github
        And transition with id "21" should have been done in Jira

    Scenario: It adds "Awaiting Rework" label in Github and adds "failed-code-review" label in Jira when changes are requested on a PR
        Given The Github api is ready for "NeedsRework.payload"
        When I send a Github request of type "pull_request_review" and body "NeedsRework.payload" to "/"
        Then the response code should be "200"
        And a "Awaiting Rework" label should have been replaced in Github
        And label "failed-code-review" should have been added in Jira

    Scenario: It adds "Code Approved" label and transtions jira to "Tech Approved" when a PR is approved
        Given The Github api is ready for "CodeApproved.payload"
        When I send a Github request of type "pull_request_review" and body "CodeApproved.payload" to "/"
        Then the response code should be "200"
        And a "Needs QA Review" label should have been replaced in Github
        And transition with id "241" should have been done in Jira

    Scenario: It transitions Jira to 'QA' state when 'In QA' label is added on github
        When I send a Github request of type "pull_request" and body "InQaLabelAdded.payload" to "/"
        Then the response code should be "200"
        And transition with id "251" should have been done in Jira

    Scenario: It adds "failed-qa" label in Jira when 'QA Failed' label is added on github
        When I send a Github request of type "pull_request" and body "QaFailedLabelAdded.payload" to "/"
        Then the response code should be "200"
        And label "failed-qa" should have been added in Jira

    Scenario: It transitions Jira to 'QA approved/pending deploy to UAT' state when 'QA Approved' label is added on github
        When I send a Github request of type "pull_request" and body "QaApprovedLabelAdded.payload" to "/"
        Then the response code should be "200"
        And transition with id "271" should have been done in Jira
