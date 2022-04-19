<?php

namespace App\Helpers;

use App\Models\GeneralSetup;
use DB;
use App\Helpers\Helper;
use App\Models\Navigation;
use SM;
use Collective\Html\FormFacade as Form;
class HtmlGenerate
{


    public static function formfiled($property, $errors = null, $selected = null){
      $formDisplyType =   helper::geSetupValue("input_display_type");
      if($formDisplyType == "Horizontal"){
        self::formfiledHorizental($property, $errors, $selected);
      }else if($formDisplyType == "Vertical"){
        self::formfiledVerticle($property, $errors, $selected);
      }else{
        self::formfiledHorizental($property, $errors, $selected);
      }
    }

    public static function formfiledForModal($property, $errors = null, $selected = null)
    {


        if (isset($property->type)) {
            $type = $property->type;
            switch ($type) {
                case "text":
                    self::text($property, $errors, $selected);
                    break;
                case "optionGroup":
                    self::optionGroup($property, $errors, $selected);
                    break;
                case "toptionGroup":
                    self::toptionGroup($property, $errors, $selected);
                    break;
                case "tpoptionGroup":
                    self::tpoptionGroup($property, $errors, $selected);
                    break;
                case "tsoptionGroup":
                    self::tsoptionGroup($property, $errors, $selected);
                    break;
                case "ttext":
                    self::ttext($property, $errors, $selected);
                    break;
                case "tnumber":
                    self::tnumber($property, $errors, $selected);
                    break;
                case "tselect":
                    self::tselect($property, $errors, $selected);
                    break;
                case "smultiple":
                    self::smultiple($property, $errors, $selected);
                    break;
                case "email":
                    self::email($property, $errors, $selected);
                    break;
                case "textarea":
                    self::textarea($property, $errors, $selected);
                    break;
                case "number":
                    self::text($property, $errors, $selected);
                    break;
                case "date":
                    self::date($property, $errors, $selected);
                    break;
                case "rdateRange":
                    self::rdateRange($property, $errors, $selected);
                    break;
                case "roptionGroup":
                    self::roptionGroup($property, $errors, $selected);
                    break;       
                case "rdate":
                    self::rdate($property, $errors, $selected);
                    break;
                case "cheque_date":
                    self::cheque_date($property, $errors, $selected);
                    break;
                case "rselect":
                    self::rselect($property, $errors, $selected);
                    break;
                case "rtext":
                    self::rtext($property, $errors, $selected);
                    break;
                case "rfile":
                    self::rfile($property, $errors, $selected);
                    break;
                case "checkbox":
                    self::checkbox($property, $errors, $selected);
                    break;
                case "select":
                    self::select($property, $errors, $selected);
                    break;
                case "file":
                    self::file($property, $errors, $selected);
                    break;
                case "password":
                    self::password($property, $errors, $selected);
                    break;
                case "multipleFiles":
                    self::multipleFiles($property, $errors, $selected);
                    break;
            }
        }
    }



    public static function formfiledVerticle($property, $errors = null, $selected = null)
    {

        if (isset($property->type)) {
            $type = $property->type;
            switch ($type) {
                case "text":
                    self::text($property, $errors, $selected);
                    break;
                case "optionGroup":
                    self::optionGroup($property, $errors, $selected);
                    break;
                case "toptionGroup":
                    self::toptionGroup($property, $errors, $selected);
                    break;
                case "tpoptionGroup":
                    self::tpoptionGroup($property, $errors, $selected);
                    break;
                case "tsoptionGroup":
                    self::tsoptionGroup($property, $errors, $selected);
                    break;
                case "ttext":
                    self::ttext($property, $errors, $selected);
                    break;
                case "tnumber":
                    self::tnumber($property, $errors, $selected);
                    break;
                case "tselect":
                    self::tselect($property, $errors, $selected);
                    break;
                case "smultiple":
                    self::smultiple($property, $errors, $selected);
                    break;
                case "email":
                    self::email($property, $errors, $selected);
                    break;
                case "textarea":
                    self::textarea($property, $errors, $selected);
                    break;
                case "number":
                    self::text($property, $errors, $selected);
                    break;
                case "date":
                    self::date($property, $errors, $selected);
                    break;
                case "rdateRange":
                    self::rdateRange($property, $errors, $selected);
                    break;
                case "roptionGroup":
                    self::roptionGroup($property, $errors, $selected);
                    break;       
                case "rdate":
                    self::rdate($property, $errors, $selected);
                    break;
                case "cheque_date":
                    self::cheque_date($property, $errors, $selected);
                    break;
                case "rselect":
                    self::rselect($property, $errors, $selected);
                    break;
                case "rtext":
                    self::rtext($property, $errors, $selected);
                    break;
                case "checkbox":
                    self::checkbox($property, $errors, $selected);
                    break;
                case "select":
                    self::select($property, $errors, $selected);
                    break;
                case "file":
                    self::file($property, $errors, $selected);
                    break;
                case "password":
                    self::password($property, $errors, $selected);
                    break;
            }
        }
    }



    public static function formfiledHorizental($property, $errors = null, $selected = null)
    {


      



        if (isset($property->type)) {
            $type = $property->type;
            switch ($type) {
                case "text":
                    self::horizentalText($property, $errors, $selected);
                    break;
                case "optionGroup":
                    self::horizentalOptionGroup($property, $errors, $selected);
                    break;
                case "toptionGroup":
                    self::toptionGroup($property, $errors, $selected);
                    break;
                case "tpoptionGroup":
                    self::tpoptionGroup($property, $errors, $selected);
                    break;
                case "tsoptionGroup":
                    self::tsoptionGroup($property, $errors, $selected);
                    break;
                case "ttext":
                    self::ttext($property, $errors, $selected);
                    break;
                case "tnumber":
                    self::tnumber($property, $errors, $selected);
                    break;
                case "tselect":
                    self::tselect($property, $errors, $selected);
                    break;
                case "smultiple":
                    self::horizentalSmultiple($property, $errors, $selected);
                    break;
                case "email":
                    self::horizentalText($property, $errors, $selected);
                    break;
                case "textarea":
                    self::horizentalTextarea($property, $errors, $selected);
                    break;
                case "number":
                    self::horizentalText($property, $errors, $selected);
                    break;
                case "date":
                    self::horizentalDate($property, $errors, $selected);
                    break;
                case "checkbox":
                    self::horizentalCheckbox($property, $errors, $selected);
                    break;
                case "rdateRange":
                    self::rdateRange($property, $errors, $selected);
                    break;
                case "roptionGroup":
                    self::roptionGroup($property, $errors, $selected);
                    break;       
                case "rdate":
                    self::rdate($property, $errors, $selected);
                    break;
                case "cheque_date":
                    self::cheque_date($property, $errors, $selected);
                    break;
                case "rselect":
                    self::rselect($property, $errors, $selected);
                    break;
                case "rtext":
                    self::rtext($property, $errors, $selected);
                    break;
                case "select":
                    self::horizentalSelect($property, $errors, $selected);
                    break;
                case "file":
                    self::horizentalFile($property, $errors, $selected);
                    break;
                case "password":
                    self::horizentalPassword($property, $errors, $selected);
                    break;
                case "multipleFiles":
                    self::multipleFiles($property, $errors, $selected);
                    break;
            }

          
        }
    }


    public static function multipleFiles($fieldInfo, $errors = null, $selected = null){

        $label = $fieldInfo->label ?? 'Upload Image';
        $name = trim($fieldInfo->name ?? '');
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? '';
        $type = $fieldInfo->type ?? '';
        $hideDiv = $fieldInfo->hideDiv ?? '';
        $value = $fieldInfo->value ?? $inoviceId ?? '';
        $required = $fieldInfo->required ?? '';
        $readonly = $fieldInfo->readonly ?? '';
        if (!empty($value)) :
            $value =  $value;
        else :
            if (!empty($selected) && is_array($selected)) {
                $value =  $selected[$name] ?? '';
            }
            if (!empty($selected) && is_object($selected)) {
                $value =  $selected->$name ?? '';
            }
        endif;
    ?> 

    <div class="form-group row col-md-12 mb-12 ">
        <label for="validationCustom01"  class="col-sm-1 col-form-label"><?php echo ucfirst($label); ?> <?php if ($required) : echo '*';  endif; ?>:</label>
        <div class="col-sm-11">
           <div id="actions" class="row product-upload-images">
                <div class="col-md-12">
                    <div class="btn-group w-100">
                    <span class="btn btn-success col fileinput-button">
                        <i class="fas fa-plus"></i>
                        <span>Add files</span>
                    </span>
                    <button type="button" class="btn btn-primary col start">
                        <i class="fas fa-upload"></i>
                        <span>Start upload</span>
                    </button>
                    <button type="reset" class="btn btn-warning col cancel">
                        <i class="fas fa-times-circle"></i>
                        <span>Cancel upload</span>
                    </button>
                    </div>
                </div>
                <div class="col-md-12 d-flex align-items-center">
                    <div class="fileupload-process w-100">
                    <div id="total-progress" class="progress active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                        <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="table table-striped files  row col-md-12 mb-6" id="previews">
                <div id="template" class="row mt-2 col-md-12">
                    <div class="attached_files"></div>
                        <div class="product-images">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="col-auto">
                                        <span class="preview"><img src="data:," alt="" data-dz-thumbnail /></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col d-flex align-items-center">
                                        <p class="mb-0">
                                        <span class="lead" data-dz-name></span>
                                        (<span data-dz-size></span>)
                                        </p>
                                        <strong class="error text-danger" data-dz-errormessage></strong>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="align-items-center">
                                        <div class="progress progress-striped active w-100" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                        <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="align-items-right">
                                        <div class="btn-group file-action-btn">
                                            <button type="button" class="btn btn-primary start">
                                            <i class="fas fa-upload"></i>
                                            <span>Start</span>
                                            </button>
                                            <button type="button" data-dz-remove class="btn btn-warning cancel">
                                            <i class="fas fa-times-circle"></i>
                                            <span>Cancel</span>
                                            </button>
                                            <button type="button" data-dz-remove class="btn btn-danger delete">
                                            <i class="fas fa-trash"></i>
                                            <span>Delete</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
<?php
 }

