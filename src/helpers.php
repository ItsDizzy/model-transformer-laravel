<?php

if ( ! function_exists('transform')) {
    function transform()
    {
        $args = func_get_args();

        if (!isset($args[0]))
            throw new \Dizzy\Transformer\Exceptions\TransformerException('Argument 1 of the transform function is missing.');

        if ($args[0] instanceof \Illuminate\Database\Eloquent\Model) {
            $model = $args[0];
        } else if ($args[0] instanceof \Illuminate\Support\Collection) {
            $model = $args[0]->first();
        } else {
            throw new \Dizzy\Transformer\Exceptions\TransformerException('Argument 1 of the transform function must be an instance of Model or Collection.');
        }

        if (!$model) {
            throw new \Dizzy\Transformer\Exceptions\TransformerException('Argument 1 of the transform function has an empty Collection.');
        }

        $reflector = new ReflectionClass($model);
        $transformerName = "{$reflector->getShortName()}Transformer";
        $transformerPath = config('transformer.namespace') . '\\' . $transformerName;

        try {
            return forward_static_call_array(
                [
                    $transformerPath,
                    'transform'
                ],
                $args
            );
        } catch (ErrorException $e) {
            throw new \Dizzy\Transformer\Exceptions\TransformerException($transformerPath . ' can not be found.');
        }
    }
}