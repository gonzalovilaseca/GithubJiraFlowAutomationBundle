<?php

namespace Gvf\Bundle\FlowAutomationBundle\Parameter\Resolvers;

use Gvf\Bundle\FlowAutomationBundle\Github\GithubRequestDto;

/**
 * @author Gonzalo Vilaseca <gonzalo.vilaseca@reiss.com>
 */
interface ParameterResolverInterface
{
//    check resolvers implement thisinterface!
    public function resolve(GithubRequestDto $dto, array $parameters);
}