 public static function horizentalText($fieldInfo, $errors = null, $selected = null)
    {

        if (!empty($fieldInfo->voucherInfo) && $fieldInfo->voucherInfo != '' && $selected == null) :
            $voucherInfo = explode("-", $fieldInfo->voucherInfo);
            $columnName = $voucherInfo[0];
            $tables = $voucherInfo[1];
            $inoviceId = Helper::generateInvoiceId($columnName, $tables);
        endif;
        $label = $fieldInfo->label ?? 'Label';
        $name = trim($fieldInfo->name ?? '');
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? '';
        $type = $fieldInfo->type ?? '';
        $hideDiv = $fieldInfo->hideDiv ?? '';
        $value = $fieldInfo->value ?? $inoviceId ?? '';
        $required = $fieldInfo->required ?? '';
        $readonly = $fieldInfo->readonly ?? '';
        if (!empty($value)) :
            $value =  $value;
        else :
            if (!empty($selected) && is_array($selected)) {
                $value =  $selected[$name] ?? '';
            }
            if (!empty($selected) && is_object($selected)) {
                $value =  $selected->$name ?? '';
            }
        endif;
     ?>


        <div class="form-group row col-md-6 mb-3 <?php echo $hideDiv; ?>  div_<?php echo $name; ?>">
                <label for="inputEmail3" class="col-sm-3 col-form-label"><?php echo ucfirst($label); ?> <?php if ($required) : echo '*';  endif; ?>:</label>
                <div class="col-sm-6">
                    <input type="<?php echo $type; ?>" name="<?php echo $name; ?>" <?php echo $readonly ?> class="<?php echo $class; ?>" id="<?php echo $id; ?>" placeholder="<?php echo $placeholder; ?>" value="<?php echo $value; ?>">
                    <?php if ($errors->has($name)) : ?>
                            <span class=" error text-red text-bold"><?php echo $errors->first($name) ?></span>
                    <?php endif; ?>                        
                </div>
               
        </div>
        <?php

    }



    public static function horizentalFile($fieldInfo, $errors = null, $selected = null)
    {
        if (!empty($fieldInfo->voucherInfo) && $fieldInfo->voucherInfo != '') :
            $voucherInfo = explode("-", $fieldInfo->voucherInfo);
            $columnName = $voucherInfo[0];
            $tables = $voucherInfo[1];
            $inoviceId = Helper::generateInvoiceId($columnName, $tables);
        endif;
        $label = $fieldInfo->label ?? 'Label';
        $name = trim($fieldInfo->name ?? '');
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? '';
        $type = $fieldInfo->type ?? '';
        $value = $fieldInfo->value ?? $inoviceId ?? '';
        $required = $fieldInfo->required ?? '';
        $readonly = $fieldInfo->readonly ?? '';
        if (!empty($value)) :
            $value =  $value;
        else :
            if (!empty($selected) && is_array($selected)) {
                $value =  $selected[$name] ?? '';
            }
            if (!empty($selected) && is_object($selected)) {
                $value =  $selected->$name ?? '';
            }
        endif;

    ?>
        <div class="form-group row col-md-6 mb-3 ">
            <label for="validationCustom01"  class="col-sm-3 col-form-label"><?php echo ucfirst($label); ?> <?php if ($required) : echo '*';  endif; ?>:</label>
            <div class="col-sm-6"> 
                <input type="<?php echo $type; ?>" name="<?php echo $name; ?>" <?php echo $readonly ?> class="<?php echo $class; ?>" id="<?php echo $id; ?>" value="<?php echo $value; ?>">
                <?php if ($errors->has($name)) : ?>
                <span class=" error text-red text-bold"><?php echo $errors->first($name) ?></span>
                <?php endif; ?>
            </div>
           
        </div>
   <?php

    }
    public static function horizentalPassword($fieldInfo, $errors = null, $selected = null)
    {
       
        $label = $fieldInfo->label ?? 'Label';
        $name = trim($fieldInfo->name ?? '');
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? '';
        $type = $fieldInfo->type ?? '';
        $value = $fieldInfo->value ?? '';
        $required = $fieldInfo->required ?? '';
        $readonly = $fieldInfo->readonly ?? '';
        if (!empty($value)) :
            $value =  $value;
        else :
            if (!empty($selected) && is_array($selected)) {
                $value =  $selected[$name] ?? '';
            }
            if (!empty($selected) && is_object($selected)) {
                $value =  $selected->$name ?? '';
            }
        endif;

    ?>
        <div class="form-group row col-md-6 mb-3 ">
            <label for="validationCustom01"  class="col-sm-3 col-form-label"><?php echo ucfirst($label); ?> <?php if ($required) : echo '*';  endif; ?>:</label>
            <div class="col-sm-6"> 
                <input type="<?php echo $type; ?>" name="<?php echo $name; ?>" <?php echo $readonly ?> class="<?php echo $class; ?>" id="<?php echo $id; ?>" value="<?php echo $value; ?>">
                <?php if ($errors->has($name)) : ?>
                <span class=" error text-red text-bold"><?php echo $errors->first($name) ?></span>
                <?php endif; ?>
            </div>
           
        </div>
   <?php

    }



    public static function horizentalSmultiple($fieldInfo, $errors = null, $select = null)
    {

        $label = $fieldInfo->label ?? 'Label';
        $name = trim($fieldInfo->name ?? '');
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? '';
        $type = $fieldInfo->type ?? '';
        $value = $fieldInfo->value ?? '';
         $hideDiv = $fieldInfo->hideDiv ?? '';
        $required = $fieldInfo->required ?? '';
        $foreignTable = $fieldInfo->foreignTable ?? '';
        $customMethod = $fieldInfo->customMethod ?? '';
        if (!empty($foreignTable) && empty($customMethod)) :
            $datas = DB::table($foreignTable)->where('status', 'Active')->get();
        else :
            $functionInfo = explode("(",str_replace(")","",$customMethod));
            $fname = $functionInfo[0];
            $fparameter = $functionInfo[1];
            $datas = Helper::$fname($fparameter, $select);       
        endif;
        if (!empty($value)) :
          
            $selected =  $value;
        else :
            if(!empty($select->$name)):
                $selected = explode(",",$select->$name);
            endif;
        endif;
      ?>
        <div class="form-group row col-md-6 mb-3 <?php echo $hideDiv; ?>  div_<?php echo $name; ?>">
            <label for="validationCustom01"  class="col-sm-3 col-form-label"><?php echo ucfirst($label); ?> <?php if ($required) : echo '*'; endif; ?> :</label>
            <div class="col-sm-6"> 
            <select data-placeholder="<?php echo $placeholder; ?>" multiple="multiple" width="100%"  name="<?php echo $name; ?>[]" class="<?php echo $class; ?>" id="<?php echo $id; ?>"  placeholder="<?php echo $placeholder; ?>">
                <?php if (!empty($datas)) :
                    foreach ($datas as $key => $data) : ?>
                    <option <?php if (!empty($selected) && in_array($data->name,$selected)) : ?> selected <?php endif; ?>  value="<?php echo $data->id ?? ''; ?>"><?php echo $data->name ?? ''; ?></option>
               <?php endforeach; 
             endif; ?>
            </select>
            <?php if ($errors->has($name)) : ?>
            <span class=" error text-red text-bold"><?php echo $errors->first($name) ?></span>
            <?php endif; ?>
            </div>
        </div>
        <?php
    }


