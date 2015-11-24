<?php

if (!defined('MEDIAWIKI')) {
    die();
}

$wgExtensionFunctions[] = 'wfIncludeSourceExtension';
$wgExtensionCredits['parserhook'][] = array(
  'name' => 'Include Source',
  'author' => 'Jonas Neugebauer',
  'url' => 'https://github.com/jneug/mediawiki-includesource',
  'version' => '0.1.0',
  'description' => 'Allows the source of any article to be shown on any wiki page.',
);

function wfIncludeSourceExtension()
{
    global $wgParser;
    $wgParser->setHook('source', 'wfRenderSource');
}

function wfRenderSource($input, array $args, Parser $parser, PPFrame $frame)
{
    global $wgUser;
    // $tag = isset($args['tag']) ? $args['tag'] : 'pre';
    $tag = 'pre';

    $title = substr($input, 2, -2);
    if (strpos(':', $title) === 0) {
        $title = substr($title, 1);
    }

    $content = $input;
    $pageTitle = Title::newFromText($title);
    if ($pageTitle->exists()) {
        $article = new Article($pageTitle);
        $content = $article->getRawText();
    }

    return "<$tag>\n".htmlentities($content)."\n</$tag>";
}
