__A Wordpress traslation plugin__

*This plugin is currently under heavy development, it should be considered
in alpha stage and not be used in production environments*

This plugin allow to create a wordpress post in multiple languages
and let the viewer to choose between the available languages.

WHY THIS PLUGIN
---------------

This plugin was created to manage multilanguage posting in an easy way.
We follow two main guidelines:
* Don't use one different post for each language.
* Don't mess up with the db (if you uninstall the plugin you don't risk to lose contents).


INSTALLATION
------------

Downlaod or clone the repository and install it in your plugins directory.

CONFIGURATION
-------------

In your wordpress admin section, under the Settings tab you'll find the
SimpleML settings page. In this page you can define the default language
for your posts. The language should be specified in the [iso639 standard
format](http://www.w3.org/WAI/ER/IG/ert/iso639.htm). For example eng for
English, fra for French, ita for Italian.

USAGE
-----

In your post you can add [simpleML lang="xxx"][/simpleML] shortcodes

    [simpleML lang="eng"]
    English text
    [/simpleML]

    [simpleML lang="ita"]
    Testo italiano
    [/simpleML]

    [simpleML lang="fra"]
    Texte en francais
    [/simpleML]

    This text will always be displayed

For the title you have to specify a \<span\> tag for each language

    <span class="simpleML_eng">English Title</span>
    <span class="simpleML_ita">Titolo italiano</span>

DEVELOPMENT
-----------

You can view the planned enhancements in the [issues](https://github.com/stonedz/simpleML/issues?labels=enhancement)
page. Feel free to fill a feature request there if you have some ideas that could help improve
the plugin.

If you find a bug please let us know by filling a [new issue](https://github.com/stonedz/simpleML/issues/new)!
