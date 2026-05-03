<?php

declare(strict_types=1);

namespace Larapgrader\Container;

/**
 * Factory for creating configured ServiceContainer instances.
 * (A6: Use PHP-DI for Service Container)
 */
class ContainerFactory
{
    /**
     * Create and configure a ServiceContainer instance.
     *
     * @param array $overrides Optional array of service overrides for testing
     * @return ServiceContainer Configured container instance
     */
    /**
     * @param array<string, mixed> $overrides
     */
    public static function create(array $overrides = []): ServiceContainer
    {
        $serviceContainer = new ServiceContainer();

        // Default interface-to-implementation map (placeholder implementations for now).
        $definitions = [
            \Larapgrader\Contracts\AstParserInterface::class => \Larapgrader\AST\AstParser::class,
            \Larapgrader\Contracts\SymbolIndexInterface::class => \Larapgrader\AST\SymbolIndex::class,
            \Larapgrader\Contracts\ConfidenceScorerInterface::class => \Larapgrader\Confidence\ConfidenceScorer::class,
            \Larapgrader\Contracts\BlastRadiusCalculatorInterface::class => \Larapgrader\Analysis\BlastRadiusCalculator::class,
            \Larapgrader\Contracts\ContractParserInterface::class => \Larapgrader\Contract\ContractParser::class,
            \Larapgrader\Contracts\RuleRegistryInterface::class => \Larapgrader\Rules\RuleRegistry::class,
            \Larapgrader\Contracts\StateRegistryInterface::class => \Larapgrader\State\StateRegistry::class,
            \Larapgrader\Contracts\AuditTrailInterface::class => \Larapgrader\Audit\AuditTrail::class,
            \Larapgrader\Contracts\KnowledgeBaseInterface::class => \Larapgrader\Knowledge\KnowledgeBase::class,
            \Larapgrader\Contracts\CliCommandInterface::class => \Larapgrader\CLI\CliCommand::class,
            \Larapgrader\Contracts\FileManagerInterface::class => \Larapgrader\Files\FileManager::class,
            \Larapgrader\Contracts\OllamaProviderInterface::class => \Larapgrader\LLM\OllamaProvider::class,
            \Larapgrader\Contracts\ProcessFactoryInterface::class => \Larapgrader\LLM\ProcessFactory::class,
            \Larapgrader\Contracts\OllamaCliInterface::class => \Larapgrader\LLM\OllamaCliService::class,
            \Larapgrader\Contracts\OnboardingWizardInterface::class => \Larapgrader\Onboarding\FirstRunWizard::class,
        ];

        // Apply overrides (for testing flexibility)
        foreach ($overrides as $key => $value) {
            $definitions[$key] = $value;
        }

        foreach ($definitions as $id => $definition) {
            $serviceContainer->set($id, $definition);
        }

        return $serviceContainer;
    }
}
