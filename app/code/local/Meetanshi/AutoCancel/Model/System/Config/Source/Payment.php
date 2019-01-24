<?php


class Meetanshi_AutoCancel_Model_System_Config_Source_Payment
{
    public function toOptionArray()
    {
        $payments = Mage::getSingleton('payment/config')->getAllMethods();

        foreach ($payments as $paymentCode=>$paymentModel) {
            $paymentTitle = Mage::getStoreConfig('payment/'.$paymentCode.'/title');
            $methods[$paymentCode] = array(
                'label'   => $paymentTitle,
                'value' => $paymentCode,
            );
        }
        return $methods;
    }
}