<?php
namespace Bonami\Elastica\Connection\Strategy;

use Bonami\Elastica\Exception\InvalidException;

/**
 * Description of StrategyFactory.
 *
 * @author chabior
 */
class StrategyFactory
{
    /**
     * @param mixed|callable|string|StrategyInterface $strategyName
     *
     * @throws \Bonami\Elastica\Exception\InvalidException
     *
     * @return \Bonami\Elastica\Connection\Strategy\StrategyInterface
     */
    public static function create($strategyName)
    {
        if ($strategyName instanceof StrategyInterface) {
            return $strategyName;
        }

        if (CallbackStrategy::isValid($strategyName)) {
            return new CallbackStrategy($strategyName);
        }

        if (is_string($strategyName)) {
            $requiredInterface = '\\Bonami\\Elastica\\Connection\\Strategy\\StrategyInterface';
            $predefinedStrategy = '\\Bonami\\Elastica\\Connection\\Strategy\\'.$strategyName;

            if (class_exists($predefinedStrategy) && class_implements($predefinedStrategy, $requiredInterface)) {
                return new $predefinedStrategy();
            }

            if (class_exists($strategyName) && class_implements($strategyName, $requiredInterface)) {
                return new $strategyName();
            }
        }

        throw new InvalidException('Can\'t create strategy instance by given argument');
    }
}
