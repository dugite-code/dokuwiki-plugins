<?php
/**
* Plugin Itext: wraps text in a input field.
*
* @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
* @author     Dugite-Code <dugite-code@peekread.info>
*/

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

/**
* All DokuWiki plugins to extend the parser/rendering mechanism
* need to inherit from this class
*/
class syntax_plugin_itext extends DokuWiki_Syntax_Plugin {


	/**
	* return some info
	*/
	function getInfo(){
		return array(
			'author' => 'Dugite-Code',
			'email'  => 'dugite-code@peekread.info',
			'date'   => '2018-04-12',
			'name'   => 'Itext Plugin',
			'desc'   => 'Wraps text in an input box to make selecting/copying simpler',
			'url'    => 'https://github.com/dugite-code/dokuwiki-plugins/tree/master/itext',
		);
	}


	public function getType(){ return 'formatting'; }
	public function getSort(){ return 158; }
	public function connectTo($mode) { $this->Lexer->addEntryPattern('<itext.*?>(?=.*?</itext>)',$mode,'plugin_itext'); }
	public function postConnect() { $this->Lexer->addExitPattern('</itext>','plugin_itext'); }


	/**
	* Handle the match
	*/
	public function handle($match, $state, $pos, Doku_Handler $handler){
		switch ($state) {
			case DOKU_LEXER_ENTER :
			$match = substr($match,6,-1);
			if ((strlen($match)>0) && ($match >0)) {
				$width = "style='width: ".$match."%'";
			}
			return array($state, $width);
			case DOKU_LEXER_UNMATCHED :  return array($state, $match);
			case DOKU_LEXER_EXIT :       return array($state, '');
		}
		return array();
	}

	/**
	* Create output
	*/
	public function render($mode, Doku_Renderer $renderer, $data) {
		// $data is what the function handle() return'ed.
		if($mode == 'xhtml'){
			/** @var Doku_Renderer_xhtml $renderer */
			list($state,$match) = $data;
			switch ($state) {
				case DOKU_LEXER_ENTER :
				$renderer->doc .= "<input $match value='";
				break;
				case DOKU_LEXER_UNMATCHED :
				$renderer->doc .= $renderer->_xmlEntities($match);
				break;
				case DOKU_LEXER_EXIT :
				$renderer->doc .= "'>";
				break;
			}
			return true;
		}
		return false;
	}
}