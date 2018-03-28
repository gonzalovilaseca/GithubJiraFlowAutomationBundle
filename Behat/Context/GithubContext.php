<?php

namespace Gvf\Bundle\FlowAutomationBundle\Behat\Context;

use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Github\Client;
use Gvf\Bundle\FlowAutomationBundle\Github\PayloadHashCalculator;
use PHPUnit\Framework\Assert;

/**
 * @author Gonzalo Vilaseca <gonzalo.vilaseca@reiss.com>
 */
class GithubContext extends MinkContext implements KernelAwareContext
{
    use KernelDictionary;

    /**
     * @var PayloadHashCalculator
     */
    private $payloadHashCalculator;

    /**
     * @var string
     */
    private $payloadPath;

    /**
     * @param PayloadHashCalculator $payloadHashCalculator
     * @param string                $payloadPath
     */
    public function __construct(
        PayloadHashCalculator $payloadHashCalculator,
        string $payloadPath
    ) {
        $this->payloadHashCalculator = $payloadHashCalculator;
        $this->payloadPath           = $payloadPath;
    }

    /**
     * @Given The Github api is ready for :payload
     */
    public function theGithubApiIsReadyFor($payload)
    {
        $githubClientProphecy = $this->getContainer()->get('Github\Client.prophecy');
        $githubClientProphecy->authenticate('de2b5296e0482756ed790607ba29b1a0b21a6d37', null, Client::AUTH_HTTP_TOKEN)->willReturn();
        $issue = $this->getContainer()->get('Github\Api\Issue.prophecy');
        $githubClientProphecy->api('issue')->willReturn($issue);
        $label = $this->getContainer()->get('Github\Api\Issue\Labels.prophecy');
        $issue->labels()->willReturn($label);
    }

    /**
     * @Then a :githubLabel label should have been added in Github
     */
    public function aLabelShouldHaveBeenAddedInGithub($githubLabel)
    {
        $githubClientProphecy = $this->getContainer()->get('gh_label_adder.prophecy');
        $githubClientProphecy->addLabel('4160', $githubLabel)->shouldHaveBeenCalled();
    }

    /**
     * @Then a :githubLabel label should have been replaced in Github
     */
    public function aLabelShouldHaveBeenReplacedInGithub($githubLabel)
    {
        $githubClientProphecy = $this->getContainer()->get('gh_label_replacer.prophecy');
        $githubClientProphecy->replaceLabels('4160', $githubLabel)->shouldHaveBeenCalled();
    }

    /**
     * @Then label :label should have been added in Jira
     */
    public function labelShouldHaveBeenAddedInJira($label)
    {
        $this->getContainer()->get('jira_label_adder.prophecy')->addLabel('REISS-514', $label)->shouldHaveBeenCalled();
    }

    /**
     * @When I send a Github request of type :githubEventType and body :bodyFile to :uri
     */
    public function iSendAGithubRequestOfTypeAndBodyTo($githubEventType, $bodyFile, $uri)
    {
        $payloadPath = $this->payloadPath . DIRECTORY_SEPARATOR . $bodyFile;
        $payloadHash = $this->payloadHashCalculator->getPayloadHash('sha1', file_get_contents($payloadPath));
        $headers     = [
            'HTTP_X-GitHub-Event'    => $githubEventType,
            'HTTP_X-GitHub-Delivery' => '0cee7620-27ad-11e8-8187-7c220cc8e387',
            'HTTP_X-Hub-Signature'   => 'sha1=' . $payloadHash,
            'HTTP_Content-Type'      => 'application/json',

        ];

        $this->getSession()->getDriver()->getClient()->request('POST', $uri, [], [], $headers, file_get_contents($payloadPath));
    }

    /**
     * @Then the response code should be :responseCode
     */
    public function theResponseCodeShouldBe($responseCode)
    {
        Assert::assertEquals($responseCode, $this->getMink()->getSession()->getStatusCode());
    }

    /**
     * @Then transition with id :transitionId should have been done in Jira
     */
    public function transitionWithIdShouldHaveBeenDoneInJira($transitionId)
    {
        $this->getContainer()->get('Gvf\Bundle\FlowAutomationBundle\Jira\Handler\Transitioner.prophecy')->transition('REISS-514', $transitionId)->shouldHaveBeenCalled();
    }

    /**
     * @AfterScenario
     */
    public function cleanDB(AfterScenarioScope $scope)
    {
        $this->getContainer()->get('stub.prophet')->checkPredictions();
    }
}