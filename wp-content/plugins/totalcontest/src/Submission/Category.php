<?php
namespace TotalContest\Submission;
! defined( 'ABSPATH' ) && exit();


use TotalContestVendors\TotalCore\Taxonomies\Taxonomy;

/**
 * Class Category
 * @package TotalContest\Submission
 */
class Category extends Taxonomy {
	/**
	 * Get taxonomy name.
	 *
	 * @return mixed
	 */
	public function getName() {
		return 'submission_category';
	}

	/**
	 * Get arguments.
	 *
	 * @return mixed
	 */
	public function getArguments() {
		return [
			'labels'             => [
				'name'              => __( 'Categories', 'totalcontest' ),
				'singular_name'     => __( 'Category', 'totalcontest' ),
				'search_items'      => __( 'Search Categories', 'totalcontest' ),
				'all_items'         => __( 'All Categories', 'totalcontest' ),
				'parent_item'       => __( 'Parent Category', 'totalcontest' ),
				'parent_item_colon' => __( 'Parent Category:', 'totalcontest' ),
				'edit_item'         => __( 'Edit Category', 'totalcontest' ),
				'update_item'       => __( 'Update Category', 'totalcontest' ),
				'add_new_item'      => __( 'Add New Category', 'totalcontest' ),
				'new_item_name'     => __( 'New Category Name', 'totalcontest' ),
				'menu_name'         => __( 'Categories', 'totalcontest' ),
			],
			'public'             => false,
			'hierarchical'       => true,
			
			'show_ui'            => true,
			'show_in_quick_edit' => true,
			'show_admin_column'  => true,
			
			
			'query_var'          => false,
			'rewrite'            => [ 'slug' => 'category' ],
		];
	}

	/**
	 * Get post types.
	 *
	 * @return mixed
	 */
	public function getPostTypes() {
		return [ TC_SUBMISSION_CPT_NAME ];
	}

	/**
	 * Register taxonomy.
	 *
	 * @return \WP_Error|\WP_Taxonomy WP_Taxonomy on success, WP_Error otherwise.
	 * @since 1.0.0
	 */
	public function register() {
		parent::register();
		define( 'TC_SUBMISSION_CATEGORY_TAX_NAME', $this->getName() );
	}
}