    public static function horizentalSelect($fieldInfo, $errors = null, $select = null)
    {

        $label = $fieldInfo->label ?? 'Label';
        $name = trim($fieldInfo->name ?? '');
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? '';
        $type = $fieldInfo->type ?? '';
        $value = $fieldInfo->value ?? 'Approved';
        $hideDiv = $fieldInfo->hideDiv ?? '';
        $required = $fieldInfo->required ?? '';
        $foreignTable = $fieldInfo->foreignTable ?? '';
        $customMethod = $fieldInfo->customMethod ?? '';
        $jqueryMethod = $fieldInfo->jqueryMethod ?? '';
        $jqueryRoute = $fieldInfo->jqueryRoute ?? '';


        
        $checkNullExits =  Navigation::where('table',$foreignTable)->whereNull('active')->first();
        if(empty($checkNullExits)):

            if (!empty($foreignTable) && empty($customMethod)) :

                if($foreignTable !='company_categories'):
                    $datas = DB::table($foreignTable)->where('company_id',helper::companyId())->where('status', 'Approved')->whereNull('deleted_at')->get();
                else: 
                    $datas = DB::table($foreignTable)->where('id',helper::companyId())->where('status', 'Approved')->whereNull('deleted_at')->get();
                endif;
                if($name == 'status'): 
                    foreach($datas as $key => $value1): 
                        $value1->id = $value1->name;
                    endforeach;
                endif;
            else :

                $functionInfo = explode("(",str_replace(")","",$customMethod));
                $fname = $functionInfo[0];
                $fparameter = $functionInfo[1];
                $datas = Helper::$fname($fparameter, $select);       
            endif;
            if (!empty($value) && empty($select[$name])) :
                $selected =  $value;
        else :

                if (!empty($select) && is_array($select)) {
                    $selected =  $select[$name] ?? '';
                }
                if (!empty($select) && is_object($select)) {
                    $selected =  $select->$name ?? '';
                }
        endif;

 ?>

<div class="form-group row col-md-6 mb-3 <?php echo $hideDiv; ?>  div_<?php echo $name; ?>">
    <label for="validationCustom01"  class="col-sm-3 col-form-label"><?php echo ucfirst($label); ?> <?php if ($required) : echo '*'; endif; ?>:</label>
    <div class="col-sm-6">
    <select width="100%" name="<?php echo $name; ?>" class="<?php echo $class; ?>" id="<?php echo $name;?>"  placeholder="<?php echo $placeholder; ?>">
        <option value="" selected disabled>(:-Select <?php echo ucfirst($name); ?>-:)</option>
        <?php
                if (!empty($datas)) :
                    foreach ($datas as $key => $data) : ?>
        <option <?php if (!empty($data->is_posted) && $data->is_posted == 1) : ?> disabled <?php endif;?> <?php if (!empty($selected) && $selected == $data->id) : ?> selected <?php endif; ?>  value="<?php echo $data->id ?? ''; ?>"><?php echo $data->name ?? ''; ?></option>
        <?php endforeach;
                endif;
                ?>
    </select>

    <?php if ($errors->has($name)) : ?>
    <span class=" error text-red text-bold"><?php echo $errors->first($name) ?></span>
    <?php endif; ?> 
    </div>
    <?php if(!empty($jqueryMethod)):?>
    <div class="col-sm-1">
        <div class="btn btn-sm btn-success" onclick="<?php  echo $jqueryMethod;?>('<?php echo route($jqueryRoute)?>','<?php echo $name;?>','Add New <?php echo ucfirst($label); ?>')" data-toggle="modal" data-target="#modal-default" ><i class="fa fa-plus"></i>
        </div>
    </div>
    <?php endif;?>
</div>

<?php
endif;
    }

    

    public static function horizentalOptionGroup($fieldInfo, $errors = null, $select = null)
    {
        $label = $fieldInfo->label ?? 'Label';
        $name = trim($fieldInfo->name ?? '');
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? '';
        $type = $fieldInfo->type ?? '';
        $value = $fieldInfo->value ?? '';
        $hideDiv = $fieldInfo->hideDiv ?? '';
        $required = $fieldInfo->required ?? '';
        $foreignTable = $fieldInfo->foreignTable ?? '';
        $datas = helper::getLedgerHead();

        if (!empty($value)) :
            $selected =  $value;
        else :
            if (!empty($select) && is_array($select)) {
                $selected =  $select[$name] ?? '';
            }
            if (!empty($select) && is_object($select)) {
                $selected =  $select->$name ?? '';
            }
        endif;
      ?>

        <div class="form-group row col-md-6 mb-3 <?php echo $hideDiv; ?> div_<?php echo $name; ?>">
            <label for="validationCustom01" class="col-sm-3 col-form-label"><?php echo ucfirst($label); ?> <?php if ($required) : echo '*'; endif; ?>:</label>
            <div class="col-sm-6">  
            <select name="<?php echo $name; ?>[]" class="<?php echo $class; ?>" id="<?php echo $id; ?>"  placeholder="<?php echo $placeholder; ?>">
                <?php foreach ($datas as $key => $parent) :  ?>
                <optgroup label="<?php echo $parent['parent']->name ?? '' ?>">
                    <?php foreach ($parent['parentChild'] as $child => $accountHeads) : ?>
                    <option <?php if (!empty($selected) && $selected == $accountHeads->id) : ?> selected <?php endif; ?>
                        value="<?php echo $accountHeads->id ?? ''; ?>"><?php echo $accountHeads->name ?? ''; ?></option>
                    <?php endforeach; ?>
                </optgroup>
                <?php endforeach; ?>
            </select>

            <?php if ($errors->has($name)) : ?>
            <span class=" error text-red text-bold"><?php echo $errors->first($name) ?></span>
            <?php endif; ?>
            </div>
        </div>

     <?php

    }



    public static function horizentalDate($fieldInfo, $errors = null, $selected = null)
    {
        $label = $fieldInfo->label ?? 'Label';
        $name = trim($fieldInfo->name ?? '');
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? '';
        $type = $fieldInfo->type ?? '';
        $hideDiv = $fieldInfo->hideDiv ?? '';
        $value = $fieldInfo->value ?? date('m/d/Y');
        $required = $fieldInfo->required ?? '';
        if (!empty($value)) :
            $value =  $value;
        else :
            if (!empty($selected) && is_array($selected)) {
                $value =  $selected[$name] ?? '';
            }
            if (!empty($selected) && is_object($selected)) {
                $value =  $selected->$name ?? '';
            }
        endif;

    ?>
        <div class="form-group row col-md-6 mb-3 <?php echo $hideDiv; ?>  div_<?php echo $name; ?>">
            <label for="validationCustom01" class="col-sm-3 col-form-label"><?php echo ucfirst($label); ?> <?php if ($required) : echo '*';  endif; ?>:</label>
            
            <div class="col-sm-6">  
                <div class="input-group"data-target-input="nearest">
                    <input class="form-control basicDate" type="text"  value="<?php echo helper::get_php_date(); ?>" name="<?php echo $name; ?>" data-input>
                    <div class="input-group-append"  data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            <?php if ($errors->has($name)) : ?>
            <span class=" error text-red text-bold"><?php echo $errors->first($name) ?></span>
            <?php endif; ?>
            </div>
        </div>
<?php
    }


    public static function roptionGroup($fieldInfo, $errors = null, $select = null)
    {
        $label = $fieldInfo->label ?? 'Label';
        $name = trim($fieldInfo->name ?? '');
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? '';
        $type = $fieldInfo->type ?? '';
        $value = $fieldInfo->value ?? '';
        $hideDiv = $fieldInfo->hideDiv ?? '';
        $required = $fieldInfo->required ?? '';
        $foreignTable = $fieldInfo->foreignTable ?? '';
        $datas = helper::getLedgerHead();
        if (!empty($value)) :
            $selected =  $value;
        else :
            if (!empty($select) && is_array($select)) {
                $selected =  $select[$name] ?? '';
            }
            if (!empty($select) && is_object($select)) {
                $selected =  $select->$name ?? '';
            }
        endif;
      ?>
        <div class="col-md-3 col-sm-6 col-xs-12 <?php echo $hideDiv; ?>  div_<?php echo $name; ?>">
           <div class="form-group">
                <label for="validationCustom01"><?php echo ucfirst($label); ?><?php if ($required) : echo '*'; endif; ?>:</label>
                <select name="<?php echo $name; ?>" class="<?php echo $class; ?>" id="<?php echo $id; ?>"  placeholder="<?php echo $placeholder; ?>">
                    <?php foreach ($datas as $key => $parent) :  ?>
                    <optgroup label="<?php echo $parent['parent']->name ?? '' ?>">
                        <?php foreach ($parent['parentChild'] as $child => $accountHeads) : ?>
                        <option <?php if (!empty($selected) && $selected == $accountHeads->id) : ?> selected <?php endif; ?>
                            value="<?php echo $accountHeads->id ?? ''; ?>"><?php echo $accountHeads->name ?? ''; ?></option>
                        <?php endforeach; ?>
                    </optgroup>
                    <?php endforeach; ?>
                </select>
                <?php if ($errors->has($name)) : ?>
                <span class=" error text-red text-bold"><?php echo $errors->first($name) ?></span>
                <?php endif; ?>
            </div>
        </div>

     <?php

    }

