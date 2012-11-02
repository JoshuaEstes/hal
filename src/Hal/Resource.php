<?php

namespace Hal;

use Hal\Link;

class Resource
{
    private $href;
    private $rel;
    private $name;
    private $hreflang;
    private $title;
    private $_links;
    private $_embedded;
    private $attributes = array();

    public function __construct(Link $link, $rel = null)
    {
        $this->_links    = new \SplObjectStorage();
        $this->_embedded = new \SplObjectStorage();
        $this
            ->addLink($link)
            ->setRel($rel);
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
        return $this;
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

    public function addResource(Resource $resource)
    {
        $this->_embedded->attach($resource);
        return $this;
    }

    public function addLink(Link $link)
    {
        $this->_links->attach($link);
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
        $json = array();
        foreach ($this->_links as $link) {
            if (isset($json['_links'][$link->getRel()])) {
                if (isset($json['_links'][$link->getRel()]['href'])) {
                    $tmp = $link->asArray();
                    $json['_links'][$link->getRel()] = array(
                        $json['_links'][$link->getRel()],
                        $tmp[$link->getRel()],
                    );
                } else {
                    $tmp = $link->asArray();
                    $json['_links'][$link->getRel()][] = $tmp[$link->getRel()];
                }
            } elseif (isset($json['_links'])) {
                $tmp = $link->asArray();
                $json['_links'][$link->getRel()] = $tmp[$link->getRel()];
            } else {
                $json['_links'] = $link->asArray();
            }
        }

        foreach ($this->_embedded as $resource) {
            if (isset($json['_embedded'][$resource->getRel()])) {
                if (isset($json['_embedded'][$resource->getRel()]['_links'])) {
                    $tmp = $resource->asArray();
                    $json['_embedded'][$resource->getRel()] = array(
                        $json['_embedded'][$resource->getRel()],
                        $tmp[$resource->getRel()],
                    );
                } else {
                    $tmp = $resource->asArray();
                    $json['_embedded'][$resource->getRel()][] = $tmp[$resource->getRel()];
                }
            } elseif (isset($json['_embedded'])) {
                $tmp = $resource->asArray();
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
