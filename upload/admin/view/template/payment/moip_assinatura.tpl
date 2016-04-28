<?php echo $header ?><?php echo $column_left ?>
<div id="content">
  
  <div class="container-fluid">
    <div class="page-header">
      <h1><?php echo $heading_title ?></h1>
      
      <ul class="breadcrumb">
        <?php foreach($breadcrumbs as $breadcrumb): ?>
        <li><a href="<?php echo $breadcrumb['href'] ?>"><?php echo $breadcrumb['name'] ?></a></li>
        <?php endforeach ?>
      </ul>
      
      <div class="pull-right">
        <button type="submit" form="form-moip-assinatura" class="btn btn-primary" data-toggle="tooltip" title="<?php echo $button_save ?>"><i class="fa fa-save"></i></button>
        <?php if ($export_plan) { ?>
        <button type="button" class="btn btn-info" id="export-plan" onClick="exportPlan()" data-text-loading="<?php echo $text_loading ?>" data-toggle="tooltip" title="<?php echo $button_export ?>"><i class="fa fa-th-large"></i></button>
        <?php } ?>
        <a href="<?php echo $cancel ?>" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_cancel ?>"><i class="fa fa-reply"></i></a>
      </div>
    </div>
  </div>
  
  <div class="container-fluid">
    
    <?php if ($error_warning): ?>
    <div class="alert alert-warning">
      <i class="fa fa-exclamation-circle"></i> <?php echo $error_warning ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php endif ?>
    
    <div class="alert alert-warning" id="alert-warning" style="display:none"></div>
    <div class="alert alert-success" id="alert-success" style="display:none"></div>
    
    <div class="panel panel-default">
      
      <div class="panel-heading">
        <h3 class="page-title"><i class="fa fa-pencil"></i> <?php echo $heading_title ?></h3>
      </div>
      
      <div class="panel-body">
        
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general ?></a></li>
          <li><a href="#tab-payment-status" data-toggle="tab"><?php echo $tab_payment_status ?></a></li>
          <li><a href="#tab-retries" data-toggle="tab"><?php echo $tab_retries ?></a></li>
          <li><a href="#tab-custom-field" data-toggle="tab"><?php echo $tab_custom_field ?></a></li>
          <!--<li><a href="#tab-payment-method" data-toggle="tab"><?php echo $tab_payment_method ?></a></li>-->
        </ul>
        
        <!-- Form -->
        <form action="<?php echo $action ?>" method="post" enctype="multipart/form-data" id="form-moip-assinatura" class="form-horizontal">
          
          <!-- .tab-content -->
          <div class="tab-content">
            
            <!-- Tab General -->
            <div class="tab-pane active" id="tab-general">
              
              <!-- Input moip_assinatura_status -->
              <div class="form-group">
                <label class="control-label col-sm-2"><span data-toggle="tooltip" title="<?php echo $help_status ?>"><?php echo $entry_status ?></span></label>
                <div class="col-sm-10">
                  <select name="moip_assinatura_status" class="form-control">
                    <option value="1" <?php echo ($moip_assinatura_status) ? 'selected' : '' ?>><?php echo $text_enabled ?></option>
                    <option value="0" <?php echo (!$moip_assinatura_status) ? 'selected' : '' ?>><?php echo $text_disabled ?></option>
                  </select>
                </div>
              </div>
              
              <!-- Input moip_assinatura_token -->
              <div class="form-group required">
                <label class="control-label col-sm-2"><span data-toggle="tooltip" title="<?php echo $help_token ?>"><?php echo $entry_token ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="moip_assinatura_token" value="<?php echo $moip_assinatura_token ?>" placeholder="<?php echo $entry_token ?>" class="form-control" />
                  <?php if ($error_token): ?>
                  <span class="text-danger"><?php echo $error_token ?></span>
                  <?php endif ?>
                </div>
              </div>
              
              <!-- Input moip_assinatura_key -->
              <div class="form-group required">
                <label class="control-label col-sm-2"><span data-toggle="tooltip" title="<?php echo $help_key ?>"><?php echo $entry_key ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="moip_assinatura_key" value="<?php echo $moip_assinatura_key ?>" placeholder="<?php echo $entry_key ?>" class="form-control" />
                  <?php if ($error_key): ?>
                  <span class="text-danger"><?php echo $error_key ?></span>
                  <?php endif ?>
                </div>
              </div>
              
              <!-- Input moip_assinatura_authorization -->
              <div class="form-group required">
                <label class="control-label col-sm-2"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_authorization ?>"><?php echo $entry_authorization ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="moip_assinatura_authorization" value="<?php echo $moip_assinatura_authorization ?>" placeholder="<?php echo $entry_authorization ?>" class="form-control" />
                  <?php if ($error_authorization): ?>
                  <span class="text-danger"><?php echo $error_authorization ?></span>
                  <?php endif ?>
                </div>
              </div>
              
              <!-- Input notify_url -->
              <div class="form-group required">
                <label class="control-label col-sm-2"><span data-toggle="tooltip" data-html="true" title="<?php echo $help_authorization ?>"><?php echo $entry_notify_url ?></span></label>
                <div class="col-sm-10">
                  <input type="text" id="notify_url" value="<?php echo $notify_url ?>" class="form-control" readonly />
                </div>
              </div>
              
              <!-- Input moip_assinatura_sandbox -->
              <div class="form-group">
                <label class="control-label col-sm-2"><span data-toggle="tooltip" title="<?php echo $help_sandbox ?>"><?php echo $entry_sandbox ?></span></label>
                <div class="col-sm-10">
                  <select name="moip_assinatura_sandbox" class="form-control">
                    <option value="1" <?php echo ($moip_assinatura_sandbox) ? 'selected' : '' ?>><?php echo $text_enabled ?></option>
                    <option value="0" <?php echo (!$moip_assinatura_sandbox) ? 'selected' : '' ?>><?php echo $text_disabled ?></option>
                  </select>
                </div>
              </div>
              
              <!-- Input moip_assinatura_debug -->
              <div class="form-group">
                <label class="control-label col-sm-2"><span data-toggle="tooltip" title="<?php echo $help_debug ?>"><?php echo $entry_debug ?></span></label>
                <div class="col-sm-10">
                  <select name="moip_assinatura_debug" class="form-control">
                    <option value="1" <?php echo ($moip_assinatura_debug) ? 'selected' : '' ?>><?php echo $text_enabled ?></option>
                    <option value="0" <?php echo (!$moip_assinatura_debug) ? 'selected' : '' ?>><?php echo $text_disabled ?></option>
                  </select>
                </div>
              </div>
              
              <!-- Input moip_assinatura_geo_zone_id -->
              <div class="form-group">
                <label class="control-label col-sm-2"><span data-toggle="tooltip" title="<?php echo $help_geo_zone ?>"><?php echo $entry_geo_zone ?></span></label>
                <div class="col-sm-10">
                  <select name="moip_assinatura_geo_zone_id" class="form-control">
                    <option value=""><?php echo $text_all_zones ?></option>
                    <?php foreach($geo_zones as $zone): ?>
                    <option value="<?php echo $zone['geo_zone_id'] ?>"><?php echo $zone['name'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              
              <!-- Input moip_assinatura_sort_order -->
              <div class="form-group">
                <label class="control-label col-sm-2"><span data-toggle="tooltip" title="<?php echo $help_sort_order ?>"><?php echo $entry_sort_order ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="moip_assinatura_sort_order" value="<?php echo $moip_assinatura_sort_order ?>" placeholder="<?php echo $entry_sort_order ?>" class="form-control" />
                </div>
              </div>
            </div>
            
            <!-- Tab Payment Status -->
            <div class="tab-pane" id="tab-payment-status">
              
              <fieldset>
                <legend><?php echo $text_recurring_status ?></legend>
                
                <!-- Input moip_assinatura_recurring_status_active -->
                <div class="form-group">
                  <label class="control-label col-sm-2"><span data-toggle="tooltip" title="<?php echo $help_active ?>"><?php echo $entry_active ?></span></label>
                  <div class="col-sm-10">
                    <select name="moip_assinatura_recurring_status_active" class="form-control">
                      <?php foreach($recurring_statuses as $status): ?>
                        <?php if ($moip_assinatura_recurring_status_active == $status['order_status_id']): ?>
                        <option value="<?php echo $status['order_status_id'] ?>" selected><?php echo $status['name'] ?></option>
                        <?php else: ?>
                        <option value="<?php echo $status['order_status_id'] ?>"><?php echo $status['name'] ?></option>
                        <?php endif ?>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                
                <!-- Input moip_assinatura_recurring_status_suspended -->
                <div class="form-group">
                  <label class="control-label col-sm-2"><span data-toggle="tooltip" title="<?php echo $help_suspended ?>"><?php echo $entry_suspended ?></span></label>
                  <div class="col-sm-10">
                    <select name="moip_assinatura_recurring_status_suspended" class="form-control">
                      <?php foreach($recurring_statuses as $status): ?>
                        <?php if ($moip_assinatura_recurring_status_suspended == $status['order_status_id']): ?>
                        <option value="<?php echo $status['order_status_id'] ?>" selected><?php echo $status['name'] ?></option>
                        <?php else: ?>
                        <option value="<?php echo $status['order_status_id'] ?>"><?php echo $status['name'] ?></option>
                        <?php endif ?>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                
                <!-- Input moip_assinatura_recurring_status_expired -->
                <div class="form-group">
                  <label class="control-label col-sm-2"><span data-toggle="tooltip" title="<?php echo $help_expired ?>"><?php echo $entry_expired ?></span></label>
                  <div class="col-sm-10">
                    <select name="moip_assinatura_recurring_status_expired" class="form-control">
                      <?php foreach($recurring_statuses as $status): ?>
                        <?php if ($moip_assinatura_recurring_status_expired == $status['order_status_id']): ?>
                        <option value="<?php echo $status['order_status_id'] ?>" selected><?php echo $status['name'] ?></option>
                        <?php else: ?>
                        <option value="<?php echo $status['order_status_id'] ?>"><?php echo $status['name'] ?></option>
                        <?php endif ?>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                
                <!-- Input moip_assinatura_recurring_status_overdue -->
                <div class="form-group">
                  <label class="control-label col-sm-2"><span data-toggle="tooltip" title="<?php echo $help_overdue ?>"><?php echo $entry_overdue ?></span></label>
                  <div class="col-sm-10">
                    <select name="moip_assinatura_recurring_status_overdue" class="form-control">
                      <?php foreach($recurring_statuses as $status): ?>
                        <?php if ($moip_assinatura_recurring_status_overdue == $status['order_status_id']): ?>
                        <option value="<?php echo $status['order_status_id'] ?>" selected><?php echo $status['name'] ?></option>
                        <?php else: ?>
                        <option value="<?php echo $status['order_status_id'] ?>"><?php echo $status['name'] ?></option>
                        <?php endif ?>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                
                <!-- Input moip_assinatura_recurring_status_canceled -->
                <div class="form-group">
                  <label class="control-label col-sm-2"><span data-toggle="tooltip" title="<?php echo $help_canceled ?>"><?php echo $entry_canceled ?></span></label>
                  <div class="col-sm-10">
                    <select name="moip_assinatura_recurring_status_canceled" class="form-control">
                      <?php foreach($recurring_statuses as $status): ?>
                        <?php if ($moip_assinatura_recurring_status_canceled == $status['order_status_id']): ?>
                        <option value="<?php echo $status['order_status_id'] ?>" selected><?php echo $status['name'] ?></option>
                        <?php else: ?>
                        <option value="<?php echo $status['order_status_id'] ?>"><?php echo $status['name'] ?></option>
                        <?php endif ?>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                
                <!-- Input moip_assinatura_recurring_status_trial -->
                <div class="form-group">
                  <label class="control-label col-sm-2"><span data-toggle="tooltip" title="<?php echo $help_trial ?>"><?php echo $entry_trial ?></span></label>
                  <div class="col-sm-10">
                    <select name="moip_assinatura_recurring_status_trial" class="form-control">
                      <?php foreach($recurring_statuses as $status): ?>
                        <?php if ($moip_assinatura_recurring_status_trial == $status['order_status_id']): ?>
                        <option value="<?php echo $status['order_status_id'] ?>" selected><?php echo $status['name'] ?></option>
                        <?php else: ?>
                        <option value="<?php echo $status['order_status_id'] ?>"><?php echo $status['name'] ?></option>
                        <?php endif ?>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
              </fieldset>
              
              <br><br>
              
              <fieldset>
                <legend><?php echo $text_transaction_status ?></legend>
                
                <!-- Input moip_assinatura_active -->
                <div class="form-group">
                  <label class="control-label col-sm-2"><span data-toggle="tooltip" title="<?php echo $help_active ?>"><?php echo $entry_active ?></span></label>
                  <div class="col-sm-10">
                    <select name="moip_assinatura_active" class="form-control">
                      <?php foreach($transiction_statuses as $status): ?>
                        <?php if ($moip_assinatura_active == $status['order_status_id']): ?>
                        <option value="<?php echo $status['order_status_id'] ?>" selected><?php echo $status['name'] ?></option>
                        <?php else: ?>
                        <option value="<?php echo $status['order_status_id'] ?>"><?php echo $status['name'] ?></option>
                        <?php endif ?>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                
                <!-- Input moip_assinatura_suspended -->
                <div class="form-group">
                  <label class="control-label col-sm-2"><span data-toggle="tooltip" title="<?php echo $help_suspended ?>"><?php echo $entry_suspended ?></span></label>
                  <div class="col-sm-10">
                    <select name="moip_assinatura_suspended" class="form-control">
                      <?php foreach($transiction_statuses as $status): ?>
                        <?php if ($moip_assinatura_suspended == $status['order_status_id']): ?>
                        <option value="<?php echo $status['order_status_id'] ?>" selected><?php echo $status['name'] ?></option>
                        <?php else: ?>
                        <option value="<?php echo $status['order_status_id'] ?>"><?php echo $status['name'] ?></option>
                        <?php endif ?>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                
                <!-- Input moip_assinatura_expired -->
                <div class="form-group">
                  <label class="control-label col-sm-2"><span data-toggle="tooltip" title="<?php echo $help_expired ?>"><?php echo $entry_expired ?></span></label>
                  <div class="col-sm-10">
                    <select name="moip_assinatura_expired" class="form-control">
                      <?php foreach($transiction_statuses as $status): ?>
                        <?php if ($moip_assinatura_expired == $status['order_status_id']): ?>
                        <option value="<?php echo $status['order_status_id'] ?>" selected><?php echo $status['name'] ?></option>
                        <?php else: ?>
                        <option value="<?php echo $status['order_status_id'] ?>"><?php echo $status['name'] ?></option>
                        <?php endif ?>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                
                <!-- Input moip_assinatura_overdue -->
                <div class="form-group">
                  <label class="control-label col-sm-2"><span data-toggle="tooltip" title="<?php echo $help_overdue ?>"><?php echo $entry_overdue ?></span></label>
                  <div class="col-sm-10">
                    <select name="moip_assinatura_overdue" class="form-control">
                      <?php foreach($transiction_statuses as $status): ?>
                        <?php if ($moip_assinatura_overdue == $status['order_status_id']): ?>
                        <option value="<?php echo $status['order_status_id'] ?>" selected><?php echo $status['name'] ?></option>
                        <?php else: ?>
                        <option value="<?php echo $status['order_status_id'] ?>"><?php echo $status['name'] ?></option>
                        <?php endif ?>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                
                <!-- Input moip_assinatura_canceled -->
                <div class="form-group">
                  <label class="control-label col-sm-2"><span data-toggle="tooltip" title="<?php echo $help_canceled ?>"><?php echo $entry_canceled ?></span></label>
                  <div class="col-sm-10">
                    <select name="moip_assinatura_canceled" class="form-control">
                      <?php foreach($transiction_statuses as $status): ?>
                        <?php if ($moip_assinatura_canceled == $status['order_status_id']): ?>
                        <option value="<?php echo $status['order_status_id'] ?>" selected><?php echo $status['name'] ?></option>
                        <?php else: ?>
                        <option value="<?php echo $status['order_status_id'] ?>"><?php echo $status['name'] ?></option>
                        <?php endif ?>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                
                <!-- Input moip_assinatura_trial -->
                <div class="form-group">
                  <label class="control-label col-sm-2"><span data-toggle="tooltip" title="<?php echo $help_trial ?>"><?php echo $entry_trial ?></span></label>
                  <div class="col-sm-10">
                    <select name="moip_assinatura_trial" class="form-control">
                      <?php foreach($transiction_statuses as $status): ?>
                        <?php if ($moip_assinatura_trial == $status['order_status_id']): ?>
                        <option value="<?php echo $status['order_status_id'] ?>" selected><?php echo $status['name'] ?></option>
                        <?php else: ?>
                        <option value="<?php echo $status['order_status_id'] ?>"><?php echo $status['name'] ?></option>
                        <?php endif ?>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
              </fieldset>
            </div>
            
            <!-- Tab Retries -->
            <div class="tab-pane" id="tab-retries">
            
              <?php if ($error_update_retry) { ?>
              <div class="alert alert-warning">
                <?php foreach($error_update_retry as $error) { ?>
                <span><?php echo $error ?><br></span>
                <?php } ?>
              </div>
              <?php } ?>
              
              <div class="alert alert-info">
                1, 3, 5, 7 dia após a tentativa anterior suspend e cancel deixam de executar a retentativa e alteram o status da Assinatura.
                <button type="button" class="close" data-dismiss="alert">&times;</button>
              </div>
             
              <!-- Input moip_assinatura_first_try -->
              <div class="form-group">
                <label class="control-label col-sm-2"><span data-toggle="tooltip" title="<?php echo $help_first_try ?>"><?php echo $entry_first_try ?></span></label>
                <div class="col-sm-10">
                  <span class="input-group">
                    <select name="moip_assinatura_first_try" class="form-control">
                      <option value="1" <?php echo ($moip_assinatura_first_try == 1) ? 'selected' : '' ?>><?php echo $text_one_day ?></option>
                      <option value="3" <?php echo ($moip_assinatura_first_try == 3) ? 'selected' : '' ?>><?php echo $text_three_days?></option>
                      <option value="5" <?php echo ($moip_assinatura_first_try == 5) ? 'selected' : '' ?>><?php echo $text_five_days ?></option>
                      <option value="5" <?php echo ($moip_assinatura_first_try == 5) ? 'selected' : '' ?>><?php echo $text_seven_days ?></option>
                      <option value="cancel" <?php echo ($moip_assinatura_first_try == 'cancel') ? 'selected' : '' ?>><?php echo $text_cancel ?></option>
                      <option value="suspend" <?php echo ($moip_assinatura_first_try == 'suspend') ? 'selected' : '' ?>><?php echo $text_suspend ?></option>
                    </select>
                    <span class="input-group-addon"><?php echo $text_retries ?></span>
                  </span>
                </div>
              </div>
              
              <!-- Input moip_assinatura_second_try -->
              <div class="form-group">
                <label class="control-label col-sm-2"><span data-toggle="tooltip" title="<?php echo $help_second_try ?>"><?php echo $entry_second_try ?></span></label>
                <div class="col-sm-10">
                  <span class="input-group">
                    <select name="moip_assinatura_second_try" class="form-control">
                      <option value="1" <?php echo ($moip_assinatura_second_try == 1) ? 'selected' : '' ?>><?php echo $text_one_day ?></option>
                      <option value="3" <?php echo ($moip_assinatura_second_try == 3) ? 'selected' : '' ?>><?php echo $text_three_days?></option>
                      <option value="5" <?php echo ($moip_assinatura_second_try == 5) ? 'selected' : '' ?>><?php echo $text_five_days ?></option>
                      <option value="5" <?php echo ($moip_assinatura_second_try == 5) ? 'selected' : '' ?>><?php echo $text_seven_days ?></option>
                      <option value="cancel" <?php echo ($moip_assinatura_second_try == 'cancel') ? 'selected' : '' ?>><?php echo $text_cancel ?></option>
                      <option value="suspend" <?php echo ($moip_assinatura_second_try == 'suspend') ? 'selected' : '' ?>><?php echo $text_suspend ?></option>
                    </select>
                    <span class="input-group-addon"><?php echo $text_retries ?></span>
                  </span>
                </div>
              </div>
              
              <!-- Input moip_assinatura_third_try -->
              <div class="form-group">
                <label class="control-label col-sm-2"><span data-toggle="tooltip" title="<?php echo $help_third_try ?>"><?php echo $entry_third_try ?></span></label>
                <div class="col-sm-10">
                  <span class="input-group">
                    <select name="moip_assinatura_third_try" class="form-control">
                      <option value="1" <?php echo ($moip_assinatura_third_try == 1) ? 'selected' : '' ?>><?php echo $text_one_day ?></option>
                      <option value="3" <?php echo ($moip_assinatura_third_try == 3) ? 'selected' : '' ?>><?php echo $text_three_days?></option>
                      <option value="5" <?php echo ($moip_assinatura_third_try == 5) ? 'selected' : '' ?>><?php echo $text_five_days ?></option>
                      <option value="5" <?php echo ($moip_assinatura_third_try == 5) ? 'selected' : '' ?>><?php echo $text_seven_days ?></option>
                      <option value="cancel" <?php echo ($moip_assinatura_third_try == 'cancel') ? 'selected' : '' ?>><?php echo $text_cancel ?></option>
                      <option value="suspend" <?php echo ($moip_assinatura_third_try == 'suspend') ? 'selected' : '' ?>><?php echo $text_suspend ?></option>
                    </select>
                    <span class="input-group-addon"><?php echo $text_retries ?></span>
                  </span>
                </div>
              </div>
              
              <!-- Input moip_assinatura_last_try -->
              <div class="form-group">
                <label class="control-label col-sm-2"><span data-toggle="tooltip" title="<?php echo $help_last_try ?>"><?php echo $entry_last_try ?></span></label>
                <div class="col-sm-10">
                  <span class="input-group">
                    <select name="moip_assinatura_last_try" class="form-control">
                      <option value="cancel" <?php echo ($moip_assinatura_last_try == 'cancel') ? 'selected' : '' ?>><?php echo $text_cancel ?></option>
                      <option value="suspend" <?php echo ($moip_assinatura_last_try == 'suspend') ? 'selected' : '' ?>><?php echo $text_suspend ?></option>
                    </select>
                    <span class="input-group-addon"><?php echo $text_retries ?></span>
                  </span>
                </div>
              </div>
            </div>
            
            <!-- Tab Custom Field -->
            <div class="tab-pane" id="tab-custom-field">
              
              <!-- Input moip_assinatura_cpf -->
              <div class="form-group required">
                <label class="control-label col-sm-2"><span data-toggle="tooltip" title="<?php echo $help_cpf ?>"><?php echo $entry_cpf ?></span></label>
                <div class="col-sm-10">
                  <span class="input-group">
                    <select name="moip_assinatura_cpf" class="form-control">
                      <?php foreach($custom_fields as $custom_field): ?>
                        <?php if ($moip_assinatura_cpf == $custom_field['custom_field_id']): ?>
                        <option value="<?php echo $custom_field['custom_field_id'] ?>" selected><?php echo $custom_field['name'] ?></option>
                        <?php else: ?>
                        <option value="<?php echo $custom_field['custom_field_id'] ?>"><?php echo $custom_field['name'] ?></option>
                        <?php endif ?>
                      <?php endforeach ?>
                    </select>
                    
                    <span class="input-group-btn">
                      <a href="<?php echo $custom_field_add ?>" target="_blan" class="btn btn-primary btn-custom-field" data-toggle="tooltip" title="<?php echo $button_add ?>"><i class="fa fa-plus"></i></a>
                    </span>
                  </span>
                  <?php if ($error_cpf): ?>
                  <span class="text-danger"><?php echo $error_cpf ?></span>
                  <?php endif ?>
                </div>
              </div>
              
              <!-- Input moip_assinatura_birth_date -->
              <div class="form-group required">
                <label class="control-label col-sm-2"><span data-toggle="tooltip" title="<?php echo $help_birth_date ?>"><?php echo $entry_birth_date ?></span></label>
                <div class="col-sm-10">
                  <span class="input-group">
                    <select name="moip_assinatura_birth_date" class="form-control">
                      <?php foreach($custom_fields as $custom_field): ?>
                        <?php if ($moip_assinatura_birth_date == $custom_field['custom_field_id']): ?>
                        <option value="<?php echo $custom_field['custom_field_id'] ?>" selected><?php echo $custom_field['name'] ?></option>
                        <?php else: ?>
                        <option value="<?php echo $custom_field['custom_field_id'] ?>"><?php echo $custom_field['name'] ?></option>
                        <?php endif ?>
                      <?php endforeach ?>
                    </select>
                    
                    <span class="input-group-btn">
                      <a href="<?php echo $custom_field_add ?>" target="_blan" class="btn btn-primary btn-custom-field" data-toggle="tooltip" title="<?php echo $button_add ?>"><i class="fa fa-plus"></i></a>
                    </span>
                  </span>
                  <?php if ($error_birth_date): ?>
                  <span class="text-danger"><?php echo $error_birth_date ?></span>
                  <?php endif ?>
                </div>
              </div>
              
              <!-- Input moip_assinatura_address_number -->
              <div class="form-group required">
                <label class="control-label col-sm-2"><span data-toggle="tooltip" title="<?php echo $help_address_number ?>"><?php echo $entry_address_number ?></span></label>
                <div class="col-sm-10">
                  <span class="input-group">
                    <select name="moip_assinatura_address_number" class="form-control">
                      <?php foreach($custom_fields as $custom_field): ?>
                        <?php if ($moip_assinatura_address_number == $custom_field['custom_field_id']): ?>
                        <option value="<?php echo $custom_field['custom_field_id'] ?>" selected><?php echo $custom_field['name'] ?></option>
                        <?php else: ?>
                        <option value="<?php echo $custom_field['custom_field_id'] ?>"><?php echo $custom_field['name'] ?></option>
                        <?php endif ?>
                      <?php endforeach ?>
                    </select>
                    
                    <span class="input-group-btn">
                      <a href="<?php echo $custom_field_add ?>" target="_blan" class="btn btn-primary btn-custom-field" data-toggle="tooltip" title="<?php echo $button_add ?>"><i class="fa fa-plus"></i></a>
                    </span>
                  </span>
                  <?php if ($error_address_number): ?>
                  <span class="text-danger"><?php echo $error_address_number ?></span>
                  <?php endif ?>
                </div>
              </div>
            </div>
            
            <!-- Tab Payment Method -->
            <div class="tab-pane" id="tab-payment-method">
              
              <!-- Input moip_assinatura_credit_card_status -->
              <div class="form-group">
                <label class="control-label col-sm-2"><span data-toggle="tooltip" title="<?php echo $help_credit_card_status ?>"><?php echo $entry_credit_card_status ?></span></label>
                <div class="col-sm-10">
                  <!--<select name="moip_assinatura_credit_card_status" class="form-control">
                    <option value="1" <?php echo ($moip_assinatura_credit_card_status) ? 'selected' : '' ?>><?php echo $text_enabled ?></option>
                    <option value="0" <?php echo (!$moip_assinatura_credit_card_status) ? 'selected' : '' ?>><?php echo $text_disabled ?></option>
                  </select>-->
                  <input type="hidden" name="moip_assinatura_credit_card_status" value="1" />
                </div>
              </div>
              
              <!-- Input moip_assinatura_billet_status -->
              <div class="form-group">
                <label class="control-label col-sm-2"><span data-toggle="tooltip" title="<?php echo $help_billet_status ?>"><?php echo $entry_billet_status ?></span></label>
                <div class="col-sm-10">
                  <!--<select name="moip_assinatura_billet_status" class="form-control">
                    <option value="1" <?php echo ($moip_assinatura_billet_status) ? 'selected' : '' ?>><?php echo $text_enabled ?></option>
                    <option value="0" <?php echo (!$moip_assinatura_billet_status) ? 'selected' : '' ?>><?php echo $text_disabled ?></option>
                  </select>-->
                  <input type="hidden" name="moip_assinatura_billet_status" value="1" />
                </div>
              </div>
              
              <!-- Input moip_assinatura_payment_default -->
              <div class="form-group">
                <label class="control-label col-sm-2"><span data-toggle="tooltip" title="<?php echo $help_payment_default ?>"><?php echo $entry_payment_default ?></span></label>
                <div class="col-sm-10">
                  <!--<select name="moip_assinatura_payment_default" class="form-control">
                    <option value="1" <?php echo ($moip_assinatura_payment_default) ? 'selected' : '' ?>><?php echo $text_enabled ?></option>
                    <option value="0" <?php echo (!$moip_assinatura_payment_default) ? 'selected' : '' ?>><?php echo $text_disabled ?></option>
                  </select>-->
                  <input type="hidden" name="moip_assinatura_payment_default" value="ALL" />
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $('input[name="moip_assinatura_authorization"]').keyup(function(){
    $('#notify_url').val("<?php echo HTTPS_SERVER . 'index.php?route=payment/moip_assinatura/notify&authorization=' ?>" + this.value);
  });
  
  <?php if (isset($first_time)) { ?>
  if (window.confirm('<?php echo $text_export_plan ?>')) {
    importPlan();
  }
  <?php } ?>
  
  function exportPlan() {
    
    $.ajax({
      url: 'index.php?route=payment/moip_assinatura/export_plan&token=<?php echo $token ?>',
      dataType: 'json',
      beforeSend: function() {
        $('#alert-warning, #alert-success').slideUp().empty();
        $('#export-plan').button('loading');
      },
      success: function(json) {      
        if (json['error']) {
          $.map(json['error'], function(errors){
            $.map(errors, function(error){
              $('#alert-warning').append(error['description'] + '<br>');
            })
          })
          
          $('#alert-warning').slideDown();
        }
        
        if (json['success']) {
          $.map(json['success'], function(success){
            $('#alert-success').append(success + '<br>');
          })
          
          $('#alert-success').slideDown();
        }
      },
      complete: function() {
        $('#export-plan').button('reset');
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });
  
    return false;
  }
</script>
<?php echo $footer ?>