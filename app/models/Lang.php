<?php
class Lang {
    //////// get lang data
    // $lang_class = new Lang();
    // $current_page = 'home';
    // $lang = Cookie::get('lang');
    // $title = $lang_class->xml_lang->$current_page->title->$lang;
    //////// set lang
    // $lang_class = new Lang();
    // $lang_class->set_lang('fr');

    public  $xml_lang = null;
    private $page;

    public function __construct() {
        $this->xml_lang = simplexml_load_file(Config::get('lang/xml_loaction'));
        $this->page = $GLOBALS['page'];
        $this->get_lang();
    }

    public function get_lang() {
        if(Cookie::exists('lang')) {
            $lang = Cookie::get('lang');
        } else {
            $lang = $this->get_client_lang();
            Cookie::put('lang', $lang, Config::get('lang/expiry'));
        }

        $langarray = explode(',', Config::get('lang/languages'));
        if(!in_array($lang, $langarray)) {
            $lang = Config::get('lang/default');
            Cookie::put('lang', $lang, Config::get('lang/expiry'));
        }

        return $lang;
    }

    public function set_lang($lang) {
        if(isset($lang) && $lang !== '' ) {
            $langarray = explode(',', Config::get('lang/languages'));
            if(in_array($lang, $langarray)) {
                Cookie::put('lang', $lang, Config::get('lang/expiry'));
            }
        }

        return false;
    }

    private function get_client_lang(){
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
        $this->page = $page;
    }

    public function get_text($item) {
        $page = $this->page;

        if(Cookie::exists('lang')) {
            $lang = Cookie::get('lang');
        } else {
            $lang = $this->get_client_lang();
        }
        return $this->xml_lang->$page->$item->$lang;
    }
}
