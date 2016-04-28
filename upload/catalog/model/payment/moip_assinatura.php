<?php
class ModelPaymentMoipAssinatura extends Model {
    
    public function getMethod($address, $total) {
		$this->load->language('payment/moip_assinatura');

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone_to_geo_zone` WHERE `geo_zone_id` = '" . (int)$this->config->get('moip_assinatura_geo_zone_id') . "' AND `country_id` = '" . (int)$address['country_id'] . "' AND (`zone_id` = '" . (int)$address['zone_id'] . "' OR `zone_id` = '0')");

		if (!$this->config->get('moip_assinatura_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			$method_data = array(
				'code'       => 'moip_assinatura',
				'title'      => $this->language->get('text_credit_cart'),
				'terms'      => '',
				'sort_order' => $this->config->get('moip_assinatura_sort_order')
			);
		}

		return $method_data;
	}
    
    public function recurringPayments() {
        $products = $this->cart->getProducts();
        
        foreach($products as $product) {
            if ($product['recurring'] === false) {
                $this->cart->remove($product['cart_id']);
            }
        }
        
        return true;
	}

    public function addOrderRecurringTransition($recurring_id, $json) {
        
        $data = json_decode($json, true);
        
        if (isset($data['code'])) {
            $order_recurring_id = preg_replace('/[^\d]/', '', $data['code']);
        } else {
            throw new Exception('Recurring ID required');
        }
        
        if (isset($data['invoice']['id'])) {
            $invoice_id = $data['invoice']['id'];
        } else {
            throw new Exception('Invoice ID required');
        }
        
        $invoice_identify = 0;
        
        if (isset($data['invoice']['amount'])) {
            $invoice_amount = ($data['invoice']['amount']/100);
        } else {
            $invoice_amount = 0;
        }
        
        if (isset($data['invoice']['moip_id'])) {
            $invoice_moip_id = $data['invoice']['moip_id'];
        } else {
            $invoice_moip_id = 0;
        }
        
        if (isset($data['invoice']['payment_method'])) {
            $invoice_payment_method = $data['invoice']['payment_method'];
        } else {
            $invoice_payment_method = array();
        }
        
        if (isset($data['invoice']['next_invoice_date'])) {
            $next_invoice_date = $data['invoice']['next_invoice_date']['year'] . '-' . $data['invoice']['next_invoice_date']['month'] . '-' . $data['invoice']['next_invoice_date']['day'];
        } else {
            $next_invoice_date = '';
        }
        
        if (isset($data['customer']['code'])) {
            $customer_code = preg_replace('/[^\d]/', '', $data['customer']['code']);
        } elseif (isset($data['invoice']['customer'])) {
            $customer_code = preg_replace('/[^\d]/', '', $data['invoice']['customer']);
        } elseif ($this->customer->isLogged()) {
            $customer_code = $this->customer->isLogged();
        } else {
            $customer_code = false;
        }
        
        switch($data['invoice']['status']['code']) {
            case 1:
                $transiction_status = $this->config->get('moip_assinatura_active');
                $recurring_status = $this->config->get('moip_assinatura_recurring_status_active');
                break;
            case 2:
                $transiction_status = $this->config->get('moip_assinatura_suspended');
                $recurring_status = $this->config->get('moip_assinatura_recurring_status_suspended');
                break;
            case 3:
                $transiction_status = $this->config->get('moip_assinatura_expired');
                $recurring_status = $this->config->get('moip_assinatura_recurring_status_expired');
                break;
            case 4:
                $transiction_status = $this->config->get('moip_assinatura_overdue');
                $recurring_status = $this->config->get('moip_assinatura_recurring_status_overdue');
                break;
            case 5:
                $transiction_status = $this->config->get('moip_assinatura_canceled');
                $recurring_status = $this->config->get('moip_assinatura_recurring_status_canceled');
                break;
            case 6:
                $transiction_status = $this->config->get('moip_assinatura_trial');
                $recurring_status = $this->config->get('moip_assinatura_recurring_status_trial');
                break;
            default:
                $transiction_status = '';
                $recurring_status = '';
                break;
        }
        
        $this->db->query('INSERT INTO ' . DB_PREFIX . 'order_recurring_transaction SET order_recurring_id = "' . (int)$order_recurring_id . '", reference = "Valdeir Santana", type = "' . (int)$transiction_status . '", amount = "' . (int)$invoice_amount . '", date_added = NOW()');
        
        if ($this->checkInvoiceExist($data['invoice']['id'])) {
            $this->db->query('UPDATE ' . DB_PREFIX . 'order_recurring_moip SET invoice_amount = "' . (int)$invoice_amount . '", invoice_identify = "' . $this->db->escape($invoice_identify) . '", invoice_moip_id = "' . $this->db->escape($invoice_moip_id) . '", payment_method = "' . $this->db->escape(json_encode($invoice_payment_method)) . '" WHERE invoice_id = "' . $this->db->escape($invoice_id) . '"');
            
            if (!empty($next_invoice_date)) {
                $this->db->query('UPDATE ' . DB_PREFIX . 'order_recurring_moip SET next_invoice_date = "' . $this->db->escape($next_invoice_date) . '" WHERE invoice_id = "' . $this->db->escape($invoice_id) . '"');
            }
        } else {
            $this->db->query('INSERT INTO ' . DB_PREFIX . 'order_recurring_moip SET invoice_id = "' . $this->db->escape($invoice_id) . '", next_invoice_date = "' . $this->db->escape($next_invoice_date) . '", recurring_id = "' . (int)$recurring_id. '", customer_id = "' . (int)$customer_code . '"');
        }
        
        $this->db->query('UPDATE ' . DB_PREFIX . 'order_recurring SET status = "' . (int)$transiction_status . '" WHERE order_recurring_id = "' . (int)$order_recurring_id . '"');
        
        return $transiction_status;
    }
    
    public function getAffiliate($affiliate_id) {
        $query = $this->db->query('SELECT CONCAT(firstname, " ", lastname) as affiliate_name FROM ' . DB_PREFIX . 'affiliate WHERE affiliate_id = "' . (int)$affiliate_id . '"');
        
        return $query->row['affiliate_name'];
    }

    public function checkCustomerRegistedMoip($customer_id) {
        $query = $this->db->query('SELECT credit_card FROM ' . DB_PREFIX . 'customer_moip WHERE customer_id = "' . (int)$customer_id . '" and credit_card <> ""');
        
        $this->session->data['customer_registed_moip'] = ($query->num_rows) ? true : false;
        
        return ($query->num_rows) ? true : false;
    }

    public function registerCustomerMoip($customer_id) {
        $this->db->query('INSERT INTO ' . DB_PREFIX . 'customer_moip SET customer_id = "' . (int)$customer_id . '", register = 1, credit_card = 1, date_added = NOW(), date_modified = NOW()');
        
        return $customer_id;
    }

    private function checkInvoiceExist($invoice_id) {
        return $this->db->query('SELECT COUNT(*) as total FROM ' .DB_PREFIX . 'order_recurring_moip WHERE invoice_id = "' . (float)$invoice_id . '"')->num_rows;
    }
}