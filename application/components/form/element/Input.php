<?php

    namespace application\components\form\element;

    use \Yii;
    use \CException as Exception;

    class Input extends \CFormInputElement
    {

        public static $coreTypes = array(
            // Found in Yii 1.1.14:
            'text'          =>'activeTextField',
            'hidden'        =>'activeHiddenField',
            'password'      =>'activePasswordField',
            'textarea'      =>'activeTextArea',
            'file'          =>'activeFileField',
            'radio'         =>'activeRadioButton',
            'checkbox'      =>'activeCheckBox',
            'listbox'       =>'activeListBox',
            'dropdownlist'  =>'activeDropDownList',
            'checkboxlist'  =>'activeCheckBoxList',
            'radiolist'     =>'activeRadioButtonList',
            'url'           =>'activeUrlField',
            'email'         =>'activeEmailField',
            'number'        =>'activeNumberField',
            'range'         =>'activeRangeField',
            'date'          =>'activeDateField',
            // Found in Yii 1.1.15-dev:
            'time'          => 'activeTimeField',
            'datetime'      => 'activeDateTimeField',
            'datetimelocal' => 'activeDateTimeLocalField',
            'week'          => 'activeWeekField',
            'color'         => 'activeColorField',
            'tel'           => 'activeTelField',
            'search'        => 'activeSearchField',
        );

    }
