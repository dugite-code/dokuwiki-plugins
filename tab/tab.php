<?php
/**
* Plugin Tab: Inserts "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" into the document for every <tab> it encounters
*
* @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
* @author     Tim Skoch <timskoch@hotmail.com>
*/

if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');

/**
* All DokuWiki plugins to extend the parser/rendering mechanism
* need to inherit from this class
*/
class syntax_plugin_tab extends DokuWiki_Syntax_Plugin {

	/**
	* return some info
	*/
	function getInfo(){
		return array(
			'author' => 'Tim Skoch',
			'email'  => 'timskoch@hotmail.com',
			'date'   => '2018-02-06',
			'name'   => 'Tab Plugin',
			'desc'   => 'Inserts "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" into the html of the document for every <tab> it encounters',
			'url'    => 'http://www.dokuwiki.org/wiki:plugins:tab',
		);
	}

	/**
	* What kind of syntax are we?
	*/
	function getType(){
		return 'substition';
	}

	/**
	* Where to sort in?
	*/
	function getSort(){
		return 999;
	}


	/**
	* Connect pattern to lexer
	*/
	function connectTo($mode) {
		$this->Lexer->addSpecialPattern('<tab\d*>',$mode,'plugin_tab');
	}


	/**
	* Handle the match
	*/
	function handle($match, $state, $pos, Doku_Handler $handler){
		switch ($state) {
			case DOKU_LEXER_ENTER :
				break;
			case DOKU_LEXER_MATCHED :
				break;
			case DOKU_LEXER_UNMATCHED :
				break;
			case DOKU_LEXER_EXIT :
				break;
			case DOKU_LEXER_SPECIAL :
				$match = substr($match,4,-1);
				if ((strlen($match)>0) && ($match >0)) {
					$data .= str_repeat('&#160;&#160;&#160;&#160;&#160;', $match);
				} else {
					$data = '&#160;&#160;&#160;&#160;&#160;';
				}
				return $data;
		}
		return array();
	}

	/**
	* Create output
	*/
	function render($mode, Doku_Renderer $renderer, $data) {
		if($mode == 'xhtml'){
			$renderer->doc .= "$data";            // ptype = 'normal'
			return true;
		}
		return false;
	}
}