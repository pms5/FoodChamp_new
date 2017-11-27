<?php

class String {
    public function createSlug($slug) {
        $lettersNumbersSpacesHyphens = '/[^\-\s\pN\pL]+/u';
        $spacesDuplicateHyphens = '/[\-\s]+/';

        $slug = preg_replace($lettersNumbersSpacesHyphens, '', mb_strtolower($slug, Config::get('meta/charset')));
        $slug = preg_replace($spacesDuplicateHyphens, '-', $slug);

        return $slug;
    }
}
