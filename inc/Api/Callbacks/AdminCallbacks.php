<?php

/**
 * @package CRivasPlugin
 */

namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class AdminCallbacks extends BaseController
{
  public function adminDashboard()
  {
    return require_once("$this->plugin_path/templates/admin.php");
  }

  public function adminCpt()
	{
		return require_once( "$this->plugin_path/templates/cpt.php" );
	}
  
  public function adminTaxonomyManager()
	{
		return require_once( "$this->plugin_path/templates/taxonomymanager.php" );
	}
  
  public function adminMediaManager()
	{
		return require_once( "$this->plugin_path/templates/mediamanager.php" );
	}
  
  public function adminGalleryManager()
	{
		return require_once( "$this->plugin_path/templates/gallerymanager.php" );
	}
  
  public function adminTestimonialManager()
	{
		return require_once( "$this->plugin_path/templates/testimonialmanager.php" );
	}
  
  public function adminTemplatesManager()
	{
		return require_once( "$this->plugin_path/templates/templatemanager.php" );
	}
  
  public function adminLoginManager()
	{
		return require_once( "$this->plugin_path/templates/loginmanager.php" );
	}
  
  public function adminMembershipsManager()
	{
		return require_once( "$this->plugin_path/templates/membershipsmanager.php" );
	}
  
  public function adminChatsManager()
	{
		return require_once( "$this->plugin_path/templates/chatsmanager.php" );
	}

  public function crivasTextExample()
  {
    $value = esc_attr(get_option('text_example'));
    echo '<input type="text" class="regular-text" name="text_example" value="'.$value.'" placeholder="Write something Here!"/>';
  }

  public function crivasText1Example()
  {
    $value = esc_attr(get_option('first_name'));
    echo '<input type="text" class="regular-text" name="first_name" value="'.$value.'" placeholder="Write something Here!"/>';
  }
}