    public static function rselect($fieldInfo, $errors = null, $select = null)
    {


     
        $label = $fieldInfo->label ?? 'Label';
        $name = trim($fieldInfo->name ?? '');
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? '';
        $type = $fieldInfo->type ?? '';
        $allOption = $fieldInfo->allOption ?? false;
        $value = $fieldInfo->value ?? '';
        $hideDiv = $fieldInfo->hideDiv ?? '';
        $required = $fieldInfo->required ?? '';
        $foreignTable = $fieldInfo->foreignTable ?? '';
        $customMethod = $fieldInfo->customMethod ?? '';
            if (!empty($foreignTable) && empty($customMethod)) :
                $datas = DB::table($foreignTable)->where('status', 'Approved')->get();
                if($name == 'status'): 
                    foreach($datas as $key => $value): 
                        $value->id = $value->name;
                    endforeach;
                endif;


            else :
                $functionInfo = explode("(",str_replace(")","",$customMethod));
                $fname = $functionInfo[0];
                $fparameter = $functionInfo[1];
                $datas = Helper::$fname($fparameter, $select); 
                
            endif;

            if (!empty($value)) :
                $selected =  $value;
            else :
                if (!empty($select) && is_array($select)) {
                    $selected =  $select[$name] ?? '';
                }
                if (!empty($select) && is_object($select)) {
                    $selected =  $select->$name ?? '';
                }
            endif;
         ?>
            <div class="col-md-3 col-sm-6 col-xs-12 <?php echo $hideDiv; ?>  div_<?php echo $name; ?>">
                <div class="form-group">    
                <label for="validationCustom01"><?php echo ucfirst($label); ?> <?php if ($required) : echo '*'; endif; ?>:</label>
                    <select width="100%" name="<?php echo $name; ?>"   class="<?php echo $class; ?>" id="<?php echo $id; ?><?php echo $name;?>"
                        placeholder="<?php echo $placeholder; ?>">
                       
                        <?php if($allOption):?>
                        <option <?php if (!empty($selected) && $selected == "All") : ?> selected <?php endif; ?> value="All" > All</option>
                        <?php endif;?>
                        <?php
                                if (!empty($datas)) :
                                    foreach ($datas as $key => $data) : ?>
                        <option  <?php if (!empty($selected) && $selected == $data->id) : ?> selected <?php endif; ?> value="<?php echo $data->id ?? ''; ?>">
                            
                            <?php echo $data->name ?? ''; ?> 
                            <?php if(!empty($data->code)): ?>
                               [<?php echo $data->code ?? ''; ?>]
                            <?php endif;?>
                        </option>
                        <?php endforeach;
                                endif;
                                ?>
                    </select>

                    <?php if (is_object($errors) && $errors->has($name)) : ?>
                    <span class=" error text-red text-bold"><?php echo $errors->first($name) ?></span>
                    <?php else: ?>
                    <?php if(is_array($errors)): ?>
                        <span class=" error text-red text-bold"><?php echo $errors[$name][0] ?? ''; ?></span>
                        <?php endif;?>
                    <?php endif;?>
                
                </div>
            </div>
<?php

    }
    public static function rtext($fieldInfo, $errors = null, $selected = null)
    {

        if (!empty($fieldInfo->voucherInfo) && $fieldInfo->voucherInfo != '' && $selected == null) :
            $voucherInfo = explode("-", $fieldInfo->voucherInfo);
            $columnName = $voucherInfo[0];
            $tables = $voucherInfo[1];
            $inoviceId = Helper::generateInvoiceId($columnName, $tables);
        endif;
        $label = $fieldInfo->label ?? 'Label';
        $name = trim($fieldInfo->name ?? '');
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? '';
        $type = $fieldInfo->type ?? '';
        $hideDiv = $fieldInfo->hideDiv ?? '';
        $value = $fieldInfo->value ?? $inoviceId ?? '';
        $required = $fieldInfo->required ?? '';
        $readonly = $fieldInfo->readonly ?? '';
        if (!empty($value)) :
            $value =  $value;
        else :
            if (!empty($selected) && is_array($selected)) {
                $value =  $selected[$name] ?? '';
            }
            if (!empty($selected) && is_object($selected)) {
                $value =  $selected->$name ?? '';
            }
        endif;
     ?>


        <div class="col-md-3 col-sm-6 col-xs-12 <?php echo $hideDiv; ?>  div_<?php echo $name; ?>">
        <div class="form-group">
                <label for="inputEmail3"><?php echo ucfirst($label); ?> <?php if ($required) : echo '*';  endif; ?>:</label>
                    <input type="text" name="<?php echo $name; ?>" <?php echo $readonly ?> class="<?php echo $class; ?>" id="<?php echo $id; ?>" placeholder="<?php echo $placeholder; ?>" value="<?php echo $value; ?>">
                    <?php if ($errors->has($name)) : ?>
                            <span class=" error text-red text-bold"><?php echo $errors->first($name) ?></span>
                    <?php endif; ?>                        
               
               
        </div>
        </div>
        <?php

    }


    public static function rfile($fieldInfo, $errors = null, $selected = null)
    {

        if (!empty($fieldInfo->voucherInfo) && $fieldInfo->voucherInfo != '' && $selected == null) :
            $voucherInfo = explode("-", $fieldInfo->voucherInfo);
            $columnName = $voucherInfo[0];
            $tables = $voucherInfo[1];
            $inoviceId = Helper::generateInvoiceId($columnName, $tables);
        endif;
        $label = $fieldInfo->label ?? 'Label';
        $name = trim($fieldInfo->name ?? '');
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? '';
        $type = $fieldInfo->type ?? '';
        $hideDiv = $fieldInfo->hideDiv ?? '';
        $value = $fieldInfo->value ?? $inoviceId ?? '';
        $required = $fieldInfo->required ?? '';
        $readonly = $fieldInfo->readonly ?? '';
        if (!empty($value)) :
            $value =  $value;
        else :
            if (!empty($selected) && is_array($selected)) {
                $value =  $selected[$name] ?? '';
            }
            if (!empty($selected) && is_object($selected)) {
                $value =  $selected->$name ?? '';
            }
        endif;
     ?>


        <div class="col-md-3 col-sm-6 col-xs-12 <?php echo $hideDiv; ?>  div_<?php echo $name; ?>">
        <div class="form-group">
                <label for="inputEmail3"><?php echo ucfirst($label); ?> <?php if ($required) : echo '*';  endif; ?>:</label>
                
                    <input type="file" name="<?php echo $name; ?>" <?php echo $readonly ?> class="<?php echo $class; ?>" id="<?php echo $id; ?>" placeholder="<?php echo $placeholder; ?>" value="<?php echo $value; ?>">
                    <?php if ($errors->has($name)) : ?>
                            <span class=" error text-red text-bold"><?php echo $errors->first($name) ?></span>
                    <?php endif; ?>                        
               
               
        </div>
        </div>
        <?php

    }



    public static function rdate($fieldInfo, $errors = null, $selected = null)
    {
        $label = $fieldInfo->label ?? 'Label';
        $name = trim($fieldInfo->name ?? '');
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? '';
        $type = $fieldInfo->type ?? '';
        $hideDiv = $fieldInfo->hideDiv ?? '';
        $value = $fieldInfo->value ?? date('m/d/Y');
        $required = $fieldInfo->required ?? '';
        if (!empty($value)) :
            $value =  $value;
        else :
            if (!empty($selected) && is_array($selected)) {
                $value =  $selected[$name] ?? '';
            }
            if (!empty($selected) && is_object($selected)) {
                $value =  $selected->$name ?? '';
            }
        endif;
    ?>
     <div class="col-md-3 col-sm-6 col-xs-12 <?php echo $hideDiv; ?>  div_<?php echo $name; ?>">
        <div class="form-group">
                  <label><?php echo ucfirst($label); ?> :</label>
                  <div class="input-group date reservationdate"  data-target-input="nearest">
                <input type="text" value="<?php echo helper::get_php_date(); ?>" readonly="readonly" name="<?php echo $name; ?>" id="<?php echo $id; ?>" class="<?php echo $class; ?> datetimepicker-input"  data-target="#reservationdate" />
                <div class="input-group-append" data-target=".reservationdate" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
            <?php if ($errors->has($name)) : ?>
            <span class=" error text-red text-bold"><?php echo $errors->first($name) ?></span>
            <?php endif; ?>
            </div>      
        </div>      
<?php
    }

