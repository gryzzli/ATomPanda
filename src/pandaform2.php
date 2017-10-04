<?php

class PandaForm2
{

        var $name;
        var $values;
        var $inputs = array();
        var $hidden = null;
        var $beforeForm = "";
        
        
	function __construct($name='form')
	{
		static $name2;

		if($name2 == '') { $name2 = $name;}
		else { $name2++; $name = $name2; }
		$this->name = $name;
		$this->data = $_POST[$this->name];
                
                
                if(is_array($_POST[$this->name]))
                {
                    $this->values = $_POST[$this->name];
                }

	}

	function begin()
	{
                
                
                
               
                
            
		$ret = '<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">'."\n";

                 if(is_array($this->hidden))
                 {
                     foreach($this->hidden as $val)
                     {
                         $ret.= "\n".$val->print_feld();
                     }
                     
                 }
                
                
		return $ret;
	}

	function end()
	{
            return "</form>\n".$this->beforeForm."\n";
	}
        
        function issubmit()
        {
            if(is_array($_POST[$this->name]))
            {
                return 1;
            }
            return 0;
        }
        
        function isValid()
        {
            foreach($this->inputs as $key => $val)
	    {
		if(!$val->isValid()) {  return 0; }
            }
            
            return 1;
        }
        
        function getValues()
        {
            $values = $this->values;
            unset($values['submit']);
            return $values;
        }
        
        
        function input($name,$type="input")
        {
            if(!isset($this->inputs[$name]))
            {
               $class = 'PandaForm2Input'.$type;
               $this->inputs[$name] = new $class($name, $this);
               if($type == 'hidden')
               {
                  $this->hidden[$name] = $this->inputs[$name];
               }
            }
            
            return $this->inputs[$name];
            
        }
        



}

class PandaForm2Input
{
    var $name;
    var $form;
    var $title;
    var $cols = 10;
    var $nolabel = 0;
    var $value;
    var $errors = null;
    
    var $required = 0;
    
    function __construct($name, &$form) {
        $this->name = $name;
        $this->form = $form;
        $this->value = $this->form->values[$this->name];
    }
    
    function isValid()
    {
        if($this->required) { if(trim($this->value) == "") { $this->errors[] = 'To pole nie może być puste'; return 0; } }
		
                
        return 1;
    }
    
    
    
    function show()
    {
        $haserrors = '';
        if($this->title == "") { $this->title = $this->name; }
        
        $this->value = $this->form->values[$this->name];
         if(is_array($this->errors)) { $haserrors = 'has-error'; }
        
        $ret = '<div class="form-group '.$haserrors.'" >';
        
        if(!$this->nolabel)
        {
            $ret.='<label for="'.$this->form->name.'_'.$this->name.'" class="col-sm-2 control-label">'.$this->title.'</label>';
            $ret.='<div class="col-sm-'.$this->cols.'">';
        }
        else
        {
            $ret.='<div class="col-sm-offset-2 col-sm-'.$this->cols.'">';
        }
        $ret .= $this->print_feld();
        if(is_array($this->errors))
        {
            foreach($this->errors as $val)
            {
                $ret .= '<span  class="help-block">'.$val.'</span>';
            }
            
            
        }
        $ret .='</div>
    </div>';
        
        return $ret;
    }
    
    function &title($title) { $this->title = $title; return $this; }
    function &value($value) { $this->value = $value; $this->form->values[$this->name] = $value; return $this; }
    function &required($value=1) { $this->required = $value; return $this; }
}        
        


class PandaForm2InputText extends PandaForm2Input
{
    function print_feld()
    {
        return '<input type="input" class="form-control" name="'.$this->form->name.'['.$this->name.']" id="'.$this->form->name.'_'.$this->name.'" value="'.$this->value.'">';
    }
}

class PandaForm2InputHidden extends PandaForm2Input
{
    function print_feld()
    {
        $this->value = $this->form->values[$this->name];
        return '<input type="hidden"  name="'.$this->form->name.'['.$this->name.']" id="'.$this->form->name.'_'.$this->name.'" value="'.$this->value.'">';
    }
}


class PandaForm2InputSubmit extends PandaForm2Input
{
    var $nolabel = 1;
    function print_feld()
    {
        return '<button type="submit" class="btn btn-default" name="'.$this->form->name.'['.$this->name.']" id="'.$this->form->name.'_'.$this->name.'" value="submit">'.$this->title.'</button>';
    }
}

class PandaForm2InputTextarea extends PandaForm2Input
{
    var $rows = 3;
    function print_feld()
    {
         return '<textarea  class="form-control" rows="'.$this->rows.'" name="'.$this->form->name.'['.$this->name.']" id="'.$this->form->name.'_'.$this->name.'">'.$this->value.'</textarea>';
    }
    
    function &rows($rows)
    {
        $this->rows = $rows;
        return $this;
    }
}

