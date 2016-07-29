# Laravel Form Helpers
A set of blade directives that will help you to fill forms using
the _old input_ or an eloquent model instance, also it helps you to
display validation errors in a easy way.

## Example
See how easy is to do cool stuff with these directives, for example
if you are using Bootstrap for your markup, you can do something like this:

```blade
<div class="form-group @error('name', 'has-error')">
    <input type="text" @input('name')>
    @error('name')
</div>
```

And in the case of an error the result will be:

```html
<div class="form-group has-error">
    <input type="text" name="name" value="Bad Name">
    <div class="help-block">Error message</div>
</div>
```

¡It's _awesame_!

Installation
------------

Install with composer, just run the command:

```sh
composer require sahibalejandro/laravel-form-helpers --prefer-dist
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

Use the `@form` directive to bind a model to your form:

```blade
<form action="/users/123" method="POST">
    @form($user)
</form>
```
    
This directive is optional, use it only when you want bind a model.
    
### @input

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

Use the `@text` directive to assign the value to an textarea field:

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
<input type="checkbox" name="newsletter" value="yes">
<input type="checkbox" name="send_sms" value="1" checked>
```

### @radio

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

Use the `@error` directive to display a validation error:

```blade
<input type="text" @input('name')>
@error('name')
```

Then when the user is redirected back with errors, the result will be:

```html
<input type="text" name="name" value="Name That Fail Validation">
<div class="help-block">The name field fails validation.</div>
```

Note that the `@error` directive is Bootstrap friendly by default,
but you can define a custom template:

```blade
@error('name', '<span class="error">:message</span>')
```

And the result will be:

```html
<span class="error">Error message</span>
```

See how easy is to do cool stuff with `@error` directive, for example
if you are using Bootstrap for your markup, you can do something like this:

```blade
<div class="form-group @error('name', 'has-error')">
    <input type="text" @input('name')>
    @error('name')
</div>
```

And in the case of an error the result will be:

```html
<div class="form-group has-error">
    <input type="text" name="name" value="Bad Name">
    <div class="help-block">Error message</div>
</div>
```
