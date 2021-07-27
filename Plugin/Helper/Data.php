<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * https://landofcoder.com/terms
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lofmp_HelpDesk
 * @copyright  Copyright (c) 2021 Landofcoder (https://www.landofcoder.com/)
 * @license    https://landofcoder.com/terms
 */

namespace Lofmp\HelpDesk\Plugin\Helper;
use Lof\MarketPlace\Model\SellerFactory;
use Magento\Customer\Model\SessionFactory;
class Data
{
    protected $_customerSession;
    protected $_sellerFactory;
    
    public function __construct(
        SessionFactory $customerSession,
        SellerFactory $sellerFactory
    ) {
        $this->_customerSession = $customerSession;
        $this->_sellerFactory = $sellerFactory;
    }
}