    public static function cheque_date($fieldInfo, $errors = null, $selected = null)
    {
        $label = $fieldInfo->label ?? 'Label';
        $name = trim($fieldInfo->name ?? '');
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? '';
        $type = $fieldInfo->type ?? '';
        $hideDiv = $fieldInfo->hideDiv ?? '';
        $value = $fieldInfo->value ?? date('m/d/Y');
        $required = $fieldInfo->required ?? '';
        if (!empty($value)) :
            $value =  $value;
        else :
            if (!empty($selected) && is_array($selected)) {
                $value =  $selected[$name] ?? '';
            }
            if (!empty($selected) && is_object($selected)) {
                $value =  $selected->$name ?? '';
            }
        endif;
      ?>
      <div class="col-md-3 col-sm-6 col-xs-12 <?php echo $hideDiv; ?>  div_<?php echo $name; ?>">
        <div class="form-group">
                  <label><?php echo ucfirst($label); ?> :</label>
                  <div class="input-group date" id="reservationdate"  data-target-input="nearest">
                <input type="text" value="<?php echo helper::get_php_date(); ?>" readonly="readonly" name="<?php echo $name; ?>" id="<?php echo $id; ?>" class="<?php echo $class; ?> datetimepicker-input"  data-target="#reservationdate" />
                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
            <?php if ($errors->has($name)) : ?>
            <span class=" error text-red text-bold"><?php echo $errors->first($name) ?></span>
            <?php endif; ?>
            </div>      
        </div>      
      <?php
    }
    


    public static function rdateRange($fieldInfo, $errors = null, $selected = null)
    {
        $label = $fieldInfo->label ?? 'Label';
        $name = trim($fieldInfo->name ?? '');
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? '';
        $type = $fieldInfo->type ?? '';
        $hideDiv = $fieldInfo->hideDiv ?? '';
        $value = $fieldInfo->value ?? '';
        $required = $fieldInfo->required ?? '';
        if (!empty($value)) :
            $value =  $value;
        else :
            if (!empty($selected) && is_array($selected)) {
                $value =  $selected[$name] ?? '';
            }
            if (!empty($selected) && is_object($selected)) {
                $value =  $selected->$name ?? '';
            }
        endif;


    ?>
        <div class="col-md-3 col-sm-6 col-xs-12  <?php echo $hideDiv; ?> div_<?php echo $name; ?>">
                <div class="form-group">
                  <label><?php echo ucfirst($label); ?>:</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                    <input type="text" name="<?php echo $name; ?>"  value="<?php echo $value;?>" class="<?php echo $class; ?> float-right" id="reservation">
                  </div>
                  <?php if ($errors->has($name)) : ?>
                    <span class=" error text-red text-bold"><?php echo $errors->first($name) ?></span>
                  <?php endif; ?>
                  <!-- /.input group -->
                </div>
            </div>        
        <?php
        }

    public static function horizentalTextarea($fieldInfo, $errors = null, $selected = null)
    {
        $label = $fieldInfo->label ?? 'Label';
        $name = trim($fieldInfo->name ?? '');
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? '';
        $type = $fieldInfo->type ?? '';
        $rows = $fieldInfo->rows ?? '';
        $cols = $fieldInfo->cols ?? '';
        $value = $fieldInfo->value ?? '';
        $required = $fieldInfo->required ?? '';

        if (!empty($value)) :
            $value =  $value;
        else :
            if (!empty($selected) && is_array($selected)) {
                $value =  $selected[$name] ?? '';
            }
            if (!empty($selected) && is_object($selected)) {
                $value =  $selected->$name ?? '';
            }
        endif;

    ?>
        <div class="form-group row col-md-6 mb-3 ">
        <label for="validationCustom01"  class="col-sm-3 col-form-label"><?php echo ucfirst($label); ?> <?php if ($required) : echo '*'; endif; ?>:</label>
        <div class="col-sm-6">    
        <textarea name="<?php echo $name; ?>" class="<?php echo $class; ?>  summernote" id="<?php echo $id; ?>"  placeholder="<?php echo ucfirst($placeholder); ?>"   cols="<?php echo $cols; ?>"><?php echo $value; ?></textarea>
            <?php if ($errors->has($name)) : ?>
            <span class=" error text-red text-bold"><?php echo $errors->first($name) ?></span>
            <?php endif; ?>
        </div>
        </div>
        <?php

    }

    public static function horizentalCheckbox($fieldInfo, $errors = null, $selected = null)
    {
        $label = $fieldInfo->label ?? 'Label';
        $name = trim($fieldInfo->name ?? '');
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? '';
        $type = $fieldInfo->type ?? '';
        $hideDiv = $fieldInfo->hideDiv ?? '';
        $value = $fieldInfo->value ?? '';
        $required = $fieldInfo->required ?? '';
        if (!empty($value)) :
            $value =  $value;
        else :
            if (!empty($selected) && is_array($selected)) {
                $value =  $selected[$name] ?? '';
            }
            if (!empty($selected) && is_object($selected)) {
                $value =  $selected->$name ?? '';
            }
        endif;

    ?>

<div class="form-group row col-md-6 mb-3  <?php echo $hideDiv; ?> div_<?php echo $name; ?>">
    <label for="validationCustom01"  class="col-sm-3 col-form-label"><?php echo ucfirst($label); ?> <?php if ($required) : echo '*'; endif; ?>:</label>
    <div class="col-sm-6">    
    <div class="form-group clearfix">
        <div class="icheck-primary d-inline">
            <input type="checkbox" id="checkboxPrimary<?php echo $name;?>" name="<?php echo $name;?>"  <?php if($value == 1):?> checked <?php endif;?>>
            <label for="checkboxPrimary<?php echo $name;?>"> </label>
        </div>
        <?php echo $placeholder;?>
    </div> 
    </div>
    <?php if ($errors->has($name)) : ?>
    <span class=" error text-red text-bold"><?php echo $errors->first($name) ?></span>
    <?php endif; ?>
</div>



<?php
    }


    public static function select($fieldInfo, $errors = null, $select = null)
    {
        $label = $fieldInfo->label ?? 'Label';

        $name = trim($fieldInfo->name ?? '');
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? '';
        $type = $fieldInfo->type ?? '';
        $value = $fieldInfo->value ?? 'Approved';
        $hideDiv = $fieldInfo->hideDiv ?? '';
        $required = $fieldInfo->required ?? '';
        $foreignTable = $fieldInfo->foreignTable ?? '';
        $customMethod = $fieldInfo->customMethod ?? '';
        $jqueryMethod = $fieldInfo->jqueryMethod ?? '';
        $jqueryRoute = $fieldInfo->jqueryRoute ?? '';



       $checkNullExits =  Navigation::where('table',$foreignTable)->whereNull('active')->first();
      
        if(empty($checkNullExits)):
            if (!empty($foreignTable) && empty($customMethod)) :
                $datas = DB::table($foreignTable)->where('status', 'Approved')->get();
                if($name == 'status'): 
                    foreach($datas as $key => $value1): 
                        $value1->id = $value1->name;
                    endforeach;
                endif;


            else :
                $functionInfo = explode("(",str_replace(")","",$customMethod));
                $fname = $functionInfo[0];
                $fparameter = $functionInfo[1];
                $datas = Helper::$fname($fparameter, $select); 
            endif;

            if (!empty($value)) :
                $selected =  $value;
            else :
                if (!empty($select) && is_array($select)) {
                    $selected =  $select[$name] ?? '';
                }
                if (!empty($select) && is_object($select)) {
                    $selected =  $select->$name ?? '';
                }
            endif;



    ?>

<div class="col-md-6 mb-3 <?php echo $hideDiv; ?>  div_<?php echo $name; ?>">
    <div class="add-new-category">
        <label for="validationCustom01"><?php echo ucfirst($label); ?> <?php if ($required) : echo '*';  endif; ?>:</label>
        <?php if(!empty($jqueryMethod)):?>
            
                <button class="btn btn-sm btn-success" onclick="<?php  echo $jqueryMethod;?>('<?php echo route($jqueryRoute)?>','<?php echo $name;?>','Add New <?php echo ucfirst($label); ?>')" data-toggle="modal" data-target="#modal-default" ><i class="fa fa-plus"></i>
                </button>
            
        <?php endif;?>
    </div>
    <select width="100%" name="<?php echo $name; ?>"  onchange="<?php  echo $jqueryMethod;?>(<?php echo $jqueryRoute?>)"  class="<?php echo $class; ?>" id="<?php echo $id; ?><?php echo $name;?>"
        placeholder="<?php echo $placeholder; ?>">
        <option value="" selected disabled>(:-Select <?php echo ucfirst($name); ?>-:)</option>
        <?php
                if (!empty($datas)) :
                    foreach ($datas as $key => $data) : ?>
        <option  <?php if (!empty($data->is_posted) && $data->is_posted == 1) : ?> disabled <?php endif;?> <?php if (!empty($selected) && $selected == $data->id) : ?> selected <?php endif; ?>
            value="<?php echo $data->id ?? ''; ?>"><?php echo $data->name ?? ''; ?></option>
        <?php endforeach;
                endif;
                ?>
    </select>

    <?php if (is_object($errors) && $errors->has($name)) : ?>
    <span class=" error text-red text-bold"><?php echo $errors->first($name) ?></span>
    <?php else: ?>
    <?php if(is_array($errors)): ?>
        <span class=" error text-red text-bold"><?php echo $errors[$name][0] ?? ''; ?></span>
        <?php endif;?>
    <?php endif;?>
    
</div>
<?php
endif;
    }

