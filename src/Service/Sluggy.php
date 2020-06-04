<?php


namespace App\Service;


class Sluggy
{
    private $delimiter = '-';

    public function slug(string $name)
    {
        //Yavuz KUTUK => yavuz-kutuk

        $slug = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $name);
        $slug = strtolower($slug);
        $slug = preg_replace("/[\/_|+ -]+/", $this->delimiter, $slug);
        $slug = trim($slug, $this->delimiter);

        return $slug;

    }

}