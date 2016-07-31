# Laravel Form Helpers
[![Build Status](https://travis-ci.org/sahibalejandro/laravel-form-helpers.svg?branch=master)](https://travis-ci.org/sahibalejandro/laravel-form-helpers)
[![Latest Stable Version](https://poser.pugx.org/sahibalejandro/laravel-form-helpers/v/stable)](https://packagist.org/packages/sahibalejandro/laravel-form-helpers)
[![Total Downloads](https://poser.pugx.org/sahibalejandro/laravel-form-helpers/downloads)](https://packagist.org/packages/sahibalejandro/laravel-form-helpers)
[![License](https://poser.pugx.org/sahibalejandro/laravel-form-helpers/license)](https://packagist.org/packages/sahibalejandro/laravel-form-helpers)

A set of blade directives that automatically fill forms using the
[old input](https://laravel.com/docs/5.2/requests#old-input)
or an [Eloquent](https://laravel.com/docs/5.2/eloquent)
model, it also helps you to display
[validation error messages](https://laravel.com/docs/5.2/validation#working-with-error-messages)
in a clean and easy way.

## Example
See how easy is to do cool stuff with these directives, for example
if you are using [Bootstrap](https://getbootstrap.com) for your markup, you can do something like this:

```blade
<form action="/users" method="POST">

    @form($model)
    
    <div class="form-group @error('name', 'has-error')">
        <input type="text" @input('name')>
        @error('name')
    </div>
    
</form>
```

And in the case of the user is redirected back with errors,
the result will be:

```html
<form action="/users" method="POST">

    <div class="form-group has-error">
        <input type="text" name="name" value="Bad Name">
        <div class="help-block">Error message</div>
    </div>
    
</form>
```

¡It's _awesame_!

Installation
------------

Install with composer, just run the command:

```sh
composer require sahibalejandro/laravel-form-helpers
```

Then add the service provider to your `config/app.php` file:

```php
'providers' => [
    Sahib\Form\FormServiceProvider::class,
];
```

That's all.

Usage
-----

### @form

`@form([ Model $model = null ])`

Use the optional `@form` directive to bind a model to your form.  
Ignore this directive if you just want the [old input](https://laravel.com/docs/5.2/requests#old-input) binding
and no the model binding.

```blade
<form action="/users/123" method="POST">
    @form($user)
</form>
```
    
### @input

`@input(string $attribute [, string $default = null ])`

Use the `@input` directive to assign the value to an input field:

```blade
<input type="text" @input('name')>
<input type="text" @input('something', 'default')>
```

This will result in the following markup:

```html
<input type="text" name="name" value="">
<input type="text" name="something" value="default"> 
```
    
### @text

`@text(string $attribute [, string $default = null ])`

Use the `@text` directive to assign the value to a textarea field:

```blade
<textarea name="description">@text('description')</textareas>
<textarea name="bio">@text('bio', 'Default')</textareas>
```

This will result in the following markup:

```html
<textarea name="description"></textarea>
<textarea name="bio">Default</textarea>
```

### @checkbox

`@checkbox(string $attribute [, mixed $value = 1 [, boolean $checked = false ]])`

Use the `@checkbox` to set the value and the state of a checkbox:

```blade
<input type="checkbox" @checkbox('remember_me')>

<!-- With a custom value -->
<input type="checkbox" @checkbox('newsletter', 'yes')>

<!-- Activate the checkbox by default -->
<input type="checkbox" @checkbox('send_sms', 1, true)>
```

This will result in the following markup:

```html
<input type="checkbox" name="remember_me" value="1">

<!-- With a custom value -->
<input type="checkbox" name="newsletter" value="yes">

<!-- Activate the checkbox by default -->
<input type="checkbox" name="send_sms" value="1" checked>
```

### @radio

`@radio(string $attribute [, mixed $value = 1 [, boolean $checked = false ]])`

The `@radio` directive is used in the same way as `@checkbox` directive, in fact
is just an alias:

```blade
<input type="radio" @radio('color', 'red')>
<input type="radio" @radio('color', 'green', true)>
<input type="radio" @radio('color', 'blue')>
```

This will result in the following markup:

```html
<input type="radio" name="color" value="red">
<input type="radio" name="color" value="green" checked>
<input type="radio" name="color" value="blue">
```

### @options

`@options(array $options, string $attribute [, mixed $default = null [, string $placeholder = null ]])`

Use the `@options` directive to display a list of options for a select field.
Let's say we pass an array named `$cardTypes` to the view and use it with the `@options`
directive:

```php
$cardTypes = [
    'VISA' => 'Visa',
    'MC'   => 'Master Card',
    'AME'  => 'American Express',
];
```

```blade
<select name="card_type">
    @options($cardTypes, 'card_type')
</select>
```

This will result in the following markup:

```html
<select name="card_type">
    <option value="VISA">Visa</option>
    <option value="MC">Master Card</option>
    <option value="AME">American Express</option>
</select>
```

Of course you can set a default selected option:

```blade
<select name="card_type">
    @options($cardTypes, 'card_type', 'MC')
</select>
```

And the result will be:

```html
<select name="card_type">
    <option value="VISA">Visa</option>
    <option value="MC" selected>Master Card</option>
    <option value="AME">American Express</option>
</select>
```

Also you can define a _placeholder_ option:

```blade
<select name="card_type">
    @options($cardTypes, 'card_type', null, 'Select a card type')
</select>
```

The result will be:

```html
<select name="card_type">
    <option value="" selected disabled>Select a card type</option>
    <option value="VISA">Visa</option>
    <option value="MC">Master Card</option>
    <option value="AME">American Express</option>
</select>
```

### @error

`@error(string $attribute [, string $template = null ])`

Use the `@error` directive to display a validation error message, this directive will check for you if the error
exists or not.

```blade
<input type="text" @input('name')>
@error('name')
```

Then when the user is redirected back with errors, the result will be:

```html
<input type="text" name="name" value="Name That Fail Validation">
<div class="help-block">The name field fails validation.</div>
```

Note that the `@error` directive is [Bootstrap](https://getbootstrap.com) friendly by default,
but you can define a custom template:

```blade
@error('name', '<span class="error">:message</span>')
```

And the result will be:

```html
<span class="error">Error message</span>
```

See how easy is to do cool stuff with `@error` directive, for example
if you are using [Bootstrap](https://getbootstrap.com) for your markup, you can do something like this:

```blade
<div class="form-group @error('name', 'has-error')">
    <input type="text" @input('name')>
    @error('name')
</div>
```

And in the case the user is redirected back with errors, the result will be:

```html
<div class="form-group has-error">
    <input type="text" name="name" value="Bad Name">
    <div class="help-block">Error message</div>
</div>
```
