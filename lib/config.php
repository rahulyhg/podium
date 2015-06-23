<?php
namespace Podium\Config;

class PodiumCoreProperties{
	
	function __construct() {
		$this->templateUrl = $this->getTemplateURL(); // set property so that we can access it from child class
	}
	private function getTemplateURL() {
		return basename( get_page_template() ); // get the template file url ( example: test.php )
	}
	
}

class Settings extends PodiumCoreProperties {
	
	// make chnages to this method
	private function excludedSidebarSettings() {
		
		// Sidebars will be displayed by default. to explode some pages change these settings
		
		$excludedRules = array();
		
		// Add to this list to remove the sidebar from template files.
		$excludedRules['excludeByFileName'] = [
			// 'test.php',
			// 'page.php',
		];
		
		// Add to this list to remove the sidebar by post type.
		$excludedRules['excludeByPostByType'] = [
			// 'page',
			// 'cart',
		];
		
		// Add to this list to remove the sidebar by taxonomy ID.
		$excludedRules['excludeByTaxonomyID'] = [
			// '43',
			// '1234',
		];
		
		// Add to this list to remove the sidebar from pages by ID.
		// note: NOT recommended to use this feature. Use only if you have no choice.
		//       however you can add dynamic functionality to this file.
		$excludedRules['excludeByPostID'] = [
			// '2',
			// '256',
			// '823',
		];
		
		// Add to this list to remove the sidebar from categories by ID.
		// note: NOT recommended to use this feature. Use only if you have no choice. 
		//       however you can add dynamic functionality to this file.
		$excludedRules['excludeByCategoryID'] = [
			// 2,
			// '5',
			// '12',
		];

		return $excludedRules;
	}
	public function displaySidebar() { // return bool
	
		$rules = $this->excludedSidebarSettings(); // get rules from private function
		$postType = get_post_type();
		$postID = get_the_ID();

		foreach(get_the_category() as $category){
			$taxonomyID = $category->term_id;
			$categoryID = $category->cat_ID;
			break;
		}
		
		if( in_array($this->templateUrl, $rules['excludeByFileName']) ){ // if the current template has been excluded
			return false;
		} elseif( in_array($postType, $rules['excludeByPostByType']) ){
			return false;
		} elseif( in_array($taxonomyID, $rules['excludeByTaxonomyID']) ){
			return false;
		} elseif( in_array($postID, $rules['excludeByPostID']) ){
			return false;
		}  elseif( in_array($categoryID, $rules['excludeByCategoryID']) ){
			return false;
		} else {
			return true;
		}
		
	}
	public function getContentClass($contentHasSidebarClass = 'medium-8', $contentNoSidebarClass = 'medium-12') { // return bool
	
		if( $this->displaySidebar() ){
			return $contentHasSidebarClass;
		} else{
			return $contentNoSidebarClass;
		}
		
	}
	
}
