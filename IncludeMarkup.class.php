<?php

class IncludeMarkup {

    /**
	 * Register parser hook
	 *
	 * @param $parser Parser
	 * @return bool
	 */
	public static function configureParser( &$parser ) {
		$parser->setHook( 'markup', array( 'IncludeMarkup', 'parserHook' ) );
		return true;
	}

	/**
	 * Parser hook
	 *
	 * @param string $text
	 * @param array $args
	 * @param Parser $parser
	 * @return string
	 */
	public static function parserHook( $input, array $args, Parser $wgParser ) {
        global $wgIncMarkupTranscludeContent, $wgIncMarkupEscapeContent;

        $text = $input;
        $pageTitle = Title::newFromText(substr($input, 2, -2), NS_TEMPLATE);
        if (isset($pageTitle) && $pageTitle->exists()) {
            $page = WikiPage::factory($pageTitle);

            if ($wgIncMarkupTranscludeContent) {
                $parser = $wgParser->getFreshParser();
                $parserOptions = is_null( $parser->getOptions() )
                    ? new ParserOptions
                    : $parser->getOptions();
                $text = $parser->getPreloadText(
                    $page->getContent()->getWikitextForTransclusion(),
                    $pageTitle,
                    $parserOptions
                );
            } else {
                // $content = $page->getContent(Revision::RAW);
                $content = $page->getContent(Revision::FOR_THIS_USER);
                $text = ContentHandler::getContentText( $content );
            }
        }

        if ($wgIncMarkupEscapeContent) {
            $text = htmlentities($text);
        }

        return "<pre>\n".$text."\n</pre>";
    }

}