    public static function text($fieldInfo, $errors = null, $selected = null)
    {
        if (!empty($fieldInfo->voucherInfo) && $fieldInfo->voucherInfo != '' && $selected == null) :
            $voucherInfo = explode("-", $fieldInfo->voucherInfo);
            $columnName = $voucherInfo[0];
            $tables = $voucherInfo[1];
            $inoviceId = Helper::generateInvoiceId($columnName, $tables);
        endif;
        $label = $fieldInfo->label ?? 'Label';
        $name = trim($fieldInfo->name ?? '');
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? '';
        $type = $fieldInfo->type ?? '';
        $hideDiv = $fieldInfo->hideDiv ?? '';
        $value = $fieldInfo->value ?? $inoviceId ?? '';
        $required = $fieldInfo->required ?? '';
        $readonly = $fieldInfo->readonly ?? '';
        if (!empty($value)) :
            $value =  $value;
        else :
            if (!empty($selected) && is_array($selected)) {
                $value =  $selected[$name] ?? '';
            }
            if (!empty($selected) && is_object($selected)) {
                $value =  $selected->$name ?? '';
            }
        endif;

?>
<div class="col-md-6 mb-3 <?php echo $hideDiv; ?>  div_<?php echo $name; ?>">
    <label for="validationCustom01"><?php echo ucfirst($label); ?> <?php if ($required) : echo '*';   endif; ?>:</label>
    <input type="<?php echo $type; ?>" name="<?php echo $name; ?>" <?php echo $readonly ?> class="<?php echo $class; ?>"  id="<?php echo $id; ?>" placeholder="<?php echo $placeholder; ?>" value="<?php echo $value; ?>">
    <?php if (is_object($errors) && $errors->has($name)) : ?>
    <span class=" error text-red text-bold"><?php echo $errors->first($name) ?></span>
    <?php else: ?>
    <?php if(is_array($errors)): ?>
        <span class=" error text-red text-bold"><?php echo $errors[$name][0] ?? ''; ?></span>
        <?php endif;?>
    <?php endif;?>
</div>
<?php

    }

    public static function file($fieldInfo, $errors = null, $selected = null)
    {
        if (!empty($fieldInfo->voucherInfo) && $fieldInfo->voucherInfo != '') :
            $voucherInfo = explode("-", $fieldInfo->voucherInfo);
            $columnName = $voucherInfo[0];
            $tables = $voucherInfo[1];
            $inoviceId = Helper::generateInvoiceId($columnName, $tables);
        endif;
        $label = $fieldInfo->label ?? 'Label';
        $name = trim($fieldInfo->name ?? '');
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? '';
        $type = $fieldInfo->type ?? '';
        $value = $fieldInfo->value ?? $inoviceId ?? '';
        $required = $fieldInfo->required ?? '';
        $readonly = $fieldInfo->readonly ?? '';
        if (!empty($value)) :
            $value =  $value;
        else :
            if (!empty($selected) && is_array($selected)) {
                $value =  $selected[$name] ?? '';
            }
            if (!empty($selected) && is_object($selected)) {
                $value =  $selected->$name ?? '';
            }
        endif;

    ?>
<div class="col-md-6 mb-3">
    <label for="validationCustom01"><?php echo ucfirst($label); ?> <?php if ($required) : echo '*';
                                                                            endif; ?>:</label>
    <input type="<?php echo $type; ?>" name="<?php echo $name; ?>" <?php echo $readonly ?> class="<?php echo $class; ?>"
        id="<?php echo $id; ?>" value="<?php echo $value; ?>">
        <?php if (is_object($errors) && $errors->has($name)) : ?>
    <span class=" error text-red text-bold"><?php echo $errors->first($name) ?></span>
    <?php else: ?>
    <?php if(is_array($errors)): ?>
        <span class=" error text-red text-bold"><?php echo $errors[$name][0] ?? ''; ?></span>
        <?php endif;?>
    <?php endif;?>
</div>
<?php

    }


    public static function ttext($fieldInfo, $errors = null, $selected = null)
    {
        $label = $fieldInfo->label ?? 'Label';
        $name = trim($fieldInfo->name ?? '');
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? '';
        $type = $fieldInfo->type ?? '';
        $value = $fieldInfo->value ?? '';
        $required = $fieldInfo->required ?? '';
        $readonly = $fieldInfo->readonly ?? '';
        if (!empty($value)) :
            $value =  $value;
        else :
            if (!empty($selected) && is_array($selected)) {
                $value = ''; // $selected[$name] ?? '';
            }
            if (!empty($selected) && is_object($selected)) {
                $value = ''; //  $selected->$name ?? '';
            }
        endif;


        if($name == "quantity"):
        echo '<input type="hidden" class="current_stock," name="current[]"/><input type="text"  name="' . $name . '[]" ' . $readonly . ' class="' . $class . '" id="' . $id . '" placeholder="' . $placeholder . '" value="' . $value . '">';
    else: 
        echo '<input type="text"  name="' . $name . '[]" ' . $readonly . ' class="' . $class . '" id="' . $id . '" placeholder="' . $placeholder . '" value="' . $value . '">';
    endif;
    }

    public static function smUpload($fieldInfo, $filedId, $fieldLabel) {

      
        $label = $fieldInfo->label ?? 'Label';
        $name = "sm_theme_options[section1][home_setting][slider_images][slider_image]";
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? 'id';
        $type = $fieldInfo->type ?? '';
        $hideDiv = $fieldInfo->hideDiv ?? '';
        $value = $fieldInfo->value ?? $inoviceId ?? '';
        $required = $fieldInfo->required ?? '';
        $readonly = $fieldInfo->readonly ?? '';
        $array = array(
            "required" => "",
  "class" => "sm_theme_popup_field sm_theme_popup_slider_image form-control",
  "data-selector" => "sm_theme_options_section1__home_setting__slider_images__slider_image_",
  "data-info" => "slider_image",
  "data-name" => "sm_theme_options[section1][home_setting][slider_images][slider_image]",
  "data-type" => "upload",
  "id" => "sm_theme_options_section1__home_setting__slider_images__slider_image_"
        );


               
                ?>













                <div class="row">
                    <div class="col-md-2">
                    <?php echo $label;?>
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="" id="<?php echo $id; ?>_input">
                                    <?php echo Form::hidden( $name, $placeholder, $array ); ?>
                                    <input input_holder="<?php echo $name; ?>"
                                           img_holder="<?php echo $name; ?>_ph"
                                           is_multiple="0"
                                           media_width="112" img_width="100" type="button"
                                           class="btn btn-primary btn-block sm_media_modal_show"
                                           value="Upload">
                                </div>
                               
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <div class="smthemesingleimagediv" id="<?php echo $name; ?>_ph">  
                                     <img data-default="<?= $label; ?>" class="media_img"  src=""  width="112px"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <?php
            }

    public static function tnumber($fieldInfo, $errors = null, $selected = null)
    {

        $label = $fieldInfo->label ?? 'Label';
        $name = trim($fieldInfo->name ?? '');
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? '';
        $type = $fieldInfo->type ?? '';
        $value = $fieldInfo->value ?? '';
        $required = $fieldInfo->required ?? '';
        $readonly = $fieldInfo->readonly ?? '';
        if (!empty($value)) :
            $value =  $value;
        else :
            if (!empty($selected) && is_array($selected)) {
                $value = ''; //  $selected[$name] ?? '';
            }
            if (!empty($selected) && is_object($selected)) {
                $value = ''; //  $selected->$name ?? '';
            }
        endif;

        echo '<input type="number" required  name="' . $name . '[]" ' . $readonly . ' class="' . $class . '" id="' . $id . '" placeholder="' . $placeholder . '" value="' . $value . '">';
    }



