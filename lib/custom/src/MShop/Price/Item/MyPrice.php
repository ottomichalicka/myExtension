<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2018
 * @package MShop
 * @subpackage Price
 */


namespace Aimeos\MShop\Price\Item;


/**
 *
 *
 * @package MShop
 * @subpackage Price
 */
class MyPrice extends Standard
{

    private $myvalues;

    public function __construct(array $values = [], array $listItems = [], array $refItems = [])
    {
        parent::__construct($values);
        $this->myvalues = $values;
    }

    /**
     * Tests if the item is available based on status, time, language and currency
     *
     * @return boolean True if available, false if not
     */
    public function isAvailable()
    {
        //dd($this);
        return (bool)$this->getStatus()
            && ($this->myvalues['price.currencyid'] === null || $this->getCurrencyId() === $this->myvalues['price.currencyid']);
    }


    /**
     * @return string
     * @author Otto Michalicka
     */
    public function getTest()
    {
        //dd($this);
        if (isset($this->myvalues['price.test'])) {
            return (string)$this->myvalues['price.test'];
        }

        return '0.00';
    }


    /**
     * @param $price
     * @return $this
     * @throws \Aimeos\MShop\Price\Exception
     * @author Otto Michalicka
     */
    public function setTest($price)
    {
        if ((string)$price !== $this->getTest()) {
            $this->myvalues['price.test'] = (string)$this->checkPrice($price);
            $this->setModified();
        }

        return $this;
    }


    /**
     * @param array $list
     * @return array
     * @throws \Aimeos\MShop\Price\Exception
     * @author Otto Michalicka
     */
    public function fromArray(array $list)
    {
        $unknown = [];
        $list = parent::fromArray($list);
        unset($list['price.type'], $list['price.typename']);

        foreach ($list as $key => $value) {
            switch ($key) {
                case 'price.test':
                    $this->setTest($value);
                    break;
            }
        }

        return $unknown;
    }


    /**
     * @param Iface $item
     * @param int $quantity
     * @return $this|Iface
     * @throws \Aimeos\MShop\Price\Exception
     * @author Otto Michalicka
     */
    public function addItem(\Aimeos\MShop\Price\Item\Iface $item, $quantity = 1)
    {
        if ($item->getCurrencyId() != $this->getCurrencyId()) {
            $msg = 'Price can not be added. Currency ID "%1$s" of price item and currently used currency ID "%2$s" does not match.';
            throw new \Aimeos\MShop\Price\Exception(sprintf($msg, $item->getCurrencyId(), $this->getCurrencyId()));
        }

        if ($this === $item) {
            $item = clone $item;
        }
        $taxValue = $this->getTaxValue();

        $this->setTest($this->getTest() + $item->getTest() * $quantity);

        return $this;
    }


    /**
     * Returns the item values as array.
     *
     * @param boolean True to return private properties, false for public only
     * @return array Associative list of item properties and their values
     */
    public function toArray($private = false)
    {

        $list = parent::toArray($private);

        if ($private === true) {
            $list['price.test'] = $this->getTest();
        }

        return $list;
    }


}