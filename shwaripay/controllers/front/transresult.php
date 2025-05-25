<?php

class ShwaripayTransresultModuleFrontController extends ModuleFrontController
{
    public function postProcess()
    {
        $rawData = file_get_contents('php://input');

        $data = json_decode($rawData, true);
        
        $this->logMessage('ResultURL payload: ' . $rawData);
        
        if (isset($data['Result']) && isset($data['Result']['ResultCode'])) {
            $resultCode = $data['Result']['ResultCode'];
              // Look for ReceiptNo in ResultParameters
    		if (isset($data['Result']['ResultParameters']['ResultParameter'])) {
        		foreach ($data['Result']['ResultParameters']['ResultParameter'] as $param) {
            		if (isset($param['Key']) && $param['Key'] === 'ReceiptNo') {
                		$transactionId = $param['Value'] ?? null;
                		break;
            		}
        		}
    		}
          if (isset($data['Result']['ResultParameters']['ResultParameter'])) {
        		foreach ($data['Result']['ResultParameters']['ResultParameter'] as $param) {
            		if (isset($param['Key']) && $param['Key'] === 'Amount') {
                		$amountPaid = $param['Value'] ?? null;
                		break;
            		}
        		}
    		}
          
            $orderId = $this->getOrderIdFromTransactionId($transactionId);
          
          	$sql = 'SELECT * FROM `' . _DB_PREFIX_ . 'orders` WHERE `id_cart` = ' . (int)$orderId;
            $orderData = Db::getInstance()->getRow($sql);

            if ($orderData) {
                $order_id = $orderData['id_order'];
            }

            $order = new Order((int)$order_id);
			$amountToBePaid = $order->total_paid;
            if ($resultCode == '0' && $amountPaid == $amountToBePaid) {
              $this->logMessage('Transaction found:  updating order ' . $resultCode);
                $this->updateOrderStatus($orderId, 'completed');
            } else {
                $this->logMessage('Transaction failed:  updating order to failed' . $resultCode);
                $this->updateOrderStatus($orderId, 'failed');
            }
        } else {
            $this->logMessage('Invalid payload received at ResultURL.');
        }
    }
    private function getOrderIdFromTransactionId($transactionId)
    {
        // Query your database to retrieve order ID associated with this transaction ID
        return Db::getInstance()->getValue(
            'SELECT order_id FROM ' . _DB_PREFIX_ . 'used_transaction_ids WHERE transaction_id = "' . pSQL($transactionId) . '"'
        );
    }

    private function updateOrderStatus($orderId, $status)
    {
        // Update order status in the database
        Db::getInstance()->update(
            'stk_requests',
            ['status' => $status],
            'order_id = "' . pSQL($orderId) . '"'
        );

        // Further logic if needed
      if($status === 'completed'){
        $this->validateAndUpdateOrder($orderId);
      }     
    }

    private function validateAndUpdateOrder($orderId)
    {
        try {
            $sql = 'SELECT * FROM `' . _DB_PREFIX_ . 'orders` WHERE `id_cart` = ' . (int)$orderId;
            $orderData = Db::getInstance()->getRow($sql);

            if ($orderData) {
                $orderId = $orderData['id_order'];
            }

            $order = new Order((int)$orderId);
            if (!Validate::isLoadedObject($order)) {
                throw new Exception('Invalid order ID: ' . $orderId);
            }

            $customer = new Customer($order->id_customer);
            if (!Validate::isLoadedObject($customer)) {
                throw new Exception('Invalid customer for order: ' . $order->id_customer);
            }

            $orderStatusId = Configuration::get('PS_OS_SHWARIPAY_PAYMENT');
            if (!$orderStatusId) {
                throw new Exception('Payment status configuration missing: PS_OS_SHWARIPAY_PAYMENT');
            }

            // Update order status
            $order->setCurrentState($orderStatusId);
          	$order->sendOrderStateEmail();
    		// Ensure the frontend knows about the status change by updating the session or forcing a page reload
    		$this->context->cookie->write();
          
            $this->logMessage("Order status updated for Order ID: $orderId");
        } catch (Exception $e) {
            throw new Exception('Order validation and update error: ' . $e->getMessage());
        }
    }

    private function logMessage($message)
    {
        Logger::addLog($message, 1, null, null, null, true);

        $logFile = _PS_MODULE_DIR_ . 'shwaripay/logs/resulturl_log.txt';
        if (!file_exists(dirname($logFile))) {
            mkdir(dirname($logFile), 0755, true);
        }

        $message = date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL;
        file_put_contents($logFile, $message, FILE_APPEND);
    }
}
