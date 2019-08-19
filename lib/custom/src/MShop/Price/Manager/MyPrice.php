<?php



namespace Aimeos\MShop\Price\Manager;

class MyPrice extends Standard
{

    private $searchConfig = array(
        'price.test' => array(
            'code' => 'price.test',
            'internalcode' => 'mpri."test"',
            'label' => 'Price test amount',
            'type' => 'decimal',
            'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
        ),
    );


    /**
     * @param \Aimeos\MShop\Common\Item\Iface $item
     * @param bool $fetch
     * @return \Aimeos\MShop\Common\Item\Iface|\Aimeos\MShop\Common\Item\ListRef\Iface
     * @throws \Aimeos\MW\Common\Exception
     * @author Otto Michalicka
     */
    public function saveItem( \Aimeos\MShop\Common\Item\Iface $item, $fetch = true )
    {

       // dd(123);
        self::checkClass( '\\Aimeos\\MShop\\Price\\Item\\Iface', $item );

        if( !$item->isModified() ) {
            return $this->saveListItems( $item, 'price', $fetch );
        }

        $context = $this->getContext();

        $dbm = $context->getDatabaseManager();
        $dbname = $this->getResourceName();
        $conn = $dbm->acquire( $dbname );

        try
        {
            $id = $item->getId();
            $date = date( 'Y-m-d H:i:s' );

            if( $id === null )
            {

                $path = 'mshop/price/manager/standard/insert';
            }
            else
            {

                $path = 'mshop/price/manager/standard/update';
            }

            $stmt = $this->getCachedStatement( $conn, $path );

            $stmt->bind( 1, $item->getTypeId(), \Aimeos\MW\DB\Statement\Base::PARAM_INT );
            $stmt->bind( 2, $item->getCurrencyId() );
            $stmt->bind( 3, $item->getDomain() );
            $stmt->bind( 4, $item->getLabel() );
            $stmt->bind( 5, $item->getQuantity(), \Aimeos\MW\DB\Statement\Base::PARAM_INT );
            $stmt->bind( 6, $item->getValue() );
            $stmt->bind( 7, $item->getCosts() );
            $stmt->bind( 8, $item->getRebate() );
            //updatedByMe
            $stmt->bind( 9, $item->getTest() );
            $stmt->bind( 10, $item->getTaxRate() );
            $stmt->bind( 11, $item->getStatus(), \Aimeos\MW\DB\Statement\Base::PARAM_INT );
            $stmt->bind( 12, $date ); //mtime
            $stmt->bind( 13, $context->getEditor() );
            $stmt->bind( 14, $context->getLocale()->getSiteId(), \Aimeos\MW\DB\Statement\Base::PARAM_INT );

            // dd($item, $id, $stmt);
            if( $id !== null ) {
                //updatedByMe from 14 to 15
                $stmt->bind( 15, $id, \Aimeos\MW\DB\Statement\Base::PARAM_INT );
                $item->setId( $id );
            } else {
                $stmt->bind( 15, $date ); //ctime
            }

            $stmt->execute()->finish();

            if( $id === null )
            {

                $path = 'mshop/price/manager/standard/newid';
                $item->setId( $this->newId( $conn, $path ) );
            }

            $dbm->release( $conn, $dbname );
        }
        catch( \Exception $e )
        {
            $dbm->release( $conn, $dbname );
            throw $e;
        }

        return $this->saveListItems( $item, 'price', $fetch );
    }


    /**
     * @param bool $withsub
     * @return array
     * @throws \Aimeos\MW\Common\Exception
     * @author Otto Michalicka
     */
    public function getSearchAttributes($withsub = true)
    {
        $list = parent::getSearchAttributes($withsub);
        foreach ($this->searchConfig as $key => $fields) {
            $list[$key] = new \Aimeos\MW\Criteria\Attribute\Standard($fields);
        }
        return $list;
    }


    /**
     * @param array $values
     * @param array $listItems
     * @param array $refItems
     * @return \Aimeos\MShop\Price\Item\Iface|\Aimeos\MShop\Price\Item\MyPrice
     * @author Otto Michalicka
     */
    protected function createItemBase(array $values = [], array $listItems = [], array $refItems = [] )
    {
        return new \Aimeos\MShop\Price\Item\MyPrice($values , $listItems, $refItems);
    }





}