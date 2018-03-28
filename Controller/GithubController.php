<?php

namespace Gvf\Bundle\FlowAutomationBundle\Controller;

use Gvf\Bundle\FlowAutomationBundle\Github\GithubHandler;
use Gvf\Bundle\FlowAutomationBundle\Github\GithubRequestValidator;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Gonzalo Vilaseca <gonzalo.vilaseca@reiss.com>
 */
class GithubController
{
    /**
     * @var GithubHandler
     */
    private $githubHandler;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var GithubRequestValidator
     */
    private $githubRequestValidator;

    public function __construct(
        GithubHandler $githubHandler,
        GithubRequestValidator $githubRequestValidator,
        LoggerInterface $logger
    ) {
        $this->githubHandler          = $githubHandler;
        $this->githubRequestValidator = $githubRequestValidator;
        $this->logger                 = $logger;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function pullRequestAction(Request $request)
    {
        try {
            if (!$dto = $this->githubRequestValidator->validate($request)) {
                throw new \Exception('Invalid github request');
            }

            $this->githubHandler->handle($dto);
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage() . '.' . $e->getTraceAsString());

            return new Response($e->getMessage(), 400);
        }

        return new Response();
    }
}