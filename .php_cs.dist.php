<?php

$finder = Symfony\Component\Finder\Finder::create()
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return ( new PhpCsFixer\Config() )
    ->setRules(
        [
            '@PSR12' => true,
            'array_syntax' => ['syntax' => 'short'],
            'ordered_imports' => ['sort_algorithm' => 'alpha'],
            'braces' => [
                'allow_single_line_anonymous_class_with_empty_body' => true,
            ],
            'no_unused_imports' => true,
            'not_operator_with_successor_space' => true,
            'trailing_comma_in_multiline' => true,
            'phpdoc_scalar' => true,
            'unary_operator_spaces' => true,
            'binary_operator_spaces' => true,
            'phpdoc_single_line_var_spacing' => true,
            'phpdoc_var_without_name' => true,
            'class_attributes_separation' => [
                'elements' => [
                    'method' => 'one',
                ],
            ],
            'method_argument_space' => [
                'on_multiline' => 'ensure_fully_multiline',
                'keep_multiple_spaces_after_comma' => true,
            ],
            'single_trait_insert_per_statement' => true,
            'array_push' => true,
            'backtick_to_shell_exec' => true,
            'ereg_to_preg' => true,
            'no_alias_language_construct_call' => true,
            'no_mixed_echo_print' => true,
            'pow_to_exponentiation' => true,
            'random_api_migration' => true,
            'set_type_to_cast' => true,
            'array_indentation' => true,
            'blank_line_before_statement' => [
                'statements' => ['break', 'continue', 'declare', 'return', 'throw', 'try', 'do', 'exit', 'goto', 'if', 'switch', 'yield'],
                // Check for support with if conditions and early returns in a function
            ],
            'compact_nullable_typehint' => true,
            'heredoc_indentation' => true,
            'line_ending' => true,
            'method_chaining_indentation' => true, // Check for support with chained methods
            'no_extra_blank_lines' =>
                [
                    'tokens' => ['continue', 'curly_brace_block', 'extra', 'return', 'parenthesis_brace_block', 'square_brace_block', 'throw', 'use', 'switch', 'case', 'default',],
                ],
            'no_trailing_whitespace' => true,
            'types_spaces' => [
                'space' => 'none',
            ],
            'no_multiline_whitespace_around_double_arrow' => true,
            'no_whitespace_before_comma_in_array' => ['after_heredoc' => true],
            'normalize_index_brace' => true,
            'trim_array_spaces' => true,
            'whitespace_after_comma_in_array' => true,
        ]
    )
    ->setFinder($finder);
