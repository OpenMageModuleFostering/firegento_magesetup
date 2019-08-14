<?php
/**
 * This file is part of the FIREGENTO project.
 *
 * FireGento_MageSetup is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License version 3 as
 * published by the Free Software Foundation.
 *
 * This script is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * PHP version 5
 *
 * @category  FireGento
 * @package   FireGento_MageSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2013 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.1.0
 */
/**
 * Adminhtml Controller for dislaying a form for some actions
 *
 * @category  FireGento
 * @package   FireGento_MageSetup
 * @author    FireGento Team <team@firegento.com>
 * @copyright 2013 FireGento Team (http://www.firegento.de). All rights served.
 * @license   http://opensource.org/licenses/gpl-3.0 GNU General Public License, version 3 (GPLv3)
 * @version   $Id:$
 * @since     0.4.0
 */
class FireGento_MageSetup_MagesetupController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Basic action: setup form
     */
    public function indexAction()
    {
        $helper = Mage::helper('magesetup');

        if (!Mage::getStoreConfig('magesetup/is_initialized')) {
            Mage::getSingleton('adminhtml/session')->addNotice(
                $this->__('If you want to add additional StoreViews (i.e. for multiple languages), please do so before submitting this form.')
            );
        }

        $this->_title($helper->__('System'))
            ->_title($helper->__('MageSetup'))
            ->_title($helper->__('Setup'));

        $this->loadLayout()
            ->_setActiveMenu('system/magesetup/setup')
            ->_addBreadcrumb($helper->__('MageSetup'), $helper->__('MageSetup'))
            ->renderLayout();
    }

    /**
     * Basic action: setup save action
     * Will be called from form, rendered in indexAction
     */
    public function saveAction()
    {
        if ($this->getRequest()->isPost()) {
            $params = $this->_getParams();

            try {
                /* @var $setupModel FireGento_MageSetup_Model_Setup */
                $setupModel = Mage::getModel('magesetup/setup');
                $setupModel->setup($params, true);
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
                Mage::logException($e);
            }
        }

        $this->_redirect('*/*');
    }

    /**
     * Recommended extensions
     */
    public function extensionsAction()
    {
        $helper = Mage::helper('magesetup');

        $this->_title($helper->__('System'))
            ->_title($helper->__('MageSetup'))
            ->_title($helper->__('Recommended Extensions'));

        $this->loadLayout()
            ->_setActiveMenu('system/magesetup/extensions')
            ->_addBreadcrumb($helper->__('MageSetup'), $helper->__('MageSetup'))
            ->renderLayout();
    }

    /**
     * @return array
     */
    protected function _getParams()
    {
        $params = $this->getRequest()->getParams();
        
        if (!isset($params['systemconfig'])) {
            $params['systemconfig'] = false;
        }

        if (!isset($params['tax'])) {
            $params['tax'] = false;
        }

        if (!isset($params['cms'])) {
            $params['cms'] = false;
        }

        if (!isset($params['agreements'])) {
            $params['agreements'] = false;
        }

        if (!isset($params['email'])) {
            $params['email'] = false;
        }
        
        return $params;
    }
}
