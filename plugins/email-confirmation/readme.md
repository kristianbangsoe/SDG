# Email Confirmation for WordPress

Send an email to the user with confirmation code and store form data in database until user confirms.

**Requires:** PHP 5.3+

## How To

#### Installation

Drop the plugin in `/wp-content/plugins/email-confirmation` and activate in WordPress.

#### Usage

Make sure to validate all your data **before** using Email Confirmation, then you can call the plugin anywhere in your templates:
```php
<?php
$headers = 'From: admin <noreply@admin>';
$to = $_POST['email'];
$subject = 'Confirm';
// The unique token can be inserted in the message with %s
$message = 'Thank you. Please <a href="<?= home_url('confirm') ?>?token=%s">confirm</a> to continue';

if ($isAllValid) {
  EmailConfirmation::send($to, $subject, $message, $headers);
}
```

The above will send an email with a unique token for confirmation and store the `$_POST` array in the DB.

The confirmation link can be any page or template you want. For a minimal setup all you need is to pass the token in `$_GET`. The `check` method will retrieve the data for a specific token and return it, then remove it from the DB. If the token doesn't exist it will return `null`.

```php
<?php
$data = EmailConfirmation::check($_GET['token')); // $_POST saved for this token
```