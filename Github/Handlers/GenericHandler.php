<?php

namespace Gvf\Bundle\FlowAutomationBundle\Github\Handlers;

use Gvf\Bundle\FlowAutomationBundle\Github\Deciders\DeciderInterface;
use Gvf\Bundle\FlowAutomationBundle\Github\GithubRequestDto;

/**
 * @author Gonzalo Vilaseca <gonzalo.vilaseca@reiss.com>
 */
class GenericHandler implements GithubHandlerInterface
{
    /**
     * @var DeciderInterface
     */
    private $decider;

    /**
     * @var array
     */
    private $actions;

    /**
     * @var array
     */
    private $parameterResolvers;

    /**
     * @param array $decider
     * @param array $actions
     */
    public function __construct(array $decider, array $actions, array $parameterResolvers)
    {
        $this->actions            = $actions;
        $this->decider            = $decider;
        $this->parameterResolvers = $parameterResolvers;
    }

    /**
     * @param GithubRequestDto $dto
     *
     * @throws \HttpException
     */
    public function handle(GithubRequestDto $dto)
    {

        if (!call_user_func_array([$this->decider['id'], 'applies'], [$dto, $this->decider['options']])) {
            return;
        }
        foreach ($this->actions as $action) {

            foreach ($action['parameters'] as $key => $parameter) {
                if (array_key_exists($key, $this->parameterResolvers)) {
                    $action['parameters'][$key] = $this->parameterResolvers[$key]->resolve($dto, $action['parameters']);
                }
            }

            call_user_func_array([$action['service']['id'], $action['service']['method']], $action['parameters']);
        }
    }
}
