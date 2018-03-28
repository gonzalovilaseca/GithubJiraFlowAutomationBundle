<?php

namespace Gvf\Bundle\FlowAutomationBundle\Parameter\Resolvers;

use Gvf\Bundle\FlowAutomationBundle\Github\GithubRequestDto;

/**
 * @author Gonzalo Vilaseca <gonzalo.vilaseca@reiss.com>
 */
class DtoResolver implements ParameterResolverInterface
{
    public function resolve(GithubRequestDto $dto, array $parameters)
    {
        return $dto;
    }
}