<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//
// Company: Cloudmanic Labs, LLC
// Website: http://cloudmanic.com
//

/* ---------------- UI Widgets -------------------------------------- */

//
// Print a widget start
//
if ( ! function_exists('ui_widget_start'))
{
	function ui_widget_start($classes = '')
	{
		return '<div class="ui-widget ' . $classes . '">';	
	}
}

//
// Print a widget end
//
if ( ! function_exists('ui_widget_end'))
{
	function ui_widget_end()
	{
		return '</div>';	
	}
}

//
// Print a widget header
//
if ( ! function_exists('ui_widget_header'))
{
	function ui_widget_header($html = '', $classes = '')
	{
		return '<div class="ui-widget-header ui-corner-top ' . $classes . '" >' . $html . '</div>';	
	}
}

//
// Print a widget container start
//
if ( ! function_exists('ui_widget_container_start'))
{
	function ui_widget_container_start($classes = '')
	{
		return '<div class="ui-widget-content ' . $classes . '" >';	
	}
}

//
// Print a widget container end
//
if ( ! function_exists('ui_widget_container_end'))
{
	function ui_widget_container_end()
	{
		return '</div>';	
	}
}

/* -------------------- UI System Messages --------------------------- */

//
// Print and return highlighted system message.
//
if ( ! function_exists('ui_message_notice'))
{
	function ui_message_notice($msg = '')
	{
		$html = '<div class="ui-widget">';
		$html .= '<div class="ui-state-highlight ui-corner-all" style="padding: .5em .7em;">'; 
		$html .= '<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>' . $msg . '</p>';
		$html .= '</div></div>';
		return $html;
	}
}

//
// Print and return an error message.
//
if ( ! function_exists('ui_message_error'))
{
	function ui_message_error($msg = '')
	{
		$html = '<div class="ui-widget">';
		$html .= '<div class="ui-state-error ui-corner-all" style="padding: .5em .7em;">'; 
		$html .= '<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>' . $msg . '</p>';
		$html .= '</div></div>';
		return $html;
	}
}

/* ------------------- UI Buttons, Links, Icons ---------------------- */

//
// This function returns a ui linked icon For the icon name hover over the icons on this page http://jqueryui.com/themeroller/.
//
if ( ! function_exists('ui_link_icon'))
{
	function ui_link_icon($url, $icon = 'newwin')
	{
		return '<a href="' . $url . '" class="ui-state-default ui-corner-all ui-link-text">' .
						'<span class="ui-icon ui-icon-' . $icon . ' ui-icon-link"></span></a>';
	}
}

//
// This function returns a ui-formated link with a Right icon. For the icon name hover over the icons on this page http://jqueryui.com/themeroller/.
//
if ( ! function_exists('ui_link_right_icon'))
{
	function ui_link_right_icon($name, $url, $icon = 'newwin')
	{
		return '<a href="' . $url . '" class="ui-state-default ui-corner-all ui-link-text ui-link-icon-right">' .
						'<span class="ui-icon ui-icon-' . $icon . ' ui-icon-right"></span>' . $name . '</a>';
	}
}

//
// This function returns a ui-formated link with a left icon. For the icon name hover over the icons on this page http://jqueryui.com/themeroller/.
//
if ( ! function_exists('ui_button_right_icon'))
{
	function ui_button_right_icon($name, $icon = 'newwin')
	{
		return '<button class="ui-state-default ui-corner-all ui-link-text ui-link-icon-right">' .
						'<span class="ui-icon ui-icon-' . $icon . ' ui-icon-right"></span>' . $name . '</button>';
	}
}

//
// This function returns a ui-formated link with a left icon. For the icon name hover over the icons on this page http://jqueryui.com/themeroller/.
//
if ( ! function_exists('ui_link_left_icon'))
{
	function ui_link_left_icon($name, $url, $icon = 'newwin')
	{
		return '<a href="' . $url . '" class="ui-state-default ui-corner-all ui-link-text ui-link-icon-left">' .
						'<span class="ui-icon ui-icon-' . $icon . ' ui-icon-left"></span>' . $name . '</a>';
	}
}

//
// This function returns a ui-formated link with a left icon. For the icon name hover over the icons on this page http://jqueryui.com/themeroller/.
//
if ( ! function_exists('ui_button_left_icon'))
{
	function ui_button_left_icon($name, $icon = 'newwin')
	{
		return '<button class="ui-state-default ui-corner-all ui-link-text ui-link-icon-left">' .
						'<span class="ui-icon ui-icon-' . $icon . ' ui-icon-left"></span>' . $name . '</button>';
	}
}

//
// This function returns a ui-formated link. 
//
if ( ! function_exists('ui_link_text'))
{
	function ui_link_text($name, $url, $class = '')
	{
		return '<a href="' . $url . '" class="ui-state-default ui-corner-all ui-link-text ' . $class . '">' . $name . '</a>';
	}
}

//
// This function returns a ui-formated button. 
//
if ( ! function_exists('ui_button_text'))
{
	function ui_button_text($name, $class = '')
	{
		return '<button class="ui-state-default ui-corner-all ' . $class . '" name="submit" value="true">' . $name . '</button>';
	}
}


//
// Stuff that should get stuffed in the html header to help support jquery Ui widgets. ie. hover states.
//
if ( ! function_exists('ui_init'))
{
	function ui_init()
	{
		$html = '<script type="text/javascript">';
		$html .= '$(document).ready(function () {';
		$html .= '$(".ui-state-default").hover(';
		$html .= 'function() { $(this).addClass("ui-state-hover"); },'; 
		$html .= 'function() { $(this).removeClass("ui-state-hover"); }';
		$html .= ');';		
		$html .= '})</script>';
		return $html;
	}
}

/* End File */