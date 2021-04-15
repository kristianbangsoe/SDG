# Wordpress Template

This is the stripped Wordpress template for HTML24, which we use as a bone-structure for every Wordpress project.

To use this, simply make a fork of this Repository.

Below is a description of this Wordpress template.


## Table of Contents

- [Using the Template](#using-the-template)
- [Template Structure](#template-structure)
- [Template Setup](#template-setup)
- [GULP](#gulp)
- [Advanced Custom Fields Pro](#advanced-custom-fields-pro)

## Using the Template

This template is very basic with almost no unnecessary content in each template file. We've created the most used files in a Wordpress template, but we've removed all the content in these files. We did this since each project is different, which means the content in each file will be different for each project.
We haven't created this for Wordpress beginners with tons of examples which will be ignored and deleted anyway. Therefore we've created a very clean template, and if there is anything Wordpress related you are unsure about, then [http://codex.wordpress.org/](http://codex.wordpress.org/) is a good place to search. 

To begin with the best would be for you to created the markup and styling for the site, here we advice you to use our standard [HTML5 template](https://github.com/HTML24/HTML5-template). Then you simply incorporate your static website with this Wordpress template.

## Template Structure

Sometimes when you're working on bigger project the functions-file becomes pretty big and can easily get unmanageable. Therefore we've decided to create a folder called includes in which we've create multiple files with different functions and then we're including these files in the `functions.php`. You can also create child-folders in this includes-folder to manage your widgets for example.
This will make it a lot more manageable and easier for other developers to read and edit your code.

## Template Setup

When you activate the theme it will automatically do some setup for the theme. The setup functions can be found in the includes folder and child folders. Here is a list of setup is done
* Enqueues the necessary scripts and styles that will automatically be compiled through GULP
* Registers one primary menu
* Adds theme support for post-thumbnails
* Loads the `html24` text domain for string translations
* Includes newest jQuery(noConflict) and the `frontend.js` and `backend.js` file inside the js folder
* Inserts the custom backend logo
* Creates custom wp_title function
* Registers a stylesheet for the backend. `backend.css` which can be found inside the theme css folder
* Removes admin menu items for the theme editor and comments

If You want to change anything related to these points you should change it in the includes folders

## GULP

The gulpfile is ready to use as-is. You will most likely need to change the default settings for the specific project first, though. The gulpsetup consits of two basic settings-files; `build-settings.json` & `dev-settings.json`. The idea behind this is for you to have one settings-file running on jenkins or other buildservers, while developers can override settings by adding their own `dev-settings.json`-file to the root directory. It is important(!) to note that this file should NOT be added to git, since each developer will have their own variations in paths etc. Also if this file is added, jenkins will use those settings and the build will likely fail.

### GULP-Settings
Below we will go through each setting and explain exactly what it does.
#### development_url
This setting is used for browser-sync. It will proxy your development url (fx. http://localhost/my-awesomeproject) and refresh/inject etc. when changes occurs.
####project_name
The name of your project. Example for the projectname on glyptoteket.dk is "dk.glyptoteket". This syntax is used, since it will work better when we automate sonarqube.
####project_type
For a wordpress theme this settings should be left like default "wordpress_theme" 
####theme_name
The name of your theme. SHould be "project#-name". IE: 4554-glyptoteket
####version
Version can be left as 1.0 or changed if you feel.
####enable_browser_sync
This boolean can enable and disable browsersync alltogether
####root_dir_file_extensions
This array defines which file-extensions you want to include as distributable code from your root-directory. Many things like json-files for settings etc. are unwanted in a deliverable and therefore, we have set some default extensions that almost always should be included from the root-directory. EI: "html", "htm", "php", "png", "ico", "css"
####project_directories
This array defines which directories contains code to be included as-is. IE: code that you are not compiling directly into dist, like php-code. Default settings for a wordpress-theme are: "page-templates", "module-templates", "includes", "fonts", "img", "languages", "js/plugins", "css", "woocommerce". Note that we are including js/plugins, since this is for 3rd party javascript-code that we are not concatenating to our own javascript. Same for the css-folder in the root-dir. 
####bisynced_directories
This will most likely only contain "exports" in the array, but is designed for defining which folders you want bi-directional sync on. When we are using ACF, we synchronize the ACF-field-groups with JSON-files in the exports-folder. This setting is useful to automatically sync files between your running theme and the source-folder. This way, when you change a field group on your dev-site the json-files are copied over to your source-dir and when you pull changes from git, the changes are copied the other way. 
####dist
Important setting! This is where you define where your theme should be compiled to. This should be the relateive (or absolute) path to your wordpress installation's `wp-content/themes/` directory.

## Advanced Custom Fields Pro

We have included the advanced custom fields (acf) plugin into our theme. When you install the theme the plugin will already be activated and ready to use.

To edit the settings of the plugin you can find the `acf-config.php` file inside the `includes/plugins`

### Workflow

We advice that you start setting up your custom fields by using the acf interface in the backend. The fields will automatically be exported as JSON files in `exports` folder in the theme root. So when you upload the theme to a Dev or Live server, all you have to do is run a field group sync on the server.