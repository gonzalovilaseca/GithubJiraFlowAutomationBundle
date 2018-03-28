<?php

namespace Gvf\Bundle\FlowAutomationBundle\Parameter\Resolvers;

use Gvf\Bundle\FlowAutomationBundle\Github\GithubRequestDto;

/**
 * @author Gonzalo Vilaseca <gonzalo.vilaseca@reiss.com>
 */
class GithubPrNumberResolver implements ParameterResolverInterface
{
    public function resolve(GithubRequestDto $dto, array $parameters)
    {
        $payload = $dto->getPayload();
        return $this->get_multi($payload, $parameters['githubPrNumber']);
    }

    private function get_multi($arr, $str)
    {
        foreach (explode('|', $str) as $key) {
            if (!array_key_exists($key, $arr)) {
                return null;
            }
            $arr = $arr[$key];
        }

        return $arr;
    }
}