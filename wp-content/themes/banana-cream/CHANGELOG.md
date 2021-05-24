# v4.2.0 #
- Fixed Bayesian calculations
- Fixed Total Ratings and Total Voting counts
- Added support to force the rechecking of the bayesian calculation using ``/wp-admin/?bayesian_refresh```


---


# v4.1.1 #
- Fixed php strict errors on BananaCream::tf_register_custom_entry_meta_box()


---


# 3.25.0
- Versioning
    - rebased all versions and since statements to 3.25.0 (purely cause of the date)
    - implemented doc blocks for every function inside BananaCream class
    - set the package.json version to 3.25.0
    - set the theme version to 3.25.0

- Header Images
    - If no mobile header image is set, use the web header image
    
- Off canvas menu
    - independent of the header overlay menu
    - can have the header overlay menu & the off canvas, none, or either or
    - Used as much uikit variables as possible
    
- Child Theme Colors
    - can now override the offcanvas menu colors used

- UI Kit Sass Variables
    - more overriding variables to cater for the off canvas menu functionality
    
- Templates
    - 2 more templates created
        - footer/text
        - header/banner
        
- Sidebars
    - Renamed the Footer Sidebar to FrontPage Sidebar
    
- Refactoring
    - moved standalone function ``get_background_branding`` to the BananaCream class 