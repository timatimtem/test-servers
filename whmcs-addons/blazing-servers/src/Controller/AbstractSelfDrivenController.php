<?php

namespace WHMCS\Module\Blazing\Servers\Controller;

use ErrorException;
use WHMCS\Module\Blazing\Servers\Vendor\Symfony\Component\HttpFoundation\Request;
use WHMCS\Module\Blazing\Servers\Vendor\Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use WHMCS\Module\Blazing\Servers\Exception\UserFriendlyException;
use WHMCS\Module\Blazing\Servers\Logger;

abstract class AbstractSelfDrivenController
{
    final public function handleRequestAction(Request $request)
    {
        try {
            $this->beforeExecute($request);

            $action = $request->get('method');
            $method = [$this, "{$action}Action"];
            if (!is_callable($method)) {
                throw new ErrorException("Method \"$action\" is not exists");
            }

            $resolver = new ArgumentResolver(null,
                array_merge([new RequestArgumentsValueResolver()], ArgumentResolver::getDefaultArgumentValueResolvers()));

            $args = $resolver->getArguments($request, $method);
            $return = call_user_func_array($method, $args);
        } catch (\Exception $e) {
            Logger::err('API Exception', ['exception' => $e, 'trace' => $e->getTraceAsString()]);
            $return = [
                'error'   => true,
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ];

            if ($e instanceof UserFriendlyException) {
                $return['alert'] = true;
            }
        }

        return $return;
    }

    final public function handleArgumentsAction($action, array $arguments = [])
    {
        $requestAsContext = Request::createFromGlobals();

        // Remove script name to not be used
        $request = $requestAsContext;
        $request->request->add(array_merge($arguments, ['method' => $action]));

        return $this->handleRequestAction($request);
    }

    protected function beforeExecute(Request $request)
    {
    }
}
