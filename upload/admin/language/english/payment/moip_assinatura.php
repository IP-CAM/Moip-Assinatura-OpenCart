<?php
//Heading
$_['heading_title'] = 'Moip Assinatura';

//Tab
$_['tab_general']        = 'Geral';
$_['tab_payment_status'] = 'Status de Pagamento';
$_['tab_retries']        = 'Retentativas';
$_['tab_custom_field']   = 'Campos Personalizados';
$_['tab_payment_method'] = 'Formas de Pagamento';

//Text
$_['text_success']                         = 'Você atualizou o módulo Moip Assinatura com sucesso.';
$_['text_payment']                         = 'Formas de Pagamento';
$_['text_retries']                         = 'após a última tentativa';
$_['entry_notify_url']                     = 'URL de Retorno';
$_['text_recurring_status']                = 'Situação da Assinatura';
$_['text_transaction_status']              = 'Situação de Transação';
$_['text_transaction_payment']             = 'Paga';
$_['text_transaction_payment']             = 'Paga';
$_['text_transaction_outstanding_payment'] = 'Pagamento Pendente';
$_['text_transaction_skipped']             = 'Pagamento Ignorado';
$_['text_transaction_failed']              = 'Falha no pagamento';
$_['text_transaction_cancelled']           = 'Cancelada';
$_['text_transaction_suspended']           = 'Suspensa';
$_['text_transaction_suspended_failed']    = 'Falha na suspensão';
$_['text_transaction_outstanding_failed']  = 'Falha no pagamento';
$_['text_transaction_expired']             = 'Expirada';
$_['text_export_plan']                     = 'Deseja exportar seus planos para o MoIP?';
$_['text_one_day']                         = '1 Dia';
$_['text_three_days']                      = '3 Dias';
$_['text_five_days']                       = '5 Dias';
$_['text_seven_days']                      = '7 Dias';
$_['text_cancel']                          = 'Cancelar';
$_['text_suspend']                         = 'Suspender';

//Entry
$_['entry_status']              = 'Situação';
$_['entry_token']               = 'Api Token';
$_['entry_key']                 = 'Api Key';
$_['entry_authorization']       = 'Autorização';
$_['entry_sandbox']             = 'Modo de Teste';
$_['entry_debug']               = 'Debug';
$_['entry_geo_zone']            = 'Zona Geográfica';
$_['entry_sort_order']          = 'Ordem';
$_['entry_active']              = 'Ativada';
$_['entry_suspended']           = 'Suspensa';
$_['entry_expired']             = 'Expirada';
$_['entry_overdue']             = 'Retentativa';
$_['entry_canceled']            = 'Cancelada';
$_['entry_trial']               = 'Período de Teste';
$_['entry_first_try']           = 'Primeira Tentativa';
$_['entry_second_try']          = 'Segunda Tentativa';
$_['entry_third_try']           = 'Terceira Tentativa';
$_['entry_last_try']            = 'Última Tentativa';
$_['entry_cpf']                 = 'CPF';
$_['entry_birth_date']          = 'Data de Nascimento';
$_['entry_address_number']      = 'Número de Residência';
$_['entry_credit_card_status']  = 'Cartão de Crédito';
$_['entry_billet_status']       = 'Boleto';
$_['entry_payment_default']     = 'Pagamento Padrão';

//Button
$_['button_export']             = 'Exportar Planos';

//Help
$_['valdeir'] = 'Teste';
$_['help_status']              = 'Habilita/Desabilita o módulo Moip Assinatura';
$_['help_token']               = 'Token de Autorização';
$_['help_key']                 = 'Key de Autorização';
$_['help_authorization']       = 'Para obter seu código de autorização acesse: https://assinaturas.moip.com.br/<br>configuracoes';
$_['help_sandbox']             = 'Habilita/Desabilita o modo de teste';
$_['help_debug']               = 'Debug';
$_['help_geo_zone']            = 'Selecione a zona geográfica para o funcionamento do módulo';
$_['help_sort_order']          = 'Ordem de Exibição';
$_['help_active']              = 'A assinatura está ativa, ou seja, o cliente assinante será cobrado a cada ciclo.';
$_['help_suspended']           = 'As cobranças da assinatura estão suspensas, ou seja, o cliente assinante não será cobrado a cada ciclo.';
$_['help_expired']             = 'A assinatura está expirada, ou seja, já atingiu o limite de cobranças configuradas no plano contratado e não gerará mais cobranças.';
$_['help_overdue']             = 'A assinatura está com o pagamento de sua fatura atrasada e entrou no fluxo de retentativas. Para saber mais sobre retentativas de pagamentos.';
$_['help_canceled']            = 'A assinatura foi cancelada e não poderá mais ser reativada ou editada de nenhuma maneira. Em outras palavras, o cancelamento é a inativação definitiva de uma assinatura.';
$_['help_trial']               = 'O trial é um período de testes de uma assinatura, ele pode ter uma taxa de inscrição ou ser gratuito. Para configurar as preferências do seu trial, você deve utilizar a API de Planos ou utilizar a interface do Moip Assinaturas.';
$_['help_first_try']           = 'As retentativas automáticas são executadas em casos onde uma fatura (pagamento periódico) esteja atrasada. ';
$_['help_second_try']          = 'As retentativas automáticas são executadas em casos onde uma fatura (pagamento periódico) esteja atrasada. ';
$_['help_third_try']           = 'As retentativas automáticas são executadas em casos onde uma fatura (pagamento periódico) esteja atrasada. ';
$_['help_last_try']            = 'As retentativas automáticas são executadas em casos onde uma fatura (pagamento periódico) esteja atrasada. ';
$_['help_cpf']                 = 'CPF';
$_['help_birth_date']          = 'Data de Nascimento';
$_['help_address_number']      = 'Número de Residência';
$_['help_credit_card_status']  = 'Cartão de Crédito';
$_['help_billet_status']       = 'Boleto';
$_['help_payment_default']     = 'Pagamento utilizado na criação/importação de novos planos';
$_['help_'] = 'HELP';

//Error
$_['error_warning']        = 'Atenção! Você não tem permissão para alterar o módulo Moip Assinatura';
$_['error_token']          = 'Token inválido';
$_['error_key']            = 'Key inválida';
$_['error_authorization']  = 'Campo Obrigatório';
$_['error_cpf']            = 'Campo Obrigatório';
$_['error_birth_date']     = 'Campo Obrigatório';
$_['error_address_number'] = 'Campo Obrigatório';