    public static function date($fieldInfo, $errors = null, $selected = null)
    {
        $label = $fieldInfo->label ?? 'Label';
        $name = trim($fieldInfo->name ?? '');
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? '';
        $type = $fieldInfo->type ?? '';
        $value = $fieldInfo->value ?? date('m-d-Y');
        $required = $fieldInfo->required ?? '';
        if (!empty($value)) :
            $value =  $value;
        else :
            if (!empty($selected) && is_array($selected)) {
                $value =  $selected[$name] ?? '';
            }
            if (!empty($selected) && is_object($selected)) {
                $value =  $selected->$name ?? '';
            }
        endif;

    ?>
<div class="col-md-6 mb-3">
    <label for="validationCustom01"><?php echo ucfirst($label); ?> <?php if ($required) : echo '*';  endif; ?>:</label>
    <div class="input-group date" id="reservationdate" data-target-input="nearest">
    <input class="form-control basicDate" type="text" id="" value="<?php echo helper::get_php_date(); ?>" name="<?php echo $name; ?>" data-input>
        <!-- <input type="text" value="<?php echo date('Y-m-d', strtotime($value)) ?>"  name="<?php echo $name; ?>" id="<?php echo $id; ?>" class="<?php echo $class; ?> datetimepicker-input"  data-target="#reservationdate" /> -->
        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
        </div>
    </div>
    <?php if ($errors->has($name)) : ?>
    <span class=" error text-red text-bold"><?php echo $errors->first($name) ?></span>
    <?php endif; ?>
</div>
<?php
    }

   
    public static function checkbox($fieldInfo, $errors = null, $selected = null)
    {
        $label = $fieldInfo->label ?? 'Label';
        $name = trim($fieldInfo->name ?? '');
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? '';
        $type = $fieldInfo->type ?? '';
        $value = $fieldInfo->value ?? '';
        $required = $fieldInfo->required ?? '';

        if (!empty($value)) :
            $value =  $value;
        else :
            if (!empty($selected) && is_array($selected)) {
                $value =  $selected[$name] ?? '';
            }
            if (!empty($selected) && is_object($selected)) {
                $value =  $selected->$name ?? '';
            }
        endif;

    ?>

<div class="col-md-6 mb-3">
    <label for="validationCustom01"><?php echo ucfirst($label); ?> <?php if ($required) : echo '<span class="bg-danger">*</span>'; endif; ?> :</label>
    <div class="form-group clearfix">
        <div class="icheck-primary d-inline">
            <input type="checkbox" id="checkboxPrimary<?php echo $name;?>" name="<?php echo $name;?>" <?php if($value == 1):?> checked <?php endif;?>>
            <label for="checkboxPrimary<?php echo $name;?>"> </label>
        </div>
    </div>
    <?php if ($errors->has($name)) : ?>
    <span class=" error text-red text-bold"><?php echo $errors->first($name) ?></span>
    <?php endif; ?>
</div>


<?php
    }
   
   
    public static function email($fieldInfo, $errors = null, $selected = null)
    {
        $label = $fieldInfo->label ?? 'Label';
        $name = trim($fieldInfo->name ?? '');
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? '';
        $type = $fieldInfo->type ?? '';
        $value = $fieldInfo->value ?? '';
        $required = $fieldInfo->required ?? '';

        if (!empty($value)) :
            $value =  $value;
        else :
            if (!empty($selected) && is_array($selected)) :
                $value =  $selected[$name] ?? '';
            endif;
            if (!empty($selected) && is_object($selected)) :
                $value =  $selected->$name ?? '';
            endif;
        endif;

    ?>
<div class="col-md-6 mb-3">
    <label for="validationCustom01"><?php echo ucfirst($label); ?> <?php if ($required) : echo '*';
                                                                            endif; ?>:</label>
    <input type="<?php echo $type; ?>" name="<?php echo $name; ?>" class="<?php echo $class; ?>" id="<?php echo $id; ?>"
        placeholder="<?php echo ucfirst($placeholder); ?>" value="<?php echo $value; ?>">
        <?php if (is_object($errors) && $errors->has($name)) : ?>
    <span class=" error text-red text-bold"><?php echo $errors->first($name) ?></span>
    <?php else: ?>
    <?php if(is_array($errors)): ?>
        <span class=" error text-red text-bold"><?php echo $errors[$name][0] ?? ''; ?></span>
        <?php endif;?>
    <?php endif;?>
</div>
<?php

    }


    public static function password($fieldInfo, $errors = null, $selected = null)
    {
        $label = $fieldInfo->label ?? 'Label';
        $name = trim($fieldInfo->name ?? '');
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? '';
        $type = $fieldInfo->type ?? '';
        $value = $fieldInfo->value ?? '';
        $required = $fieldInfo->required ?? '';

        if (!empty($value)) :
            $value =  $value;
        else :
            if (!empty($selected) && is_array($selected)) :
                $value =  $selected[$name] ?? '';
            endif;
            if (!empty($selected) && is_object($selected)) :
                $value =  $selected->$name ?? '';
            endif;
        endif;

    ?>
<div class="col-md-6 mb-3">
    <label for="validationCustom01"><?php echo ucfirst($label); ?> <?php if ($required) : echo '*'; endif; ?>:</label>
    <input type="<?php echo $type; ?>" name="<?php echo $name; ?>" class="<?php echo $class; ?>" id="<?php echo $id; ?>" placeholder="<?php echo ucfirst($placeholder); ?>" value="<?php echo $value; ?>">
        <?php if (is_object($errors) && $errors->has($name)) : ?>
    <span class=" error text-red text-bold"><?php echo $errors->first($name) ?></span>
    <?php else: ?>
    <?php if(is_array($errors)): ?>
        <span class=" error text-red text-bold"><?php echo $errors[$name][0] ?? ''; ?></span>
        <?php endif;?>
    <?php endif;?>
</div>
<?php

    }

    public static function textarea($fieldInfo, $errors = null, $selected = null)
    {
        $label = $fieldInfo->label ?? 'Label';
        $name = trim($fieldInfo->name ?? '');
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? '';
        $type = $fieldInfo->type ?? '';
        $rows = $fieldInfo->rows ?? '';
        $cols = $fieldInfo->cols ?? '';
        $value = $fieldInfo->value ?? '';
        $required = $fieldInfo->required ?? '';

        if (!empty($value)) :
            $value =  $value;
        else :
            if (!empty($selected) && is_array($selected)) {
                $value =  $selected[$name] ?? '';
            }
            if (!empty($selected) && is_object($selected)) {
                $value =  $selected->$name ?? '';
            }
        endif;

    ?>
<div class="col-md-6 mb-3">
    <label for="validationCustom01"><?php echo ucfirst($label); ?> <?php if ($required) : echo '*';
                                                                            endif; ?>:</label>
    <textarea name="<?php echo $name; ?>" class="<?php echo $class; ?> summernote" id="<?php echo $id; ?>"
        placeholder="<?php echo ucfirst($placeholder); ?>" cols="<?php echo $cols; ?>"
        rows="<?php echo $rows; ?>"><?php echo $value; ?></textarea>
        <?php if (is_object($errors) && $errors->has($name)) : ?>
    <span class=" error text-red text-bold"><?php echo $errors->first($name) ?></span>
    <?php else: ?>
    <?php if(is_array($errors)): ?>
        <span class=" error text-red text-bold"><?php echo $errors[$name][0] ?? ''; ?></span>
        <?php endif;?>
    <?php endif;?>
</div>
<?php

    }


