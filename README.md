# contact-form-php
A PHP/Ajax Contact form processor for your website

## Why This Project
I created this project to provide an easily customizable PHP form processor with AJAX support.
This project can be used as a general form processor with email-sending capability.
It was originally intended for frontend developers who want a simple php form processor for their websites.


## Features
1. Sends form content using AJAX (No reloading)
2. Nicely display output of form processor
3. It can be configured to handle multiple forms
4. Can be used to process any kind of form and sends form content as email
5. ~~Anti-spam support~~: comming soon
6. Depends on jquery

## Installation

### Manual Download
1. Use this [download link](https://github.com/dekyfin-academy/contact-form-php/archive/master.zip)
2. Unzip the content into your project directory

### Using Git
```bash
git clone https://github.com/dekyfin-academy/contact-form-php
```

## Usage
### Inlude the Javascript and CSS Files
```html
<link rel="stylesheet" type="text/css" href="path/to/css/form.css" >

<script src="path/to/js/jquery.js" defer async></script>
<script src="path/to/js/form.js" defer async></script>
```
Note:
- the javascript file must be included after jquery
- For best performance add script just before `</body>` (closing body tag)

### Configure form processor
1. Duplicate `php/config.sample.php` to `php/contact.php`.
2. Configure `php/contact.php` as desired. Comments are provided in the file to guide you with the configuration
3. It is recommended to create different configurations for different forms


### Configure your form
1. Add `form-processor` class to your form
2. Ensure the form's `action` attribute points to the the configuration file
3. [optional] Add an element with class `form-output` to the form to display the output of the form processor

```html
<form class="form-processor" action="/path/to/contact.php">
  <output class="form-output"></output>
  <input name="name" type="text" placeholder="Your name" required />
  <input name="email" type="email" placeholder="Email Address" required />
  <textarea name="message" placeholder="Message"></textarea>
</form>
```