<?php
class ControllerPaymentMoipAssinatura extends Controller {
    
    public function index() {
        
        $data = $this->language->load('payment/moip_assinatura');
        
        $this->load->model('checkout/order');
        $this->load->model('payment/moip_assinatura');
        
        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        
        $data['customer_name'] = $order_info['firstname'] . ' ' . $order_info['lastname'];
        
        $data['customer_birth_date'] = $order_info['custom_field'][$this->config->get('moip_assinatura_birth_date')];
        
        $data['customer_cpf'] = $order_info['custom_field'][$this->config->get('moip_assinatura_cpf')];
        
        $data['customer_telephone'] = $order_info['telephone'];
        
        $data['redirect'] = $this->url->link('checkout/success', '', true);
        
        $data['customer_registed_moip'] = $this->model_payment_moip_assinatura->checkCustomerRegistedMoip($order_info['customer_id']);
        
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template'))) {
            return $this->load->view($this->config->get('config_template') . '/template/payment/moip_assinatura.tpl', $data);
        } else {
            return $this->load->view('default/template/payment/moip_assinatura.tpl', $data);
        }
    }
    
    public function transition() {
        
        $this->language->load('payment/moip_assinatura');
        
        $this->load->model('checkout/order');
        $this->load->model('checkout/recurring');
        $this->load->model('catalog/product');
        $this->load->model('payment/moip_assinatura');
        
        $order_id = $this->session->data['order_id'];
        
        $order_info = $this->model_checkout_order->getOrder($order_id);
        
        $this->load->model('checkout/order');
        
        $products = $this->cart->getProducts();
        
        $customer_registed_moip = ($this->session->data['customer_registed_moip']) ? false : true;
        
        $recurring_data = array();
        
        $json = array();
        
        foreach($products as $product) {
            
            if (empty($product['recurring'])) {
                continue;
            }
            
            for($quantity = 1; $quantity <= $product['quantity']; $quantity++) {
                $recurring_data['product_id'] = $product['product_id'];
                $recurring_data['name'] = $product['name'];
                $recurring_data['quantity'] = $product['quantity'];
                
                $recurring_data['recurring']['recurring_id'] = $product['recurring']['recurring_id'];
                $recurring_data['recurring']['name'] = $product['recurring']['name'];
                $recurring_data['recurring']['frequency'] = $product['recurring']['frequency'];
                $recurring_data['recurring']['cycle'] = $product['recurring']['cycle'];
                $recurring_data['recurring']['duration'] = $product['recurring']['duration'];
                $recurring_data['recurring']['price'] = $product['recurring']['price'];
                $recurring_data['recurring']['trial'] = $product['recurring']['trial'];
                $recurring_data['recurring']['trial_frequency'] = $product['recurring']['trial_frequency'];
                $recurring_data['recurring']['trial_cycle'] = $product['recurring']['trial_cycle'];
                $recurring_data['recurring']['trial_duration'] = $product['recurring']['trial_duration'];
                $recurring_data['recurring']['trial_price'] = $product['recurring']['trial_price'];
                
                $recurring_id = $this->model_checkout_recurring->create($recurring_data, $order_id, '');
                
                if ($order_info['affiliate_id']) {
                    $this->model_checkout_recurring->addReference($recurring_id, $this->model_payment_moip_assinatura->getAffiliate($order_info['affiliate_id']));
                } else {
                    $this->model_checkout_recurring->addReference($recurring_id, 'Valdeir Santana');
                }
                
                $data = array();
            
                $data['code'] = 'assinatura' . $recurring_id;
                
                $data['amount'] = ($this->currency->format($product['price'], null, null, false) * 100);
                
                $data['payment_method'] = 'CREDIT_CARD';
                
                $data['plan'] = array(
                    'code' => 'plano' . $product['recurring']['recurring_id']
                );
                
                $data['customer'] = array();
                
                $data['customer']['code'] = 'customer' . $order_info['customer_id'];
                
                if (!$this->session->data['customer_registed_moip']) {
                    $data['customer']['email'] = $order_info['email'];
                    $data['customer']['fullname'] = $order_info['firstname'] . ' ' . $order_info['lastname'];
                    $data['customer']['cpf'] = preg_replace('/[^\d]/', '', $this->request->post['cpf']);
                    $data['customer']['phone_area_code'] = substr(preg_replace('/[^\d]/', '', $this->request->post['telephone']), 0, 2);
                    $data['customer']['phone_number'] = substr(preg_replace('/[^\d]/', '', $this->request->post['telephone']), 2);
                    
                    $customer_birth_date = explode('-', $this->request->post['birth_date']);
                    
                    $data['customer']['birthdate_day'] = $customer_birth_date[2];
                    $data['customer']['birthdate_month'] = $customer_birth_date[1];
                    $data['customer']['birthdate_year'] = $customer_birth_date[0];
                    
                    $data['customer']['address'] = array();
                    $data['customer']['address']['street']   = $order_info['payment_address_1'];
                    $data['customer']['address']['district'] = $order_info['payment_address_2'];
                    $data['customer']['address']['number']   = $order_info['payment_custom_field'][$this->config->get('moip_assinatura_address_number')];
                    $data['customer']['address']['city']     = $order_info['payment_city'];
                    $data['customer']['address']['state']    = $order_info['payment_zone_code'];
                    $data['customer']['address']['country']  = $order_info['payment_iso_code_3'];
                    $data['customer']['address']['zipcode']  = $order_info['payment_postcode'];
                    
                    $data['customer']['billing_info'] = array();
                    $data['customer']['billing_info']['credit_card'] = array();
                    $data['customer']['billing_info']['credit_card']['holder_name'] = $this->request->post['name'];
                    $data['customer']['billing_info']['credit_card']['number'] = preg_replace('/[^\d]/', '', $this->request->post['credit_card']);
                    $data['customer']['billing_info']['credit_card']['expiration_month'] = substr(preg_replace('/[^\d]/', '', $this->request->post['validade']), 0, 2);
                    $data['customer']['billing_info']['credit_card']['expiration_year'] = substr(preg_replace('/[^\d]/', '', $this->request->post['validade']), 2);
                }
                
                try {
                    $MoipAssinatura = new MoipAssinatura(
                        $this->config->get('moip_assinatura_token'),
                        $this->config->get('moip_assinatura_key'),
                        $this->config->get('moip_assinatura_sandbox'),
                        $this->config->get('moip_assinatura_debug')
                    );
                    
                    $result = $MoipAssinatura->createSubscriptions($data, $customer_registed_moip);
                    
                    $result_decode = json_decode($result->body, true);
                    
                    if (empty($result_decode['errors'])) {
                        $json[] = array_merge($json, $result_decode);
                    
                        $this->model_payment_moip_assinatura->addOrderRecurringTransition($recurring_id, $result->body);
                        
                        $this->model_payment_moip_assinatura->registerCustomerMoip($order_info['customer_id']);
                    } else {
                        foreach($result_decode['errors'] as $error) {
                            $json[] = array(
                                'error' => true,
                                'code' => 'assinatura' . $recurring_id,
                                'message' => $error['description'],
                                'product' => $product['name'],
                                'plan' => array(
                                    'code' => 'plano'.$product['recurring']['recurring_id'],
                                    'name' => $product['recurring']['name']
                                )
                            );
                        }
                    }
                } catch (Exception $e) {
                    $errors = json_decode($e->getMessage(), true);
                    
                    $json[] = array(
                        'error' => true,
                        'code' => 'assinatura' . $recurring_id,
                        'message' => $this->language->get('error_recurring'),
                        'errors' => $errors['errors'],
                        'product' => $product['name'],
                        'plan' => array(
                            'code' => 'plano'.$product['recurring']['recurring_id'],
                            'name' => $product['recurring']['name']
                        )
                    );
                }
            }
        }
        
        if (empty($json)) {
            $json[] = array(
                'error' => true,
                'message' => $this->language->get('error_plan_not_exist'),
                'product' => $product['name'],
                'plan' => array(
                    'code' => $this->language->get('text_invalid'),
                    'name' => $this->language->get('text_invalid')
                )
            );
        }
        
        $this->response->addHeader('content-type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function notify() {
        if (
            ($this->config->get('moip_assinatura_status') && isset($this->request->get['authorization'])) && 
            $this->config->get('moip_assinatura_authorization') == $this->request->get['authorization']
        ){
            $result = json_decode(file_get_contents('php://input'), true);
            
            $log = new Log('moip_assinatura2.log');
            
            $this->load->model('payment/moip_assinatura');
            
            try {
                $this->model_payment_moip_assinatura->addOrderRecurringTransition(0, json_encode(array(
                    'code' => $result['resource']['subscription_code'],
                    'invoice' => $result['resource']
                )), false);
            } catch (Exception $e) {
                if ($this->config->get('moip_assinatura_debug')) {
                    $log->write($e->getMessage());
                }
            }
        }
    }
}