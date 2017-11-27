<?php
class Lang {
    //////// get lang data
    // $lang = new Lang();
    // $title = $lang->getText('title');
    //////// set lang
    // $lang_class = new Lang();
    // $lang_class->setLang('fr');

    private $_xmlLang = null;
    private $_page;

    public function __construct() {
        $this->_xmlLang = simplexml_load_file(Config::get('lang/xml_loaction'));
        $this->_page = $GLOBALS['page'];
        $this->getLang();
    }

    public function getLang() {
        if(Cookie::exists('lang')) {
            $lang = Cookie::get('lang');
        } else {
            $lang = $this->getClientLang();
            Cookie::put('lang', $lang, Config::get('lang/expiry'));
        }

        $langarray = explode(',', Config::get('lang/languages'));
        if(!in_array($lang, $langarray)) {
            $lang = Config::get('lang/default');
            Cookie::put('lang', $lang, Config::get('lang/expiry'));
        }

        return $lang;
    }

    public function setLang($lang) {
        if(isset($lang) && $lang !== '' ) {
            $langarray = explode(',', Config::get('lang/languages'));
            if(in_array($lang, $langarray)) {
                Cookie::put('lang', $lang, Config::get('lang/expiry'));
            }
        }

        return false;
    }

    private function getClientLang(){
        $langarray = explode(',', Config::get('lang/languages'));
    	if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
    		$langs = explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);

			$choice = substr($langs[0],0,2);
			if(in_array($choice, $langarray)){
				return $choice;
			}
		}
    	return Config::get('lang/default');
    }

    public function setPage($page){
        $this->_page = $page;
    }

    public function getText($item) {
        $page = $this->_page;

        if(Cookie::exists('lang')) {
            $lang = Cookie::get('lang');
        } else {
            $lang = $this->getClientLang();
        }
        return $this->_xmlLang->$page->$item->$lang;
    }
}
