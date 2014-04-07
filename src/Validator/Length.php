<?php
namespace Gajus\Vlad\Validator;

/**
 * @link https://github.com/gajus/vlad for the canonical source repository
 * @license https://github.com/gajus/vlad/blob/master/LICENSE BSD 3-Clause
 */
class Length extends \Gajus\Vlad\Validator {
	static protected
		$default_options = [
			'min' => null,
			'max' => null
		],
		$messages = [
			'min' => [
				'{vlad.subject.name} must be at least {vlad.validator.options.min} characters long.',
				'The input must be at least {vlad.validator.options.min} characters long.'
			],
			'max' => [
				'{vlad.subject.name} must be at most {vlad.validator.options.max} characters long.',
				'The input must be at most {vlad.validator.options.max} characters long.'
			],
			'between' => [
				'{vlad.subject.name} must be between {vlad.validator.options.min} and {vlad.validator.options.max} characters long.',
				'The input must be between {vlad.validator.options.min} and {vlad.validator.options.max} characters long.'
			],
		];

	public function __construct (array $options = []) {
		parent::__construct($options);

		$options = $this->getOptions();

		if (!isset($options['min']) && !isset($options['max'])) {
			throw new \Gajus\Vlad\Exception\InvalidArgumentException('"min" and/or "max" option is required.');
		}
		
		if (isset($options['min']) && !ctype_digit((string) $options['min'])) {
			throw new \Gajus\Vlad\Exception\InvalidArgumentException('"min" option must be a whole number.');
		}
		
		if (isset($options['max']) && !ctype_digit((string) $options['max'])) {
			throw new \Gajus\Vlad\Exception\InvalidArgumentException('"max" option must be a whole number.');
		}
		
		if (isset($options['min'], $options['max']) && $options['min'] > $options['max']) {
			throw new \Gajus\Vlad\Exception\InvalidArgumentException('"min" option cannot be greater than "max".');
		}
	}

	protected function validate (\Gajus\Vlad\Subject $subject) {
		$value = $subject->getValue();

		$options = $this->getOptions();
		
		if (!is_string($value)) {
			throw new \Gajus\Vlad\Exception\InvalidArgumentException('Value is expected to be string. "' . gettype($value) . '" given instead.');
		}
		
		if (isset($options['min'], $options['max']) && (mb_strlen($value) < $options['min'] || mb_strlen($value) > $options['max'])) {
			return 'between';
		} else if (isset($options['min']) && mb_strlen($value) < $options['min']) {
			return 'min';
		} else if (isset($options['max']) && mb_strlen($value) > $options['max']) {
			return 'max';
		}
	}
}
