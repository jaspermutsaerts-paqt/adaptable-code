<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->path([
        '/^app/',
        '/^database/',
        '/^routes/',
        '/^tests/',
        '/^lang/',
       '/^config/',
    ]);

return (new PhpCsFixer\Config())
    ->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect())
    ->setRiskyAllowed(true)
    ->setFinder($finder)
    ->setRules([
        'psr_autoloading'             => true,
        '@PSR12'                      => true,
        'array_syntax'                => ['syntax' => 'short'],
        'class_attributes_separation' => [
            'elements' => [
                'method' => 'one',
            ],
        ],
        'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],
        'single_quote'                           => true,
        'binary_operator_spaces'                 => [
            'default'   => 'single_space',
            'operators' => [
                '=>' => 'align_single_space_minimal',
            ],
        ],
        'blank_line_after_opening_tag' => true,
        'blank_line_before_statement'  => [
            'statements' => ['return'],
        ],
        'cast_spaces'                        => true,
        'concat_space'                       => ['spacing' => 'one'],
        'declare_equal_normalize'            => true,
        'declare_strict_types'               => true,
        'type_declaration_spaces'            => true,
        'single_line_comment_style'          => true,
        'include'                            => true,
        'lowercase_cast'                     => true,
        'native_function_casing'             => true,
        'increment_style'                    => ['style' => 'post'],
        'new_with_parentheses'               => true,
        'no_blank_lines_after_class_opening' => true,
        'no_blank_lines_after_phpdoc'        => true,
        'no_empty_phpdoc'                    => true,
        'no_empty_statement'                 => true,
        'no_extra_blank_lines'               => [
            'tokens' => [
                'curly_brace_block',
                'extra',
                'parenthesis_brace_block',
                'square_brace_block',
                'throw',
                'use',
            ],
        ],
        'no_leading_import_slash'                     => true,
        'no_leading_namespace_whitespace'             => true,
        'no_mixed_echo_print'                         => ['use' => 'echo'],
        'no_multiline_whitespace_around_double_arrow' => true,
        'no_short_bool_cast'                          => true,
        'no_singleline_whitespace_before_semicolons'  => true,
        'no_spaces_around_offset'                     => true,
        'no_trailing_comma_in_singleline'             => true,
        'no_unneeded_control_parentheses'             => true,
        'no_unused_imports'                           => true,
        'no_useless_else'                             => true,
        'no_useless_return'                           => true,
        'no_whitespace_before_comma_in_array'         => true,
        'no_whitespace_in_blank_line'                 => true,
        'normalize_index_brace'                       => true,
        'object_operator_without_whitespace'          => true,
        'phpdoc_align'                                => [
            'tags' => [
                'param',
                'return',
                'throws',
                'type',
                'var',
            ],
        ],
        'phpdoc_annotation_without_dot'      => true,
        'phpdoc_indent'                      => true,
        'phpdoc_no_access'                   => true,
        'phpdoc_no_alias_tag'                => true,
        'phpdoc_no_empty_return'             => false,
        'phpdoc_no_package'                  => true,
        'phpdoc_no_useless_inheritdoc'       => true,
        'phpdoc_return_self_reference'       => true,
        'phpdoc_scalar'                      => true,
        'phpdoc_single_line_var_spacing'     => true,
        'phpdoc_summary'                     => true,
        'phpdoc_to_comment'                  => ['ignored_tags' => ['todo', 'var']],
        'phpdoc_trim'                        => true,
        'phpdoc_types'                       => true,
        'phpdoc_var_without_name'            => true,
        'return_type_declaration'            => ['space_before' => 'none'],
        'self_accessor'                      => true,
        'short_scalar_cast'                  => true,
        'single_class_element_per_statement' => true,
        'simplified_null_return'             => true,
        'space_after_semicolon'              => true,
        'standardize_not_equals'             => true,
        'trailing_comma_in_multiline'        => [
            'elements' => ['arrays'],
        ],
        'trim_array_spaces'               => true,
        'void_return'                     => true,
        'whitespace_after_comma_in_array' => true,
        'no_space_around_double_colon'    => false,

        // Additions from standard for higher PHP versions:
        '@PHP82Migration:risky' => true,
        '@PHP81Migration'       => true,
        '@PHP80Migration:risky' => true,
        'visibility_required'   => true,
        'use_arrow_functions'   => false,
    ])
    ->setLineEnding("\n");
