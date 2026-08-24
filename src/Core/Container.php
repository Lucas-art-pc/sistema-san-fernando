<?php

namespace App\Core;

use ReflectionClass;
use ReflectionNamedType;
use Exception;

class Container
{
    /** @var array<string, mixed> Instâncias já resolvidas/registradas manualmente */
    private array $instances = [];

    /**
     * Registra uma instância pronta para uma classe/interface
     * (usado para coisas que o Reflection não sabe construir sozinho, como o PDO).
     */
    public function set(string $id, mixed $instance): void
    {
        $this->instances[$id] = $instance;
    }

    /**
     * Resolve uma classe, instanciando recursivamente suas dependências.
     */
    public function make(string $class): object
    {
        if (isset($this->instances[$class])) {
            return $this->instances[$class];
        }

        if (!class_exists($class)) {
            throw new Exception("Classe {$class} não encontrada.");
        }

        $reflection = new ReflectionClass($class);

        if (!$reflection->isInstantiable()) {
            throw new Exception("Classe {$class} não pode ser instanciada.");
        }

        $constructor = $reflection->getConstructor();

        if (!$constructor) {
            return new $class();
        }

        $dependencies = [];

        foreach ($constructor->getParameters() as $param) {
            $type = $param->getType();

            if ($type instanceof ReflectionNamedType && !$type->isBuiltin()) {
                // Dependência é uma classe/interface: resolve recursivamente
                $dependencies[] = $this->make($type->getName());
            } elseif ($param->isDefaultValueAvailable()) {
                $dependencies[] = $param->getDefaultValue();
            } else {
                throw new Exception(
                    "Não foi possível resolver o parâmetro '\${$param->getName()}' de {$class}. " .
                    "Registre a dependência manualmente com \$container->set()."
                );
            }
        }

        return $reflection->newInstanceArgs($dependencies);
    }
}