<?php

namespace WHMCS\Module\Blazing\Servers\Controller;

use WHMCS\Module\Blazing\Servers\Vendor\Symfony\Component\HttpFoundation\Request;
use WHMCS\Module\Blazing\Servers\Vendor\Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use WHMCS\Module\Blazing\Servers\Vendor\Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class RequestArgumentsValueResolver implements ArgumentValueResolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return !$argument->isVariadic() && null !== $request->get($argument->getName());
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        yield $request->get($argument->getName());
    }
}
