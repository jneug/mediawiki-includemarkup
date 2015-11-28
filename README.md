# Extension:IncludeMarkup
A MediaWiki extension that includes the raw markup of a page on any other wiki
page. This can be useful for template documentation.

Works with MediaWiki >1.25.

## Installation
Download the files and place them in `extensions/IncludeMarkup` in your
MediaWiki folder. Then add the following line to your `LocalSettings.php`:

```php
wfLoadExtension( 'IncludeMarkup' );
```

## Usage
Just wrap any page transclusion in `markup` Tags:

```html
<markup>{{Template:Foo}}</markup>

<markup>{{:Pagename}}</markup>
```