class PandaForm2InputRichTextarea extends PandaForm2Input
{
    var $rows = 3;
    function print_feld()
    {
        
        $HeadMod = Getinstance('HeadMod');
        $HeadMod->js('tinymce/tinymce.min.js');
        $HeadMod->script("tinymce.init({ "
                . "selector:'textarea#".$this->form->name."_".$this->name."',"
                . "language: 'pl',"
                . "plugins: ['advlist autolink lists link charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime  table contextmenu paste code'],"
                . " });");
         return '<textarea  class="form-control" rows="'.$this->rows.'" name="'.$this->form->name.'['.$this->name.']" id="'.$this->form->name.'_'.$this->name.'">'.$this->value.'</textarea>';
    }
    
    function &rows($rows)
    {
        $this->rows = $rows;
        return $this;
    }
}

class PandaForm2InputDate extends PandaForm2Input
{
    var $cols = 2;
    function print_feld()
    {
        if($this->value == "") { $this->value = date("Y-m-d");}
             
        $HeadMod = Getinstance('HeadMod');
        $HeadMod->js('jquery-ui.min.js');
        $HeadMod->css('jquery-ui.min.css');
        $HeadMod->script('$( function() {
    $( "#'.$this->form->name.'_'.$this->name.'" ).datepicker({
              showWeek: true,
              firstDay: 1,
              dateFormat:"yy-mm-dd"
});
        
  } );');
        
        return '<input type="input" class="form-control" name="'.$this->form->name.'['.$this->name.']" id="'.$this->form->name.'_'.$this->name.'" value="'.$this->value.'">';
    }
}

class PandaForm2InputSelect extends PandaForm2Input
{
    var $options = array();
    var $allowAddNew = 0;
    function print_feld()
    {
        $ret = '<select   class="form-control" name="'.$this->form->name.'['.$this->name.']" id="'.$this->form->name.'_'.$this->name.'" value="'.$this->value.'">';
        
        foreach($this->options as $val)
        {
            $ret .= $val->print_feld().'\n';
        }
        
        $ret .='</select>';
        
        if($this->allowAddNew)
        {
            
            $router = getInstance('PandaRouter');
		
            
             $HeadMod = Getinstance('HeadMod');
        $HeadMod->script('
           function addOption(event, str,feld) {
  var xhttp;
  if(event.keyCode == 13)
  {
  
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() 
    {
   
    if (xhttp.readyState == 4 && xhttp.status == 200) 
    {
     
      if(xhttp.responseText != "")
      {
       
          $(\'#'.$this->form->name.'_'.$this->name.'\').append(xhttp.responseText);

          $(\'#'.$this->form->name.'_'.$this->name.'_Modal\').modal(\'hide\');
      }
    };
    }
   
  xhttp.open("GET", "'.HTTP_BASE_URL.'/'.$router->dir.'/addOption/"+str+"/"+feld, true);
  xhttp.send();   
     
    }
    
     
    }
               ');
        
        
            $this->form->beforeForm .= '<div class="modal fade" tabindex="-1" role="dialog" id="'.$this->form->name.'_'.$this->name.'_Modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Dodaj opcję</h4>
      </div>
      <div class="modal-body">
        Nazwa opcji: <input  autofocus onkeyup="addOption(event,this.value,\''.$this->form->name.'_'.$this->name.'\');" width: 100%;" type="text" id="'.$this->form->name.'_'.$this->name.'_addnewoption"/>
      </div>

    </div>
  </div>
</div>';
          
            $ret .= '<a href="#" data-toggle="modal" data-target="#'.$this->form->name.'_'.$this->name.'_Modal" ">Dodaj nową opcję</a> ';
        }
        
        
        return $ret;
    }
    
    function &addOption($name,$value=null)
    {
        $this->options[$name] = new PandaForm2InputSelectOption($name,$value,$this); 
        return $this;
    }
    function &addOptions($options)
    {
        if(isset($options[0]['name']))
        {
            foreach($options as $val)
            {
                if(!isset($val['value']) && isset($val['id'])) { $val['value'] = $val['id']; }
                $this->options[$val['name']] = new PandaForm2InputSelectOption($val['name'],$val['value'],$this); 
                
            }   
        }
        else
        {
           foreach($options as $key=>$val)
            {
                $this->options[$key] = new PandaForm2InputSelectOption($key,$val,$this); 
                
            }  
        }
        return $this;
        
    }
    
    function allowAddNew($value=1)
    {
        $this->allowAddNew = $value;
        return $this;
    }
    
}

class PandaForm2InputSelectOption 
{
    var $name;
    var $value;
    var $parent;
    function __construct($name, $value,&$parent) {
        $this->name = $name;
        if($value == null) { $value = $name;}
        $this->value = $value;
        $this->parent = $parent;
    }
    
    function print_feld()
    {
        $checked = "";
        if($this->parent->value == $this->value)
        {
            $checked = "selected";
        }
       
        return '<option value="'.$this->value.'" '.$checked.'>'.$this->name.'</option>';
    }
    
}