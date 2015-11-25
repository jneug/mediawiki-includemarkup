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
	public static function parserHook( $input, array $args, Parser $parser ) {
        $title = substr($input, 2, -2);
        if (strpos(':', $title) === 0) {
            $title = substr($title, 1);
        }

        $content = $input;
        $pageTitle = Title::newFromText($title);
        if (isset($pageTitle) && $pageTitle->exists()) {
            $article = new Article($pageTitle);
            $content = $article->getRawText();
        }

        return "<pre>\n".htmlentities($content)."\n</pre>";
    }

}
