<?php


namespace WhoJonson\LaravelOrganizer\Traits;


use WhoJonson\LaravelOrganizer\Exceptions\InvalidClassException;
use WhoJonson\LaravelOrganizer\Repositories\Repository;

trait CommandGenerator
{
    /**
     * Replace the namespace for the given stub.
     *
     * @param string $stub
     * @param string $name
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name) {
        $searches = [
            ['DummyNamespace', 'DummyRootNamespace', 'NamespacedDummyUserModel'],
            ['{{ namespace }}', '{{ rootNamespace }}', '{{ namespacedUserModel }}'],
            ['{{namespace}}', '{{rootNamespace}}', '{{namespacedUserModel}}']
        ];

        foreach ($searches as $search) {
            $stub = str_replace(
                $search,
                [$this->getNamespace($name), $this->rootNamespace(), $this->userProviderModel()],
                $stub
            );
        }

        return $this;
    }

    /**
     * Get the full namespace for a base class for extending
     *
     * @param string $default
     * @param string|null $className
     *
     * @return string
     * @throws InvalidClassException
     */
    protected function getBaseNamespacedClass(string $default, ?string $className) : string {
        if(!$className || $className == $default) {
            return $default;
        }
        if (is_subclass_of($className, $default)) {
            return $className;
        }
        throw new InvalidClassException('"' . $className . '" must extend "\\' . $default . '"');
    }

}