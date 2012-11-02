<?php

namespace Hal;

class Link
{
    private $href;
    private $rel;
    private $name;
    private $hreflang;
    private $title;
    private $templated;

    public function __construct($href = null, $rel = null)
    {
        $this
            ->setHref($href)
            ->setRel($rel);
    }

    public function setHref($href)
    {
        $this->href = $href;
        return $this;
    }

    public function setRel($rel)
    {
        $this->rel = $rel;
        return $this;
    }

    public function getRel()
    {
        return $this->rel;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setHreflang($hreflang)
    {
        $this->hreflang = $hreflang;
        return $this;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function setTemplated($templated)
    {
        $this->templated = $templated;
        return $this;
    }

    public function isValid()
    {
        return true;
    }

    public function asJson()
    {
        return json_encode($this->asArray());
    }

    public function asArray()
    {
        $json = array(
            'href' => $this->href
        );

        if (!empty($this->name)) {
            $json['name'] = $this->name;
        }

        if (!empty($this->hreflang)) {
            $json['hreflang'] = $this->hreflang;
        }

        if (!empty($this->title)) {
            $json['title'] = $this->title;
        }

        if (!empty($this->templated)) {
            $json['templated'] = $this->templated;
        }

        $json = array($this->rel => $json);

        return $json;
    }

}
