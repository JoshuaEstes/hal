<?php

namespace JoshuaEstes\Hal;

use JoshuaEstes\Hal\Link;

/**
 * @author Joshua Estes
 */
class Resource
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
     * @var \SplObjectStorage
     */
    private $_links;

    /**
     * @var \SplObjectStorage
     */
    private $_embedded;

    /**
     * @var array
     */
    private $attributes = array();

    /**
     * @param Link $link
     * @param string $rel
     */
    public function __construct(Link $link, $rel = null)
    {
        $this->_links    = new \SplObjectStorage();
        $this->_embedded = new \SplObjectStorage();
        $this
            ->addLink($link)
            ->setRel($rel);
    }

    /**
     * Magic Method to set attributes
     *
     * @param string $name
     * @param string $value
     */
    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    /**
     * @param string $href
     * @return Resource
     */
    public function setHref($href)
    {
        $this->href = $href;
        return $this;
    }

    /**
     * @param string $rel
     * @return Resource
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
     * @return Resource
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $hreflang
     * @return Resource
     */
    public function setHreflang($hreflang)
    {
        $this->hreflang = $hreflang;
        return $this;
    }

    /**
     * @param string $title
     * @return Resource
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param Resource $resource
     * @return Resource
     */
    public function addResource(Resource $resource)
    {
        $this->_embedded->attach($resource, $resource->getRel());
        return $this;
    }

    /**
     * @param Link $link
     * @return Resource
     */
    public function addLink(Link $link)
    {
        $this->_links->attach($link, $link->getRel());
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
        $json = array();
        foreach ($this->_links as $link) {
            $tmp = $link->asArray();
            if (isset($json['_links'][$link->getRel()])) {
                if (isset($json['_links'][$link->getRel()]['href'])) {
                    $json['_links'][$link->getRel()] = array(
                        $json['_links'][$link->getRel()],
                        $tmp[$link->getRel()],
                    );
                } else {
                    $json['_links'][$link->getRel()][] = $tmp[$link->getRel()];
                }
            } elseif (isset($json['_links'])) {
                $json['_links'][$link->getRel()] = $tmp[$link->getRel()];
            } else {
                $json['_links'] = $link->asArray();
            }
        }

        foreach ($this->_embedded as $resource) {
            $tmp = $resource->asArray();
            if (isset($json['_embedded'][$resource->getRel()])) {
                if (isset($json['_embedded'][$resource->getRel()]['_links'])) {
                    $json['_embedded'][$resource->getRel()] = array(
                        $json['_embedded'][$resource->getRel()],
                        $tmp[$resource->getRel()],
                    );
                } else {
                    $json['_embedded'][$resource->getRel()][] = $tmp[$resource->getRel()];
                }
            } elseif (isset($json['_embedded'])) {
                $json['_embedded'][$resource->getRel()] = $tmp[$resource->getRel()];
            } else {
                $json['_embedded'] = $resource->asArray();
            }
        }

        foreach ($this->attributes as $name => $value) {
            $json[$name] = $value;
        }

        if (!empty($this->rel)) {
            $json = array($this->rel => $json);
        }

        return $json;
    }

}
