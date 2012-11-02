<?php

namespace Hal;

/**
 * Defines a link to be used with HAL
 *
 * @author Joshua Estes
 */
class Link
{

    /**
     * @var string
     */
    private $href;

    /**
     * @var string
     */
    private $rel;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $hreflang;

    /**
     * @var string
     */
    private $title;

    /**
     * @var boolean
     */
    private $templated;

    /**
     * @param string $href
     * @param string $rel
     */
    public function __construct($href = null, $rel = null)
    {
        $this
            ->setHref($href)
            ->setRel($rel);
    }

    /**
     * @param string $href
     * @return Link
     */
    public function setHref($href)
    {
        $this->href = $href;
        return $this;
    }

    /**
     * @param string $rel
     * @return Link
     */
    public function setRel($rel)
    {
        $this->rel = $rel;
        return $this;
    }

    /**
     * @return string
     */
    public function getRel()
    {
        return $this->rel;
    }

    /**
     * @param string $name
     * @return Link
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $hreflang
     * @return Link
     */
    public function setHreflang($hreflang)
    {
        $this->hreflang = $hreflang;
        return $this;
    }

    /**
     * @param string $title
     * @return Link
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param boolean $templated
     * @return Link
     */
    public function setTemplated($templated)
    {
        $this->templated = $templated;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isValid()
    {
        return true;
    }

    /**
     * @return string
     */
    public function asJson()
    {
        return json_encode($this->asArray());
    }

    /**
     * @return array
     */
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
