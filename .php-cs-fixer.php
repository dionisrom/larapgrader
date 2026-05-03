<?php

declare(strict_types=1);

$srcDir = __DIR__ . '/src';
$testsDir = __DIR__ . '/tests';

$finder = PhpCsFixer\Finder::create()
    ->exclude(['vendor', 'bootstrap/cache']);

if (is_dir($srcDir)) {
    $finder->in($srcDir);
}

if (is_dir($testsDir)) {
    $finder->in($testsDir);
}

$config = new PhpCsFixer\Config();

return $config
    ->setRiskyAllowed(false)
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
        'blank_line_before_statement' => true,
        'cast_spaces' => true,
        'combine_consecutive_issets' => true,
        'combine_consecutive_unsets' => true,
        'explicit_indirect_variable' => true,
        'global_namespace_import' => true,
        'increment_style' => ['style' => 'pre'],
        'no_empty_comment' => true,
        'no_empty_phpdoc' => true,
        'no_empty_statement' => true,
        'no_extra_blank_lines' => true,
        'no_leading_import_slash' => true,
        'no_mixed_echo_print' => ['use' => 'echo'],
        'no_multiline_whitespace_around_double_arrow' => true,
        'no_short_bool_cast' => true,
        'no_spaces_after_function_name' => true,
        'no_spaces_inside_parenthesis' => true,
        'no_superfluous_elseif' => true,
        'no_superfluous_phpdoc_tags' => false,
        'no_trailing_comma_in_list_call' => true,
        'no_trailing_comma_in_singleline_array' => true,
        'no_trailing_whitespace' => true,
        'no_unneeded_control_parentheses' => true,
        'no_unneeded_curly_braces' => true,
        'no_unset_cast' => true,
        'no_unused_imports' => true,
        'nullable_type_declaration_for_default_null_value' => true,
        'object_operator_without_whitespace' => true,
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'ordered_interfaces' => true,
        'php_unit_internal_class' => false,
        'php_unit_method_casing' => ['case' => 'snake_case'],
        'php_unit_strict' => false,
        'php_unit_test_annotation' => false,
        'php_unit_test_case_static_method_calls' => false,
        'phpdoc_add_missing_param_annotation' => ['only_untyped' => false],
        'phpdoc_annotation_without_dot' => true,
        'phpdoc_indent' => true,
        'phpdoc_inline_tag_normalizer' => true,
        'phpdoc_line_span' => true,
        'phpdoc_no_access' => true,
        'phpdoc_no_alias_tag' => true,
        'phpdoc_no_empty_return' => true,
        'phpdoc_no_package' => true,
        'phpdoc_order' => true,
        'phpdoc_order_by_value' => false,
        'phpdoc_param_order' => false,
        'phpdoc_scalar' => true,
        'phpdoc_separation' => false,
        'phpdoc_single_line_var_spacing' => true,
        'phpdoc_summary' => false,
        'phpdoc_tag_casing' => true,
        'phpdoc_tag_type' => true,
        'phpdoc_to_comment' => false,
        'phpdoc_to_param_type' => false,
        'phpdoc_to_property_type' => false,
        'phpdoc_to_return_type' => false,
        'phpdoc_trim' => true,
        'phpdoc_trim_consecutive_blank_line_separation' => true,
        'phpdoc_types' => true,
        'phpdoc_types_order' => false,
        'phpdoc_var_annotation_correct_order' => true,
        'phpdoc_var_without_name' => false,
        'return_assignment' => true,
        'return_type_declaration' => ['space_before' => 'none'],
        'self_static_accessor' => true,
        'semicolon_after_instruction' => true,
        'simple_to_complex_string_variable' => false,
        'single_blank_line_at_eof' => true,
        'single_import_per_statement' => true,
        'single_line_comment_style' => ['comment_types' => ['hash']],
        'single_quote' => true,
        'single_space_around_construct' => true,
        'space_after_semicolon' => ['remove_in_empty_for_expressions' => true],
        'standardize_increment' => true,
        'standardize_not_equals' => true,
        'statement_indentation' => true,
        'strict_comparison' => false,
        'strict_param' => false,
        'string_line_ending' => false,
        'switch_case_semicolon_to_colon' => true,
        'switch_continue_to_break' => true,
        'ternary_operator_spaces' => true,
        'ternary_to_null_coalescing' => true,
        'trailing_comma_in_multiline' => ['elements' => ['arrays']],
        'trim_array_spaces' => true,
        'type_declaration_spaces' => true,
        'types_spaces' => ['space' => 'none'],
        'unary_operator_spaces' => true,
        'use_arrow_functions' => false,
        'visibility_required' => ['elements' => ['const', 'method', 'property']],
        'whitespace_after_comma_in_array' => true,
        'yoda_style' => ['equal' => true, 'identical' => true, 'less_and_greater' => false],
    ])
    ->setFinder($finder);
