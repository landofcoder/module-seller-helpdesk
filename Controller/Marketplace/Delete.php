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

namespace Lofmp\HelpDesk\Controller\Marketplace;

use Lof\HelpDesk\Model\QuickanswerFactory;
use Lof\HelpDesk\Model\TicketFactory;
use Lof\MarketPlace\Helper\Data;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\Url;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Ui\Component\MassAction\Filter;

/**
 * BLog post controller
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
abstract class Delete extends \Magento\Framework\App\Action\Action
{

    /**
     * @var Session
     */
    protected $_customerSession;
    /**
     * @var \Magento\Customer\Model\Url
     */
    protected $_customerUrl;
    /**
     * @var Data
     */
    private $helper;
    /**
     * @var Filter
     */
    protected $filter;
    /**
     * @var QuickanswerFactory
     */
    private $quickanswerFactory;

    /**
     * @var TicketFactory
     */
    private $ticketFactory;

    /**
     * @param Context $context
     * @param Session $customerSession
     * @param Url $customerUrl
     * @param Filter $filter
     * @param Data $helper
     * @param QuickanswerFactory $quickanswerFactory
     * @param TicketFactory $ticketFactory
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        Url $customerUrl,
        Filter $filter,
        Data $helper,
        QuickanswerFactory $quickanswerFactory,
        TicketFactory $ticketFactory
    ) {
        parent::__construct($context);
        $this->_customerSession = $customerSession;
        $this->_customerUrl = $customerUrl;
        $this->helper = $helper;
        $this->filter = $filter;
        $this->quickanswerFactory = $quickanswerFactory;
        $this->ticketFactory = $ticketFactory;
    }

    /**
     * Retrieve customer session object.
     *
     * @return Session
     */
    protected function _getSession()
    {
        return $this->_customerSession;
    }

    /**
     * Check customer authentication.
     *
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function dispatch(RequestInterface $request)
    {
        $urlModel = $this->_customerUrl;
        $loginUrl = $urlModel->getLoginUrl();
        if (!$this->_customerSession->authenticate($loginUrl)) {
            $this->_actionFlag->set('', self::FLAG_NO_DISPATCH, true);
        }
        return parent::dispatch($request);
    }

    /**
     * @param $quickanswerId
     * @return bool
     */
    public function validateQuickanswer($quickanswerId)
    {
        $sellerId = $this->helper->getSellerId();
        $auction = $this->quickanswerFactory->create()->load($quickanswerId);
        if ($auction->getSellerId() != $sellerId) {
            $this->messageManager->addErrorMessage(__('You don\'t have permission to delete this'));
            return false;
        } else {
            return true;
        }
    }
    /**
     * @param $tickeId
     * @return bool
     */
    public function validateTicket($tickeId)
    {
        $sellerId = $this->helper->getSellerId();
        $auction = $this->ticketFactory->create()->load($tickeId);
        if ($auction->getSellerId() != $sellerId) {
            $this->messageManager->addErrorMessage(__('You don\'t have permission to delete this'));
            return false;
        } else {
            return true;
        }
    }
}
