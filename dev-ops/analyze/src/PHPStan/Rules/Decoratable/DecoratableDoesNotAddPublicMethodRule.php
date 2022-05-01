<?php declare(strict_types=1);

namespace Shopware\Development\Analyze\PHPStan\Rules\Decoratable;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use Shopware\Development\Analyze\PHPStan\Rules\AnnotationBasedRuleHelper;

class DecoratableDoesNotAddPublicMethodRule implements Rule
{
    public function getNodeType(): string
    {
        return ClassMethod::class;
    }

    /**
     * @param ClassMethod $node
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (!$scope->isInClass()) {
            // skip
            return [];
        }

        $class = $scope->getClassReflection();
        if ($class === null || !AnnotationBasedRuleHelper::isClassTaggedWithAnnotation($class, AnnotationBasedRuleHelper::DECORATABLE_ANNOTATION)) {
            return [];
        }

        if (!$node->isPublic() || $node->isMagic()) {
            return [];
        }

        $method = $class->getMethod($node->name->name, $scope);

        if ($method->getPrototype()->getDeclaringClass()->isInterface()) {
            return [];
        }

        return [
            sprintf(
                'The service "%s" is marked as "@Decoratable", but adds public method "%s", that is not defined by any Interface.',
                $class->getName(),
                $method->getName()
            ),
        ];
    }
}
