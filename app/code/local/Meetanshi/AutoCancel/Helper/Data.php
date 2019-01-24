<?php

class Meetanshi_AutoCancel_Helper_Data extends Mage_Core_Helper_Abstract
{
    const AUTOCANCEL_GENERAL_ENABLE = 'autocancel/general/enabled';
    const AUTOCANCEL_GENERAL_DAYS = 'autocancel/general/days';
    const AUTOCANCEL_GENERAL_STATUS = 'autocancel/general/status';
    const AUTOCANCEL_GENERAL_PAYMENT = 'autocancel/general/payments';
    const AUTOCANCEL_GENERAL_RECEIVER = 'autocancel/general/receiver';
    const AUTOCANCEL_GENERAL_TEMPLATE = 'autocancel/general/template';

    public function getAutoCancel()
    {
        try {
            if ( Mage::getStoreConfig(self::AUTOCANCEL_GENERAL_ENABLE) ) {
                return Mage::getStoreConfig(self::AUTOCANCEL_GENERAL_DAYS);
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }


    public function getConfigStatus()
    {
        return Mage::getStoreConfig(self::AUTOCANCEL_GENERAL_STATUS);
    }

    public function getConfigPayment()
    {
        return Mage::getStoreConfig(self::AUTOCANCEL_GENERAL_PAYMENT);
    }

    public function sendEmail($param)
    {
        $param = array();
        try {
            $param['incrementid'] = $param;
            $senderName = $receiverName = Mage::getStoreConfig('trans_email/ident_' . Mage::getStoreConfig(self::AUTOCANCEL_GENERAL_RECEIVER) . '/name');
            $senderEmail = $receiverEmail = Mage::getStoreConfig('trans_email/ident_' . Mage::getStoreConfig(self::AUTOCANCEL_GENERAL_RECEIVER) . '/name');

            $mailTemplate = Mage::getModel('core/email_template')
                ->loadDefault(Mage::getStoreConfig(self::AUTOCANCEL_GENERAL_TEMPLATE));

            $mailTemplate
                ->setDesignConfig(array('area' => 'frontend'))
                ->setTemplateSubject("Orders have been cancelled")
                ->sendTransactional(
                    Mage::getStoreConfig(self::AUTOCANCEL_GENERAL_TEMPLATE),
                    array(
                        'name' => $senderName,
                        'email' => $senderEmail
                    ),
                    $receiverEmail,
                    $receiverName,
                    $param
                );
        } catch (\Exception $e) {
            $e->getMessage();
        }

    }
}