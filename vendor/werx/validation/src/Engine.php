<?php

namespace werx\Validation;

use \Exception;
use \InvalidArgumentException;

class Engine
{
	public $validator;
	public $fields;
	public $errors;
	public $messages;
	public $data;

	public function __construct($validator = null, $language='en')
	{
		if (empty($validator)) {
			// Use the default validation engine.
			$this->validator = new Validator();
		} else {
			$this->validator = $validator;
		}

		// Initialize default values for class variables.
		$this->reset();

		$language_file = sprintf('languages/%s.php', basename(strtolower($language)));

		if (!@include_once($language_file)) {
		    throw new \Exception("Specified language doesn't exist");
		}

		$this->loadDefaultMessages($language);
	}

	public function parseRule($input)
	{
		$return = [];

		# Split the string on pipe to get individual rules.
		$rules = explode('|', $input);

		foreach ($rules as $r) {

			$rule_name = $r;
			$rule_params = [];

			// For each rule in the list, see if it has any parameters. Example: minlength[5].
			if (preg_match('/\[(.*?)\]/', $r, $matches)) {

				// This one has parameters. Split out the rule name from it's parameters.
				$rule_name = substr($r, 0, strpos($r, '['));

				// There may be more than one parameters.
				$rule_params = explode(',', $matches[1]);
			} elseif (preg_match('/\{(.*?)\}/', $r, $matches)) {
				// This one has an array parameter. Split out the rule name from it's parameters.
				$rule_name = substr($r, 0, strpos($r, '{'));

				// There may be more than one parameter.
				$rule_params = array(explode(',', $matches[1]));
			}

			$return[$rule_name] = $rule_params;
		}

		return $return;
	}

	public function addRuleSet($ruleset)
	{
		if (!is_subclass_of($ruleset, 'werx\Validation\Ruleset')) {
			throw new InvalidArgumentException('ruleset must be a subclass of werx\Validation\Ruleset');
		}

		foreach ($ruleset->rules as $rule) {
			$this->addRule($rule['field'], $rule['label'], $rule['rules']);
		}
	}

	public function addRule($field = null, $label = null, $rules = null)
	{
		if (empty($field) || empty($label) || empty($rules)) {
			throw new InvalidArgumentException('Field, Label, and Rules are required.');
		}

		// Add this field to our list of fields (unless it already exists).
		if (!array_key_exists($field, $this->fields)) {
			$this->fields[$field] = ['label' => $label];
		}

		if ($rules instanceof \Closure) {
			$closure = $rules;
			$this->fields[$field]['rules'][] = $closure;
		} else {
			$rules = $this->parseRule($rules);

			foreach ($rules as $rule => $params) {

				if (count($params) > 0) {
					foreach ($params as $param) {
						$this->fields[$field]['rules'][$rule]['params'][] = $param;
					}
				} else {
					$this->fields[$field]['rules'][$rule]['params'] = [];
				}
			}
		}
	}

	public function validate($data = [])
	{
		$this->data = $data;

		foreach ($this->fields as $id => $attributes) {

			if (strpos($id, '.') > 0) {
				// We are dealing with an array.
				list($parent, $child) = explode('.', $id);
				$input = isset($data[$parent][$child]) ? $data[$parent][$child] : null;
			} else {
				$input = array_key_exists($id, $data) ? $data[$id] : null;
			}


			$label = $attributes['label'];

			foreach ($attributes['rules'] as $method => $opts) {

				if ($opts instanceof \Closure) {
					list($success, $message) = $opts($this->data, $id, $label);

					if (!$success) {
						$this->errors[$id][] = $message;
					}
				} else {
					$args = [];
					$args[] = $input;

					foreach ($opts['params'] as $param) {
						$args[] = $param;
					}

					$success = call_user_func_array([$this->validator, $method], $args);

					if (!$success) {
						$this->errors[$id][] = $this->getMessage($label, $method, $opts['params']);
					}
				}
			}
		}

		return $this->hasErrors() ? false : true;
	}

	public function getErrorSummary()
	{
		$summary = [];

		foreach ($this->errors as $field => $messages) {
			foreach ($messages as $message) {
				$summary[] = $message;
			}
		}
		return $summary;
	}

	public function getErrorSummaryFormatted($outerwrapper = ['<div class="alert alert-danger"><ul>','</ul></div>'], $innerwrapper = ['<li>','</li>'])
	{
		$summary = $this->getErrorSummary();

		if (count($summary) > 0) {
			$formatted = [];

			$formatted[] = $outerwrapper[0];

			foreach ($summary as $s) {
				$formatted[] = $innerwrapper[0];
				$formatted[] = $s;
				$formatted[] = $innerwrapper[1];
			}

			$formatted[] = $outerwrapper[1];

			return join($formatted, PHP_EOL);

		} else {
			return null;
		}
	}

	public function getErrorDetail()
	{
		$detail = [];

		foreach ($this->errors as $field => $messages) {
			$detail[] = ['field' => $field, 'messages' => $messages];
		}

		return $detail;
	}

	public function getErrorFields()
	{
		$fields = [];

		foreach ($this->errors as $field => $messages) {
			$fields[] = $field;
		}
		return $fields;

	}

	public function getRequiredFields()
	{
		$required = [];

		foreach ($this->fields as $field => $attributes) {
			if (array_key_exists('required', $attributes['rules'])) {
				$required[] = $field;
			}
		}

		return $required;
	}

	public function loadDefaultMessages($language)
	{
		require 'languages/'.$language.'.php';

		foreach ($messages as $key => $value) {
			$this->messages[$key] = $value;
		}
	}

	public function addCustomMessage($validator, $message)
	{
		$this->messages[$validator]	= $message;
	}

	public function getMessage($field, $rule, $params = [])
	{

		if (!array_key_exists($rule, $this->messages)) {
			$format = '{name} is invalid.';
		} else {
			$format = $this->messages[$rule];
		}

		$string = str_replace('{name}', $field, $format);
		return vsprintf($string, $params);
	}

	/**
	 * Are there any validation errors?
	 */
	public function hasErrors()
	{
		return (count($this->errors) > 0);
	}

	/**
	 * Retrieve a data element that was validated.
	 *
	 * Useful if you want to pass the validator into a view to prefill inputs.
	 *
	 * @access public
	 * @param mixed $field (default: null) The id of the element to return. If not provided, it will return the entire data array.
	 * @return mixed
	 */
	public function getData($field = null)
	{
		if (empty($field)) {
			// No element specified. Return all of the data that was validated.
			return $this->data;
		}

		if (!empty($this->data) && array_key_exists($field, $this->data)) {
			return $this->data[$field];
		}

		return null;
	}

	public function reset()
	{
		$this->fields = [];
		$this->errors = [];
		$this->messages = [];
		$this->data = [];
	}
}