    public static function smultiple($fieldInfo, $errors = null, $select = null)
    {


        $label = $fieldInfo->label ?? 'Label';
        $name = trim($fieldInfo->name ?? '');
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? '';
        $type = $fieldInfo->type ?? '';
        $value = $fieldInfo->value ?? '';
         $hideDiv = $fieldInfo->hideDiv ?? '';
        $required = $fieldInfo->required ?? '';
        $foreignTable = $fieldInfo->foreignTable ?? '';
        $customMethod = $fieldInfo->customMethod ?? '';
        if (!empty($foreignTable) && empty($customMethod)) :
            $datas = DB::table($foreignTable)->where('status', 'Active')->get();
        else :
            $functionInfo = explode("(",str_replace(")","",$customMethod));
            $fname = $functionInfo[0];
            $fparameter = $functionInfo[1];
            $datas = Helper::$fname($fparameter, $select);       
        endif;
        if (!empty($value)) :
            $selected =  $value;
        else :
            if (!empty($select) && is_array($select)) {
                $selected =  $select[$name] ?? '';
            }
            if (!empty($select) && is_object($select)) {
                $selected =  $select->$name ?? '';
            }
        endif;
    ?>

<div class="col-md-6 mb-3 <?php echo $hideDiv; ?>  div_<?php echo $name; ?>">
    <label for="validationCustom01"><?php echo ucfirst($label); ?> <?php if ($required) : echo '*';  endif; ?> :</label>
    <select data-placeholder="<?php echo $placeholder; ?>" multiple="multiple" width="100%"  name="<?php echo $name; ?>[]" class="<?php echo $class; ?>" id="<?php echo $id; ?>"  placeholder="<?php echo $placeholder; ?>">
        <!-- <option value="" selected disabled>(:-Select <?php //echo ucfirst($name);    ?>-:)</option> -->
        <?php
                if (!empty($datas)) :
                    foreach ($datas as $key => $data) : ?>
        <option <?php if (!empty($selected) && $selected == $data->id) : ?> selected <?php endif; ?>
            value="<?php echo $data->id ?? ''; ?>"><?php echo $data->name ?? ''; ?></option>
        <?php endforeach;
                endif;
                ?>
    </select>
    <?php if ($errors->has($name)) : ?>
    <span class=" error text-red text-bold"><?php echo $errors->first($name) ?></span>
    <?php endif; ?>
</div>

<?php

    }

public static function tselect($fieldInfo, $errors = null, $select = null)
    {

       
        $label = $fieldInfo->label ?? 'Label';
        $name = trim($fieldInfo->name ?? '');
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? '';
        $type = $fieldInfo->type ?? '';
        $value = $fieldInfo->value ?? '';
        $required = $fieldInfo->required ?? '';
        $customMethod = $fieldInfo->customMethod ?? '';
        $foreignTable = $fieldInfo->foreignTable ?? '';
        if (!empty($foreignTable) && empty($customMethod)) :
            $datas = DB::table($foreignTable)->where('company_id',helper::companyId())->where('status', 'Approved')->get();
        else :
            $functionInfo = explode("(",str_replace(")","",$customMethod));
            $fname = $functionInfo[0];
            $fparameter = $functionInfo[1];
            $datas = Helper::$fname($fparameter, $select); 
            if($name == "batch_no"): 
                foreach($datas as $key => $eachBatch): 
                    if(!empty($eachBatch->batch)):
                        $eachBatch->id= $eachBatch->batch->id;
                        $eachBatch->name= $eachBatch->batch->name;
                    endif;
                endforeach;
           
            endif;
        endif;

        if (!empty($value)) :
            $selected =  $value;
        else :

            if (!empty($select) && is_array($select)) {
                $selected =  $select[$name] ?? '';
            } else {
                $selected = '';
            }
            if (!empty($select) && is_object($select)) {
                $selected =  $select->$name ?? '';
            } else {
                $selected = '';
            }
        endif;



        echo '<select name="' . $name . '[]" class="' . $class . '" id="' . $id . '" placeholder="' . $placeholder . '">';
        if($name == "batch_no"): 
        echo '<option value="" selected >(:-Select ' . ucfirst($label) . '-:)</option>';
        else: 
            echo '<option value="" selected disabled>(:-Select ' . ucfirst($label) . '-:)</option>';
        endif;
        if (!empty($datas)) :
            foreach ($datas as $key => $data) :
                echo '<option ' . $selected . ' value=" ' . $data->id . '">' . $data->name . '</option>';
            endforeach;
        endif;
        echo '</select>';
    }


    public static function optionGroup($fieldInfo, $errors = null, $select = null)
    {




        $label = $fieldInfo->label ?? 'Label';
        $name = trim($fieldInfo->name ?? '');
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? '';
        $type = $fieldInfo->type ?? '';
        $value = $fieldInfo->value ?? '';
        $hideDiv = $fieldInfo->hideDiv ?? '';
        $required = $fieldInfo->required ?? '';
        $foreignTable = $fieldInfo->foreignTable ?? '';
        $datas = helper::getLedgerHead();

        if (!empty($value)) :
            $selected =  $value;
        else :
            if (!empty($select) && is_array($select)) {
                $selected =  $select[$name] ?? '';
            }
            if (!empty($select) && is_object($select)) {
                $selected =  $select->$name ?? '';
            }
        endif;


      //  dd($datas);



    ?>

<div class="form-group row col-md-6 mb-3 <?php echo $hideDiv; ?> div_<?php echo $name; ?>">
    <label for="validationCustom01"  class="col-sm-3 col-form-label"><?php echo ucfirst($label); ?> <?php if ($required) : echo '*';  endif; ?>:</label>
    <div class="col-sm-6">  
    <select name="<?php echo $name; ?>[]" class="<?php echo $class; ?>" id="<?php echo $id; ?>"  placeholder="<?php echo $placeholder; ?>">
        <?php foreach ($datas as $key => $parent) :  ?>
        <optgroup label="<?php echo $parent['parent']->name ?? '' ?>">
            <?php foreach ($parent['parentChild'] as $child => $accountHeads) : ?>
            <option <?php if (!empty($selected) && $selected == $accountHeads->id) : ?> selected <?php endif; ?>
                value="<?php echo $accountHeads->id ?? ''; ?>"><?php echo $accountHeads->name ?? ''; ?></option>
            <?php endforeach; ?>
        </optgroup>
        <?php endforeach; ?>
    </select>
    <?php if ($errors->has($name)) : ?>
    <span class=" error text-red text-bold"><?php echo $errors->first($name) ?></span>
    <?php endif; ?>
    </div>
</div>

<?php

    }


    public static function toptionGroup($fieldInfo, $errors = null, $select = null)
    {
        $label = $fieldInfo->label ?? 'Label';
        $name = trim($fieldInfo->name ?? '');
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? '';

        $datas = helper::getLedgerHead();


        echo '<select name="'.$name.'[]" class="'.$class.'" id="'.$id.'"  placeholder="'.$placeholder.'">';
         foreach ($datas as $key => $parent) : 
            $pname = $parent['parent']->name ?? '';
            echo '<optgroup label="'.$pname .'">';
           $childNames =  $parent['parentChild'];
                foreach ($childNames as $child => $accountHeads) : 
                    echo '<option  value="'. $accountHeads->id . '">'. $accountHeads->name .'</option>';
                endforeach; 
            echo '</optgroup>';
         endforeach; 
    echo '</select>';
    }


    public static function tpoptionGroup($fieldInfo, $errors = null, $select = null)
    {
        $label = $fieldInfo->label ?? 'Label';
        $name = trim($fieldInfo->name ?? '');
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? '';
        $customMethod = $fieldInfo->customMethod ?? '';

        if (empty($customMethod)) :
            $datas = helper::getProductListCategoryWise();

            echo '<select name="'.$name.'[]" class="'.$class.'" id="'.$id.'"  placeholder="'.$placeholder.'">';
            $selected = 0;
            echo '<option selected value="0">(:-Select Product-:)</option>';
             foreach ($datas as $key => $parent) : 
                $pname =$parent->name;
                if(count($parent->products)):
       
                echo '<optgroup label="'.$pname .'">';
               $childNames =  $parent->products;
                    foreach ($childNames as $child => $eachProduct) : 
                        echo '<option  value="'. $eachProduct->id . '">'. $eachProduct->name .'</option>';
                    endforeach; 
                echo '</optgroup>';
                endif;
             endforeach; 
        echo '</select>';
        else :
            $functionInfo = explode("(",str_replace(")","",$customMethod));
            $fname = $functionInfo[0];
            $fparameter = $functionInfo[1];
            $datas = Helper::$fname($fparameter, $select); 

            echo '<select name="'.$name.'[]" class="'.$class.'" id="'.$id.'"  placeholder="'.$placeholder.'">';
            $selected = 0;
            echo '<option selected value="0">(:-Select Product-:)</option>';
             foreach ($datas as $key => $eachData) : 
                $pid = $eachData->product_id ?? $eachData->id;
                $pname = $eachData->product->name ?? $eachData->name;
                echo '<option  value="'. $pid. '">'. $pname .'</option>';
             endforeach; 
        echo '</select>';

        endif;
   
    }

    public static function tsoptionGroup($fieldInfo, $errors = null, $select = null)
    {
        $label = $fieldInfo->label ?? 'Label';
        $name = trim($fieldInfo->name ?? '');
        $placeholder = $fieldInfo->placeholder ?? '';
        $class = $fieldInfo->class ?? '';
        $id = $fieldInfo->id ?? '';
        $datas = helper::getServiceListCategoryWise();
        echo '<select name="'.$name.'[]" class="'.$class.'" id="'.$id.'"  placeholder="'.$placeholder.'">';
         foreach ($datas as $key => $parent) : 
            $sname =$parent->name;
            if(count($parent->sevices)):
            echo '<optgroup label="'.$sname .'">';
           $childNames =  $parent->sevices;
                foreach ($childNames as $child => $eachService) : 
                    echo '<option  value="'. $eachService->id . '">'. $eachService->name .'</option>';
                endforeach; 
            echo '</optgroup>';
            endif;
         endforeach; 
    echo '</select>';
    }
}

?>