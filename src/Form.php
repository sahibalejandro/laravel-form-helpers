<?php

namespace Sahib\Form;

use Illuminate\Session\Store;
use Illuminate\Database\Eloquent\Model;

class Form
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * @var \Illuminate\Session\Store
     */
    protected $session;

    /**
     * Form constructor.
     *
     * @param \Illuminate\Session\Store $session
     */
    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Set the model to use for the current form.
     *
     * @param \Illuminate\Database\Eloquent\Model|null $model
     */
    public function model(Model $model = null)
    {
        $this->model = $model;
    }

    /**
     * Get the text for a textarea field.
     *
     * @param  string $name
     * @param  mixed|null $default
     * @return string
     */
    public function text($name, $default = null)
    {
        return e($this->value($name, $default));
    }

    /**
     * Get the attributes for an input field.
     *
     * @param  string  $name
     * @param  mixed|null  $default
     * @return string
     */
    public function input($name, $default = null)
    {
        $value = e($this->value($name, $default));
        $name = e($name);

        return "name=\"$name\" value=\"$value\"";
    }

    /**
     * Get the attributes for a checkbox.
     *
     * @param  string $name
     * @param  mixed $inputValue
     * @param  bool $checkByDefault
     * @return string
     */
    public function checkbox($name, $inputValue = 1, $checkByDefault = false)
    {
        $value = $this->value($name);

        // Define the state for the checkbox, when $value is null then we
        // use the $checkByDefault value directly, otherwise the checkbox will
        // be checked only if the $value is equal to the $inputValue.
        if (is_null($value)) {
            $checked = $checkByDefault;
        } else {
            $checked = $value == $inputValue;
        }

        $name = e($name);
        $inputValue = e($inputValue);
        $checked = $checked ? ' checked' : '';

        return "name=\"$name\" value=\"$inputValue\"$checked";
    }

    /**
     * Get the attributes for a radio.
     *
     * @param  string $name
     * @param  mixed $inputValue
     * @param  bool $checkByDefault
     * @return string
     */
    public function radio($name, $inputValue = 1, $checkByDefault = false)
    {
        return $this->checkbox($name, $inputValue, $checkByDefault);
    }

    /**
     * Get the options for a select.
     *
     * @param  array $options
     * @param  string $name
     * @param  mixed|null $default
     * @param  string|null $placeholder
     * @return string
     */
    public function options($options, $name, $default = null, $placeholder = null)
    {
        $tags = [];

        // Prepend the placeholder to the options list if needed.
        if ($placeholder) {
            $tags[] = '<option value="" selected disabled>'.e($placeholder).'</option>';
        }

        $value = $this->value($name, $default);

        foreach ($options as $key => $text) {

            $selected = $value == $key ? ' selected' : '';
            $key = e($key);
            $text = e($text);

            $tags[] = "<option value=\"$key\"$selected>$text</option>";
        }

        return implode($tags);
    }

    /**
     * Get the error message if exists.
     *
     * @param  string $name
     * @param  string|null $template
     * @return string|null
     */
    public function error($name, $template = null)
    {
        $errors = $this->session->get('errors');

        // Default template is bootstrap friendly.
        if (is_null($template)) {
            $template = '<div class="help-block">:message</div>';
        }

        if ($errors && $errors->has($name)) {
            return str_replace(':message', $errors->first('name'), $template);
        }
    }

    /**
     * Get the value to use in an input field.
     *
     * @param  string $name
     * @param  mixed|null $default
     * @return mixed|null
     */
    protected function value($name, $default = null)
    {
        if ($value = $this->valueFromOld($name)) {
            return $value;
        }

        if ($value = $this->valueFromModel($name)) {
            return $value;
        }

        return $default;
    }

    /**
     * Get the value from old input.
     *
     * @param  string $name
     * @return mixed|null
     */
    protected function valueFromOld($name)
    {
        return $this->session->getOldInput($name);
    }

    /**
     * Get the value from the model.
     *
     * @param  string $name
     * @return mixed|null
     */
    protected function valueFromModel($name)
    {
        if (! $this->model) {
            return null;
        }

        return $this->model->getAttribute($name);
    }
}
