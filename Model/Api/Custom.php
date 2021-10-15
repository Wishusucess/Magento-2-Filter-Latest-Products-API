<?php
/**
*
* Developer: Hemant Singh Magento Certified Developer
* Category:  Wishusucess_LatestProductsApi
* Website:   http://www.wishusucess.com/
*/
namespace Wishusucess\LatestProductsApi\Model\Api;

use Psr\Log\LoggerInterface;

class Custom 
{
    /** @var \Magento\Framework\View\Result\PageFactory  */
    protected $resultPageFactory;
               
    public function __construct(
     \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility,
        array $data = []
    ) {
                        $this->resultPageFactory = $resultPageFactory;
                        $this->_productCollectionFactory = $productCollectionFactory;        
                        $this->catalogProductVisibility = $catalogProductVisibility;
                       
           
    }

    /**
     * @inheritdoc
     */

    public function getPost()
    {
        $response = ['success' => false];

        try {
           
            $collection = $this->_productCollectionFactory->create();
        $collection = $this->_productCollectionFactory->create()->addAttributeToSelect('*')->addAttributeToFilter('status', '1')
                        ->addAttributeToFilter('latestproducts', '1');

        $collection->setVisibility($this->catalogProductVisibility->getVisibleInCatalogIds());
       $result= $collection;
       $cart = array();
       foreach($result as $value)
       {
           $cart[] = $value->getData();
       }
              $response= $cart;
    //    print_r($cart);
       
            
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => $e->getMessage()];
        }
        $returnArray = $response;
        return $returnArray; 
    }
}