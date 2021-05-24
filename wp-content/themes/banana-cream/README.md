[![codebeat badge](https://codebeat.co/badges/a4288d45-d34f-4d4d-a200-9dd7414c5806)](https://codebeat.co/projects/github-com-nexpress-banana-cream) [![Code Climate](https://codeclimate.com/github/nexpress/banana-cream/badges/gpa.svg)](https://codeclimate.com/github/nexpress/banana-cream) [![Test Coverage](https://codeclimate.com/github/nexpress/banana-cream/badges/coverage.svg)](https://codeclimate.com/github/nexpress/banana-cream/coverage) [![Issue Count](https://codeclimate.com/github/nexpress/banana-cream/badges/issue_count.svg)](https://codeclimate.com/github/nexpress/banana-cream) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nexpress/banana-cream/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/nexpress/banana-cream/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/nexpress/banana-cream/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/nexpress/banana-cream/?branch=master)

# Getting Started
1. A more comprehensive list can be found in the themes help tab (/wp-admin/themes.php)
1. Go through the customizer options and ensure they are all applicable and set correctly
1. Make sure the nav menus are according to the BRS
1. Don't update colors via the customizer (make changes in css/sass/_variables.scss)
1. Navigate to the entries page via the customizer... and modify the contents of the Sidebar called "Content Header"
1. Add the Search Widget to the Sidebar
1. For additional setup help, view the **Help** tab on the Themes Admin Page (/wp-admin/themes.php)

# Getting Started for afrikaans sites
1. Navigate to the General Settings Page (/wp-admin/options-general.php)
1. Set Site language to "af_ZA"
1. Click the "Save Changes button..."


## Gravity Forms
1. Ensure your plugin is activated.
1. Follow the additional Gravity Forms activation steps 
1. Prevent Gravity Forms from spitting out their CSS
1. Import the existing forms from **export** folder
1. Add in the [ReCaptcha Settings](https://touchlabprojects.atlassian.net/wiki/display/OS/Setting+Up+ReCaptcha)
1. For more information on gravity forms, see our [documentation](https://touchlabprojects.atlassian.net/wiki/display/OS/Gravity+Forms)



## Yoast SEO
- refer to our [documentation](https://touchlabprojects.atlassian.net/wiki/display/OS/Yoast+SEO) for setup instructions
- Additional Yoast OG configs can be done via the customizer


## WP Admin Configuration
you will need to run through the following to ensure the theme functions optimally

1. [Permalink Options](http://fixit.tuis.co.za/wp-admin/options-permalink.php)
    1. Day and name
    
1. [Timezone setting in WordPress](http://fixit.tuis.co.za/wp-admin/options-general.php)


1. Google AnalyticsTracking
    1. Refer to the [README in tf-core](https://bitbucket.org/24dotcom/tf-core)
 
 
# Building
```
npm install && bower install && grunt
```

# Grunt
## Javascript
- you will notice that in the js folder there are 4 files
    - functions.jsx
    - bundle.min.js
    - bundle.js
    - compiled.js
   
- Custom js code must be added to functions.jsx
    - If any changes have been made to the above file, you must compile it with grunt
    - just run the command ``grunt`` in the theme root

- compiled.js is the functions.jsx file compiled

- bundle.js and bundle.min.js contains ALL UI Kit javascript files required and any custom js you've added to functions.jsx


## Features

### Pages
1. Home
1. About
1. Enter
1. Entries
1. Rules
1. Sponsors
1. Contact Us


### Menu Locations
1. Below Header
1. Header Overlay (Web Only)
1. Off Canvas



### Menus
Menus are automatically created with the default pages as items and assigned to the Menu Locations above


## Categories
1. Finalists
1. Semi-Finalists


### Custom Post Type
Automatically creates the 'entry' post type using TF Core's post type registration


## Voting / Business Rules
see TF_GF_Field_Email_Addons README.md
1. Restrict to x duplicate email address(es) per entry
1. Restrict to x duplicate email address(es) per entry per day
1. Restrict to x duplicate email address(es) irrespective of entry



## Benefits - Developers
1. Loads of Templates
- Easy to override in a child theme
- Loads of Customizer options to minimize dev work
- Documented well
- Easily Translatable
- Unit Tested
- Custom Gravity Forms Controls to ease dev work ( Photo, Terms and Conditions, Post ID )

1. Minified assets and Non-minified assets for debugging
- Uses WP Debugging jizz

1. Loads of options to customize wordpress
- See the editors benefits


1. Additional Settings
- Comments and ReCaptcha

1. Widgets
- New Search Widget. Customizable button, placeholder... extendable
    - Uses default functionality as a fallback


1. Helper Classes and HTML
- allows users to override the html used in plugins (see TF_Gravity_Forms::get_form_html)

- TF_Widget

- TF_Template

- TF_Widget_Search

- TF_Comments
    - provides a much better comment ui as default, overridable ofcourse
    - Options for reCAPTCHA (built into discussion)

- TF_Customizer
    - easily add settings to the customizer. keeps our code customizer plugin agnostic
    
- TF_Debug
    - log our own info to debug logs

1. Fallbacks
- Tried to use as many fallbacks as possible to cater for edge cases
- Debug info available for functions to do not fire successfully

1. Afrikaans
- Easily translatable
- Makes use of the common tf-languages repo
- Tried to wrap all visible dev text on the screen in translator functions

1. Must use plugins / Plugin activation steps
- Eliminates the need to activate plugins
- tf-core is being used as a mu-plugin
- kirki is embedded into the theme, this plugin allows for this


## Benefits - Editors and Product Owners
1. Post Previewing 
- More inline with the site styles
- Gives a better reflection of what the post will look like once published

1. Spam
- Forget it
- Uses an Anti-Spam HoneyPot for Comments AND Gravity Forms 
- Uses ReCaptcha

1. Customizer Options 
 - 404 page


# Setting up your Child Theme
1. Create another directory within your themes folder and name it the name of your new child theme
1. Create two files within this directory
    - functions.php
    - style.css
    - Ensure you make use of the **Template** attribute in your stylesheet
1. Make the necessary style changes in style.css
1. Enqueue this new stylesheet in your functions.php
   
   ```
    add_action('wp_enqueue_scripts', function(){
    	wp_enqueue_style( 'bc-child-style', get_stylesheet_uri());
    },101);
   ```


# Existing Features on other sites

| Feature                                                           | 30 Days | 30 Days Weg | Toyota GoMag | Toyota Weg | HotShots  | HotShots Weg | FixIt | Matriek   | Bruidspaar | "Voorbladgesig" | Exportable | Done |
|-------------------------------------------------------------------|---------|-------------|--------------|------------|-----------|--------------|-------|-----------|------------|-----------------|------------|------|
| Site Container Width                                              | YES     | YES         | YES          | YES        | YES       | YES          | YES   | YES       | YES        | YES             | YES        | YES  |
| Header Image                                                      | YES     | YES         | YES          | YES        | YES       | YES          | YES   | YES       | NO         | YES             | YES        | YES  |
| Header Clickable                                                  | YES     | YES         | YES          | YES        | YES       | YES          | YES   | YES       | NO         | YES             | YES        | YES  |
| Header Extra Logos                                                | YES     | YES         | NO           | NO         | NO        | NO           | YES   | NO        | NO         | NO              | YES        | YES  |
| Primary Menu                                                      | YES     | YES         | YES          | YES        | YES       | YES          | YES   | YES       | YES        | YES             | YES        | YES  |
| Primary Menu Width                                                | 5/6     | 5/6         | CONTAINER    | CONTAINER  | CONTAINER | YES          | YES   | CONTAINER | FULL       | YES             | YES        | YES  |
| Footer                                                            | NO      | NO          | NO           | NO         | NO        | NO           | YES   | NO        | YES        | NO              | YES        | YES  |
| Background Image                                                  | NO      | NO          | YES          | YES        | YES       | YES          | YES   | YES       | YES        | YES             | YES        | YES  |
| Background Clickable                                              | NO      | NO          | YES          | YES        | YES       | YES          | YES   | NO        | NO         | YES             | YES        | YES  |
| Vote                                                              | NO      | NO          | YES          | YES        | NO        | NO           | YES   | ?         | YES        | ?               | YES        | YES  |
| Vote Auto Close                                                   | NO      | NO          | NO           | NO         | NO        | NO           | YES   | ?         | ?          | ?               | YES        | YES  |
| Rate                                                              | NO      | NO          | YES          | YES        | NO        | NO           | YES   | YES       | NO         | ?               | YES        | YES  |
| Rate Auto Close                                                   | NO      | NO          | NO           | NO         | NO        | NO           | YES   | YES       | NO         | ?               | YES        | YES  |
| Enter                                                             | YES     | YES         | YES          | YES        | YES       | YES          | YES   | YES       | YES        | YES             | YES        | YES  |
| Nominate Entry Form                                               | NO      | NO          | NO           | NO         | NO        | NO           | YES   | YES       | ?          | ?               | YES        | YES  |
| Entries - Seach Bar                                               | NO      | NO          | YES          | YES        | YES       | YES          | YES   | YES       | YES        | ?               | YES        | YES  |
| Entries Listing - Mosaic                                          | NO      | NO          | YES          | YES        | YES       | YES          | YES   | NO        | NO         | NO              | YES        | YES  |
| Entries Listing - Cropped Thumbnail                               | NO      | NO          | YES          | YES        | NO        | NO           | YES   | NO        | NO         | ?               | YES        | YES  |
| Entries Listing - Paged                                           | NO      | NO          | YES          | YES        | YES       | YES          | YES   | NO        | YES        | ?               | YES        | NO   |
| Entries - Shareable                                               | NO      | NO          | YES          | YES        | YES       | YES          | YES   | YES       | YES        | YES             | YES        | YES  |
| Entries Comments                                                  | NO      | NO          | NO           | NO         | NO        | NO           | YES   | NO        | YES        | NO              | YES        | NO   |
| Prizes                                                            | YES     | YES         | YES          | YES        | YES       | YES          | YES   | YES       | NO         | NO              | YES        | NO   |
| Upload Photos                                                     | NO      | NO          | YES          | YES        | YES       | YES          | YES   | YES       | YES        | YES             | YES        | NO   |
| Upload Photos Count                                               | NO      | NO          | 3            | 3          | 1         | 1            | YES   | YES       | 3          | 3               | YES        | NO   |
| Photo Lightbox                                                    | NO      | NO          | YES          | YES        | YES       | YES          | YES   | ?         | ?          | ?               | YES        | YES  |
| Manual Set Primary Photo                                          | NO      | NO          | YES          | YES        | NO        | NO           | YES   | NO        | NO         | YES             | YES        | NO   |
| Gravity Forms                                                     | YES     | YES         | YES          | YES        | YES       | YES          | YES   | ?         | YES        | YES             | YES        | YES  |
| Ads                                                               | NO      | NO          | NO           | NO         | NO        | NO           | NO    | NO        | NO         | NO              | NO         | YES  |
| Semi Finalists                                                    | NO      | NO          | YES          | YES        | YES       | YES          | YES   | ?         | ?          | YES             | YES        | YES  |
| Finalists                                                         | NO      | NO          | YES          | YES        | YES       | YES          | YES   | ?         | ?          | YES             | YES        | YES  |
| Afrikaans                                                         | NO      | YES         | NO           | NO         | NO        | YES          | YES   | YES       | YES        | YES             | YES        | NO   |
| Multiple Email Entries                                            | YES     | YES         | NO           | NO         | YES       | YES          | YES   | ?         | NO         | NO              | YES        | YES  |
| Single Email Entry Per Day                                        | YES     | YES         | YES          | YES        | YES       | YES          | YES   | ?         | YES        | YES             | YES        | YES  |
| Import Theme Settings                                             | NO      | NO          | NO           | NO         | NO        | NO           | NO    | NO        | NO         | NO              | YES        | NO   |
| Export Theme Settings                                             | NO      | NO          | NO           | NO         | NO        | NO           | NO    | NO        | NO         | NO              | YES        | NO   |
| Image Upload Overlays                                             | NO      | NO          | YES          | YES        | NO        | NO           | YES   | YES       | ?          | ?               | YES        | NO   |
| Custom GF Columns                                                 | YES     | YES         | YES          | YES        | YES       | YES          | YES   | YES       | NO         | YES             | YES        | NO   |
| Theme Stylesheet in MCE Editor                                    | NO      | NO          | NO           | NO         | NO        | NO           | NO    | NO        | NO         | NO              | YES        | YES  |


# Upcoming
- Sassing from the admin side
- Merging with tf-master