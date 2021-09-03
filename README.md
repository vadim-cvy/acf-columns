# ACF Columns

## What is it?

ACF Columns is a WordPress plugin which makes it easy to create dashboard tables columns for ACF fields.

---

## Why is it created?

I have faced similar tasks in multiple projects but all the existing solutions are not scalable enough. I tried to create a solution which allows you to follow DRY (Don't Repeat Yourself) principle and build scalable solutions if you want to customize this project according to your needs.

---

## How to install?

1. Put this plugin into your WP plugins directory.
2. Activate the plugin.

---

## Features and How To Use them?

* Create a column for an ACF field:
    * How to use:
        * Create an ACF field.
        * Go to its settings and toggle "Show in Dashboard Tables?" setting to "Yes".
    * Feature description:
        * Field columns appear in all tables which match their parent groups location rules.
            * Example: a column for "Your Field" field will appear in "WooCommerce Product" post type table if "Your Field" field parent group location is set to "Post Type = Product".
            * Another example: a column for "Your Field" field will appear in all taxonomy tables except "Your Custom Taxonomy" if "Your Field" field parent group location is set to "Taxonomy is not equal to Your Custom Taxonomy".
        * You may merge multiple field columns in any table into 1 column. See "Merge multiple columns into 1 column" section (below).
* Merge multiple columns into 1 column:
    * How to use:
        * Open Dashboard > menu > Settings > ACF Columns. You can see a list of all posts, taxonomies and users tables.
        * Update maximum number of the ACF columns before they're merged (inputs near the table names).
    * Feature description:
        * When may you need this feature: you may merge all the columns into a single one to save space. Let's suppose some of your tables have more than 30 ACF field columns. The table with 30+ columns won't look good on 1360px and even 1800px screens. They will take too much space.
        * ACF field columns will be merged into 1 column when their total number will be larger  than you set on the settings page (in terms of a single table).
            * Example: "Pages" table will merge all ACF field columns into a single column after the total number of "Page" table ACF field columns will be larger then you specified on the settings page.

---

## A couple words about the `/helpers/` dir:

Helpers are the classes, assets and templates which solve the common tasks. I want to use them in other projects in the future. And keeping helpers in a separate directory makes it easier for me to copy/paste the common (not custom) solutions only.

I want to write bash boilerplate code for automated plugins/themes creation later. This code will create empty `/inc/`, `/assets/` and `/templates/` dirs, put the `/helpers/` into the project and create template `/Plugin.php` (for plugins) or `/Theme.php` (for themes) file.