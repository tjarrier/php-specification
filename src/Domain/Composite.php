<?php

declare(strict_types=1);

namespace Tja\PhpSpecification\Domain;

use Tja\PhpSpecification\Domain\Exception\ParameterOverridenException;

abstract class Composite implements SpecificationInterface
{
    /**
     * @param mixed[] $specifications
     */
    public function __construct(
        protected string $operator,
        protected array $specifications
    ) {
        if (empty($specifications)) {
            throw new \LogicException('No specifications given.');
        }
    }

    abstract public function isSatisfiedBy(mixed $value): bool;

    public function getRule(): string
    {
        return implode(
            sprintf(' %s ', $this->operator),
            array_map(static fn(SpecificationInterface $specification): string => sprintf('(%s)', $specification->getRule()), $this->specifications)
        );
    }

    /**
     * @return mixed[][]
     */
    public function getParameters(): array
    {
        $parametersCount = 0;

        $parametersList = array_map(static function (SpecificationInterface $specification) use (&$parametersCount): array {
            $parametersCount += count($specification->getParameters());
            return $specification->getParameters();
        }, $this->specifications);

        $mergedParameters = array_merge([], ...$parametersList);

        if ($parametersCount !== count($mergedParameters)) {
            $overridenParameters = $this->searchOverridenParameters($parametersList);
            $specificationsTypes = array_map(static fn(Specification $specification) => $specification::class, $this->specifications);

            throw new ParameterOverridenException(sprintf(
                'Looks like some parameters were overriden (%s) while combining specifications of types %s',
                implode(', ', $overridenParameters),
                implode(', ', $specificationsTypes)
            ));
        }

        return $mergedParameters;
    }

    /**
     * Search the parameters that were overridden during the parameters-merge phase.
     *
     * @return array Names of the overridden parameters.
     */
    private function searchOverridenParameters(array $parametersList): array
    {
        $parametersUsageCount = [];

        foreach ($parametersList as $list) {
            foreach ($list as $parameter => $_value) {
                if (!isset($parametersUsageCount[$parameter])) {
                    $parametersUsageCount[$parameter] = 0;
                }

                ++$parametersUsageCount[$parameter];
            }
        }

        $overriddenParameters = array_filter($parametersUsageCount, static fn($count): bool => $count > 1);

        return array_keys($overriddenParameters);
    }
}
